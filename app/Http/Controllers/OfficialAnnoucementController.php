<?php

namespace App\Http\Controllers;

use App\Models\SuratEdaran;
use Illuminate\Http\Request;
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

class OfficialAnnoucementController extends Controller
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

        // dd($documents);
        return view('docs_official_annoucement.index');
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

            return view('docs_official_annoucement.detail', [
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
    public function edit(SuratEdaran $suratEdaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratEdaran $suratEdaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratEdaran $suratEdaran)
    {
        //
    }
}
