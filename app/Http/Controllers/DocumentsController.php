<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Models\LogActivity;
use App\Models\MasterDocs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;

class DocumentsController extends Controller
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
                ->where('distribution.user_id', $user->id)
                ->select('documents.*', 'master_docs.name as jenis_document', 'status.name as status', 'users.name as verified', 'department.name as department', 'department.code as deptcode')
                ->get();
        }

        // dd($documents);
        return view('documents.index', compact('documents', 'user', 'masterdocs', 'departments'));
    }

    public function create()
    {
        $user = auth()->user()->role->name;
        $userd = User::all();
        $userapprove = User::whereIn('role_id', [1, 2])->get();
        $department = Department::all();
        $masterdocs = MasterDocs::all();

        if ($user !== 'Admin') {
            return redirect()->route('mmqa.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        return view('documents.upload', [
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

        $request->validate([
            'namadocs' => 'required',
            'deskripsi' => 'required',
            'valuedocs2' => 'required',
            'tanggal' => 'required|date',
            'masterdocs' => 'required',
            'department' => 'required',
            'file' => 'required|file|mimes:pdf,docx,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $fileName = $combinedValue . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents', $fileName);

            $caption = config('custom.cap_create_document');
            $data1 = $combinedValue;
            $data2 = 'Documents : ';
            $detail = $caption . $data2 . $data1;

            $document = Documents::create([
                'jenis_document_id' => $masterdocId,
                'department_id' => $departmentId,
                'nodocument' => $combinedValue,
                'namadocument' => $request->namadocs,
                'deskripsi' => $request->deskripsi,
                'path' => $filePath,
                'tanggal_berlaku' => $request->tanggal,
                'statusdocument' => '1',
            ]);

            if ($request->has('users')) {
                foreach ($request->users as $userId) {
                    Distribution::create([
                        'nodocument' => $combinedValue,
                        'user_id' => $userId,
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            DB::table('permissions')->insert([
                'resource_type' => 'document',
                'resource_id' => $combinedValue,
                'requested_by' => $userId,
                'approved_by' => null,
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            LogActivity::create([
                'log_id' => $logid,
                'user_id' => $this->userid,
                'activity' => 'Upload',
                'description' => $detail,
            ]);

            DB::commit();
            return redirect()->route('mmqa.index')->with('success', 'Dokumen berhasil diupload!');
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

        return response()->json(['data' => $docs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nodocument)
    {
        $user = auth()->user();
        $decryptID = Crypt::decryptString($nodocument);
        $data = Documents::find($decryptID);

        // dd($data);

        if ($user->role->name !== 'admin') {
            return redirect()->route('mmqa.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        return view('documents.edit', compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();

        if ($user->role->name !== 'Admin') {
            return redirect()->route('mmqa.index')->with('warning', 'Access Denied. You do not have permission for this.');
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
            return redirect()->route('mmqa.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
