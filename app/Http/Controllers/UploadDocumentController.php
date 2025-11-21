<?php

namespace App\Http\Controllers;

use App\Models\PathDiagram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Models\LogActivity;
use App\Models\MasterCategoryDocs;
use App\Models\MasterDocs;
use App\Models\PathDocument;
use App\Models\PathForm;
use App\Models\User;

class UploadDocumentController extends Controller
{
    protected $userid;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::check() ? Auth::user()->id : null;
            return $next($request);
        });
    }


    public function index()
    {
        $user = auth()->user()->role->name;
        $userd = User::all();
        $userapprove = User::whereIn('role_id', [1, 2])->get();
        $department = Department::all();
        // $masterdocs = MasterDocs::all();
        $categories = MasterCategoryDocs::with('types')->get();

        if ($user !== 'Admin') {
            return redirect()->route('dashboard.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }
        // dd($user);

        return view('docs_upload_document.index', [
            'userd' => $userd,
            'userapprove' => $userapprove,
            'department' => $department,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('docs_upload_document.manual');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        $val1 = $request->input('text1');
        $val2 = $request->input('text2');
        $val3 = $request->input('valuedocs2');
        $combinedValue = $val1 . '-' . $val2 . '-' . $val3;

        $mastercatKode = $request->input('category');
        $masterdocKode = $request->input('masterdocs');
        $departmentKode = $request->input('department');

        $department = Department::where('code', $departmentKode)->first();
        $departmentId = $department ? $department->id : null;
        // dd($categories, $masterdoc, $department);

        $approval = $request->input('role');
        $verified = '';
        if ($approval == 'Tanpa-Approval') {
            $approval = 0;
            $verified = 1;
        } else {
            $verified = 0;
        }

        // dd($approval, $this->userid, $verified);

        $request->validate([
            'namadocs' => 'required',
            'deskripsi' => 'required',
            'valuedocs2' => 'required',
            'tanggal_berlaku' => 'required|date',
            'tanggal_review' => 'required|date',
            'masterdocs' => 'required',
            'department' => 'required',
            'filesDocument' => 'file|mimes:pdf,docx|max:5048',
            'filesForm' => 'file|mimes:pdf,docx,xls,jpeg,png|max:5048',
            'filesDiagram' => 'file|mimes:pdf,jpeg,png|max:5048',
        ]);

        try {
            DB::beginTransaction();

            $caption = config('custom.cap_create_document');
            $data1 = $combinedValue;
            $data2 = 'Documents : ';
            $detail = $caption . $data2 . $data1;

            Documents::create([
                'category_document_id' => $mastercatKode,
                'jenis_document_id' => $masterdocKode,
                'department_id' => $departmentId,
                'nodocument' => $combinedValue,
                'namadocument' => $request->namadocs,
                'deskripsi' => $request->deskripsi,
                'path' => $combinedValue,
                'tanggal_berlaku' => $request->tanggal_berlaku,
                'tanggal_review' => $request->tanggal_review,
                'statusdocument' => '3',
                'verified' => $verified,
            ]);
            // dd($run);

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $index => $file) {
                    // Ambil nama asli file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $combinedValue . '-' . $index . '.' . $extension;

                    // Simpan ke storage
                    $path = $file->storeAs('documents', $filename, 'public');

                    // Simpan ke database
                    PathDocument::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                    ]);
                }
            }

            if ($request->hasFile('file2')) {
                foreach ($request->file('file2') as $index => $file) {
                    // Ambil nama asli file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $combinedValue . '-' . $index . '.' . $extension;

                    // Simpan ke storage
                    $path = $file->storeAs('forms', $filename, 'public');

                    // Simpan ke database
                    PathForm::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                    ]);
                }
            }

            if ($request->hasFile('file3')) {
                foreach ($request->file('file3') as $index => $file) {
                    // Ambil nama asli file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $combinedValue . '-' . $index . '.' . $extension;

                    // Simpan ke storage
                    $path = $file->storeAs('diagram', $filename, 'public');

                    // Simpan ke database
                    PathDiagram::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                    ]);
                }
            }

            if ($request->has('users')) {
                foreach ($request->users as $userId) {
                    Distribution::create([
                        'nodocument' => $combinedValue,
                        'user_id' => $userId,
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            // Jalankan insert hanya jika verified == 0
            if ($verified == 0) {
                DB::table('permissions')->insert([
                    'resource_type' => 'document',
                    'resource_id' => $combinedValue,
                    'requested_by' => $this->userid,
                    'approved_by' => $approval,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            LogActivity::create([
                'log_id' => $logid,
                'user_id' => $this->userid,
                'activity' => 'Upload',
                'description' => $detail,
            ]);

            DB::commit();
            return redirect()->route('uploaddocs.index')->with('success', 'Dokumen berhasil diupload!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
