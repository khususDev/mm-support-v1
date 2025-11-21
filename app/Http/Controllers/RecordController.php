<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Models\LogActivity;
use App\Models\MasterDocs;
use App\Models\PathDocument;
use App\Models\PathForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;

class RecordController extends Controller
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

        $userId = Auth::id();

        if ($user->role->name === 'SuperAdmin') {
            $data = DB::table('path_document as pd')
                ->join('documents as d', 'pd.nodocument', '=', 'd.nodocument')
                ->select(
                    'pd.nodocument',
                    'pd.file_code',
                    'pd.name as filename',
                    'pd.path',
                    'd.namadocument',
                    'd.deskripsi',
                    'd.mark_dokumen',
                    'd.tanggal_berlaku',
                    'd.tanggal_review',
                    'd.statusdocument'
                )
                ->orderBy('pd.file_code', 'asc')
                ->get();
            // dd($data);
        } else {
            $data = DB::table('documents as d')
                ->leftJoin('path_form as pf', function ($join) use ($userId) {
                    $join->on('pf.nodocument', '=', 'd.nodocument')
                        ->join('distribution as dist', 'pf.nodocument', '=', 'dist.nodocument')
                        ->where('dist.user_id', $userId);
                })
                ->leftJoin('path_diagram as pd', function ($join) use ($userId) {
                    $join->on('pd.nodocument', '=', 'd.nodocument')
                        ->join('distribution as dist', 'pd.nodocument', '=', 'dist.nodocument')
                        ->where('dist.user_id', $userId);
                })
                ->where(function ($query) {
                    $query->whereNotNull('pf.nodocument')
                        ->orWhereNotNull('pd.nodocument');
                })
                ->select(
                    'd.nodocument',
                    'd.namadocument',
                    'd.deskripsi',
                    'd.mark_dokumen',
                    'd.tanggal_berlaku',
                    'd.tanggal_review',
                    'd.statusdocument',
                    DB::raw('CASE 
            WHEN pf.nodocument IS NOT NULL THEN pf.file_code 
            ELSE pd.file_code 
        END as file_code'),
                    DB::raw('CASE 
            WHEN pf.nodocument IS NOT NULL THEN pd.name 
            ELSE pd.name 
        END as filename'),
                    DB::raw('CASE 
            WHEN pf.nodocument IS NOT NULL THEN pd.path 
            ELSE pd.path 
        END as path'),
                    DB::raw('CASE 
            WHEN pf.nodocument IS NOT NULL THEN "Formulir" 
            ELSE "Diagram" 
        END as jenis_dokumen')
                )
                ->orderBy('file_code', 'asc')
                ->get();
        }
        // dd($data);

        // dd($documents);
        return view('docs_quality_manual.index', compact('documents', 'user', 'masterdocs', 'departments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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

            return view('docs_form_record.detail', [
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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
            return redirect()->route('record.index')->with('warning', 'Access Denied. You do not have permission for this.');
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
            return redirect()->route('record.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
