<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Models\LogActivity;
use App\Models\MasterDocs;
use App\Models\PathDocument;
use App\Models\PathForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;

class SopInternalController extends Controller
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
        $user = auth()->user();
        $masterdocs = MasterDocs::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        if ($user->role->name === 'owner' || $user->role->name === 'admin') {
            $documents = Documents::with('division', 'jenisDocument')->get();
        } else {
            $documents = DB::table('documents')
                ->join('distribution', 'documents.nodocument', '=', 'distribution.nodocument')
                ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
                ->join('status', 'documents.statusdocument', '=', 'status.id')
                ->join('users', 'documents.verified', '=', 'users.id')
                ->join('department', 'documents.department_id', '=', 'department.id')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_form FROM path_form GROUP BY nodocument) as pf'), 'documents.nodocument', '=', 'pf.nodocument')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_document FROM path_document GROUP BY nodocument) as pd'), 'documents.nodocument', '=', 'pd.nodocument')
                ->where('distribution.user_id', $user->id)
                ->whereIn('master_docs.name', ['Instruksi Kerja', 'Prosedur Mutu', 'Sasaran Mutu'])
                // ->where('documents.nodocument', 'PM-TS-7210')
                ->select(
                    'documents.*',
                    'master_docs.name as jenis_document',
                    'status.name as status',
                    'users.name as verified',
                    'department.name as department',
                    'department.code as deptcode',
                    DB::raw('COALESCE(pf.total_path_form, 0) as total_path_form'),
                    DB::raw('COALESCE(pd.total_path_document, 0) as total_path_document')
                )
                ->get();

            // dd($documents);
        }

        // dd($documents);
        return view('sop_internal.index', compact('documents', 'user', 'masterdocs', 'departments'));
    }

    public function create()
    {
        $user = auth()->user()->role->name;
        $userd = User::all();
        $userapprove = User::whereIn('role_id', [1, 2])->get();
        $department = Department::all();
        $masterdocs = MasterDocs::all();

        if ($user !== 'Admin') {
            return redirect()->route('sop.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        return view('sop_internal.upload', [
            'userd' => $userd,
            'userapprove' => $userapprove,
            'department' => $department,
            'masterdocs' => $masterdocs,
        ]);
    }


    public function store(Request $request)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        $val1 = $request->input('text1');
        $val2 = $request->input('text2');
        $val3 = $request->input('valuedocs2');
        $combinedValue = $val1 . '-' . $val2 . '-' . $val3;
        $masterdocKode = $request->input('masterdocs');
        $departmentKode = $request->input('department');

        $masterdoc = MasterDocs::where('kode', $masterdocKode)->first();
        $department = Department::where('code', $departmentKode)->first();

        $masterdocId = $masterdoc ? $masterdoc->id : null;
        $departmentId = $department ? $department->id : null;

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
            'files' => 'file|mimes:pdf,docx,jpeg,png|max:2048',
            'files2' => 'file|mimes:pdf,docx,xls|max:5048',
        ]);

        try {
            DB::beginTransaction();

            $caption = config('custom.cap_create_document');
            $data1 = $combinedValue;
            $data2 = 'Documents : ';
            $detail = $caption . $data2 . $data1;

            Documents::create([
                'jenis_document_id' => $masterdocId,
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
            return redirect()->route('sop.index')->with('success', 'Dokumen berhasil diupload!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function show(string $id)
    {
        $decryptID = Crypt::decryptString($id);

        $docs = DB::table('documents')
            ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
            ->join('department', 'documents.department_id', '=', 'department.id')
            ->join('users', 'documents.verified', '=', 'users.id')
            ->join('status', 'documents.statusdocument', '=', 'status.id')
            ->where('documents.nodocument', $decryptID)
            ->select(
                'documents.id',
                'documents.nodocument as nodocs',
                'documents.namadocument as namadocs',
                'documents.deskripsi as desc',
                'documents.path as path',
                'documents.tanggal_berlaku as berlaku',
                'documents.revisidocument as revisi',
                'documents.created_at',
                'documents.updated_at',
                'master_docs.name as namajenis',
                'department.name as namadept',
                'users.name as verified',
                'status.name as status'
            )
            ->first();
        // dd($docs);
        return response()->json(['data' => $docs]);
    }


    public function detail($id)
    {
        try {
            $decryptID = Crypt::decryptString($id);
            // dd($decryptID);

            $document = DB::table('documents')
                ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
                ->join('department', 'documents.department_id', '=', 'department.id')
                ->join('users', 'documents.verified', '=', 'users.id')
                ->join('status', 'documents.statusdocument', '=', 'status.id')
                ->where('documents.nodocument', $decryptID)
                ->select(
                    'documents.id',
                    'documents.nodocument as nodocs',
                    'documents.namadocument as namadocs',
                    'documents.deskripsi as desc',
                    'documents.path as path',
                    'documents.tanggal_berlaku as berlaku',
                    'documents.revisidocument as revisi',
                    'documents.created_at',
                    'documents.updated_at',
                    'master_docs.name as namajenis',
                    'department.name as namadept',
                    'users.name as verified',
                    'status.name as status'
                )
                ->first();


            if (!$document) {
                dd("Dokumen tidak ditemukan: " . $decryptID);
            }

            // dd($document);

            $user = auth()->user()->role->name;
            $userd = User::all();
            $userapprove = User::whereIn('role_id', [1, 2])->get();
            $department = Department::all();
            $masterdocs = MasterDocs::all();
            $docs = Documents::where('nodocument', $decryptID)->first();
            $path_document = PathDocument::where('nodocument', $decryptID)->get(['name', 'path']);
            $path_form = PathForm::where('nodocument', $decryptID)->get(['name', 'path']);

            $distribusi = Distribution::where('nodocument', $decryptID)
                ->pluck('user_id')
                ->toArray();

            // dd($distribusi);

            // dd($user);

            return view('sop_internal.detail', [
                'userd' => $userd,
                'userx' => $user,
                'userapprove' => $userapprove,
                'department' => $department,
                'masterdocs' => $masterdocs,
                'document' => $document,
                'path_document' => $path_document,
                'path_form' => $path_form,
                'docs' => $docs,
                'distribusi' => $distribusi
            ]);
        } catch (\Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }


    public function edit(string $nodocument)
    {
        $user = auth()->user();
        $decryptID = Crypt::decryptString($nodocument);
        $data = Documents::find($decryptID);

        // dd($data);

        if ($user->role->name !== 'admin') {
            return redirect()->route('sop.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        return view('sop_internal.edit', compact('data', 'user'));
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        $user = auth()->user();

        if ($user->role->name !== 'Admin') {
            return redirect()->route('sop.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        try {
            DB::beginTransaction();
            $data = Documents::find($id);

            $caption = config('custom.cap_delete_document');
            $data1 = $data['nodocument']; //Sesuain Key
            $data2 = 'Document : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;
            // dd($detail);
            if ($data) {
                $data->delete();
            }
            logActivity::create([
                'log_id' => $idlog,
                'activity' => 'Delete',
                'description' => $detail,
                'user_id' => $this->userid,
            ]);
            DB::commit();
            return redirect()->route('sop.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
