<?php

namespace App\Http\Controllers;

use App\Models\PathDiagram;
use App\Models\QualityDocument;
use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Models\MasterDocs;
use App\Models\PathDocument;
use App\Models\PathForm;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;

class QualityProcedureController extends Controller
{
    protected $userid;
    use Loggable;
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


        if ($user->role->name === 'Direktur' || $user->role->name === 'Admin') {
            $documents = DB::table('documents')
                ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
                ->join('status', 'documents.statusdocument', '=', 'status.id')
                ->join('department', 'documents.department_id', '=', 'department.id')
                ->leftJoin('permissions as p', 'documents.nodocument', '=', 'p.resource_id')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_form FROM path_form GROUP BY nodocument) as pf'), 'documents.nodocument', '=', 'pf.nodocument')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_document FROM path_document GROUP BY nodocument) as pd'), 'documents.nodocument', '=', 'pd.nodocument')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_diagram FROM path_diagram GROUP BY nodocument) as pdg'), 'documents.nodocument', '=', 'pdg.nodocument')

                ->select(
                    'documents.*',
                    'master_docs.name as jenis_document',
                    'status.name as status',
                    'department.name as department',
                    'department.code as deptcode',
                    'p.approved_by as data_approver',
                    DB::raw('COALESCE(pf.total_path_form, 0) as total_path_form'),
                    DB::raw('COALESCE(pd.total_path_document, 0) as total_path_document'),
                    DB::raw('COALESCE(pdg.total_path_diagram, 0) as total_path_diagram')
                )
                ->get();
            // dd($documents);
        } else {
            $documents = DB::table('documents')
                ->join('distribution', 'documents.nodocument', '=', 'distribution.nodocument')
                ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
                ->join('status', 'documents.statusdocument', '=', 'status.id')
                ->join('department', 'documents.department_id', '=', 'department.id')
                ->leftJoin('permissions as p', 'documents.nodocument', '=', 'p.resource_id')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_form FROM path_form GROUP BY nodocument) as pf'), 'documents.nodocument', '=', 'pf.nodocument')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_document FROM path_document GROUP BY nodocument) as pd'), 'documents.nodocument', '=', 'pd.nodocument')
                ->leftJoin(DB::raw('(SELECT nodocument, COUNT(*) as total_path_diagram FROM path_diagram GROUP BY nodocument) as pdg'), 'documents.nodocument', '=', 'pdg.nodocument')
                ->where('distribution.user_id', $user->id)
                // ->where('documents.nodocument', 'PM-TS-7210')
                ->select(
                    'documents.*',
                    'master_docs.name as jenis_document',
                    'status.name as status',
                    'department.name as department',
                    'department.code as deptcode',
                    'p.approved_by as data_approver',
                    DB::raw('COALESCE(pf.total_path_form, 0) as total_path_form'),
                    DB::raw('COALESCE(pd.total_path_document, 0) as total_path_document'),
                    DB::raw('COALESCE(pdg.total_path_diagram, 0) as total_path_diagram')
                )
                ->get();

            // dd($documents);
        }

        // dd($documents);
        return view('docs_quality_procedure.index', compact('documents', 'user', 'masterdocs', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user()->role->name;
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'roles.name as position_name')
            ->orderByRaw("FIELD(roles.name, 'Admin', 'Direktur', 'Manager', 'User')")
            ->get()
            ->groupBy('position_name');
        $mdocs = MasterDocs::all();
        $userapprove = User::whereIn('role_id', [1, 2])->get();
        $department = Department::all();

        // dd($mdocs);

        if ($user !== 'Admin' && $user !== 'SuperAdmin') {
            return redirect()->route('dashboard.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }
        return view('docs_quality_procedure.upload', [
            'users' => $users,
            'userapprove' => $userapprove,
            'department' => $department,
            'mdocs' => $mdocs,
        ]);
    }

    private function generateFileCode($type, $departmentCode, $table)
    {
        $prefix = strtoupper($type) . '-' . strtoupper($departmentCode) . '-';

        $lastCode = DB::table($table)
            ->where('file_code', 'like', $prefix . '%')
            ->orderByDesc('file_code')
            ->value('file_code');

        if ($lastCode) {
            $lastNumber = (int) substr($lastCode, strrpos($lastCode, '-') + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return [$prefix, $newNumber];
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


        // Validasi input (tidak perlu ubah)
        $request->validate([
            'namadocs' => 'required',
            'deskripsi' => 'required',
            'valuedocs2' => 'required',
            'tanggal_berlaku' => 'required|date',
            'tanggal_review' => 'required|date',
            'masterdocs' => 'required',
            'department' => 'required',
            'documents.*' => 'file|mimes:pdf,docx,xls,xlsx,jpg,png|max:5048',
            'forms.*' => 'file|mimes:pdf,docx,xls,xlsx,jpg,png|max:5048',
            'diagrams.*' => 'file|mimes:pdf,docx,xls,xlsx,jpg,png|max:5048',
        ]);

        function generateFileCode($type, $departmentCode, $table)
        {
            $prefix = strtoupper($type) . '-' . strtoupper($departmentCode) . '-';

            $lastCode = DB::table($table)
                ->where('file_code', 'like', $prefix . '%')
                ->orderByDesc('file_code')
                ->value('file_code');

            if ($lastCode) {
                $lastNumber = (int) substr($lastCode, strrpos($lastCode, '-') + 1);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            return [$prefix, $newNumber]; // Kita kembalikan prefix dan angka awal
        }


        try {
            DB::beginTransaction();

            if ($verified == 0) {
                Documents::create([
                    'jenis_document_id' => $masterdocId,
                    'department_id' => $departmentId,
                    'nodocument' => $combinedValue,
                    'namadocument' => $request->namadocs,
                    'deskripsi' => $request->deskripsi,
                    'mark_dokumen' => $request->security,
                    'tanggal_berlaku' => $request->tanggal_berlaku,
                    'tanggal_review' => $request->tanggal_review,
                    'statusdocument' => '1',
                    'created_by' => $this->userid,
                    'otorisasi' => $verified,
                ]);
            } else {
                Documents::create([
                    'jenis_document_id' => $masterdocId,
                    'department_id' => $departmentId,
                    'nodocument' => $combinedValue,
                    'namadocument' => $request->namadocs,
                    'deskripsi' => $request->deskripsi,
                    'mark_dokumen' => $request->security,
                    'tanggal_berlaku' => $request->tanggal_berlaku,
                    'tanggal_review' => $request->tanggal_review,
                    'statusdocument' => '3',
                    'created_by' => $this->userid,
                    'otorisasi' => $verified,
                ]);
            }

            if ($request->hasFile('documents')) {
                [$prefix, $number] = $this->generateFileCode('IK', $departmentKode, 'path_document');

                foreach ($request->file('documents') as $index => $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $fileCode = $prefix . str_pad($number++, 3, '0', STR_PAD_LEFT);
                    $filename = $combinedValue . '-' . $fileCode . '.' . $extension;

                    $file->storeAs('instruksi', $filename, 'public');

                    PathDocument::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                        'file_code' => $fileCode
                    ]);
                }
            }

            if ($request->hasFile('forms')) {
                [$prefix, $number] = $this->generateFileCode('FM', $departmentKode, 'path_form');
                foreach ($request->file('forms') as $index => $file) {
                    // Ambil nama asli file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $fileCode = $prefix . str_pad($number++, 3, '0', STR_PAD_LEFT);
                    $filename = $combinedValue . '-' . $fileCode . '.' . $extension;

                    $file->storeAs('formulir', $filename, 'public');

                    // Simpan ke database
                    PathForm::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                        'file_code' => $fileCode,
                    ]);
                }
            }

            if ($request->hasFile('diagrams')) {
                [$prefix, $number] = $this->generateFileCode('DA', $departmentKode, 'path_diagram');
                foreach ($request->file('diagrams') as $index => $file) {
                    // Ambil nama asli file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $fileCode = $prefix . str_pad($number++, 3, '0', STR_PAD_LEFT);
                    $filename = $combinedValue . '-' . $fileCode . '.' . $extension;

                    $file->storeAs('diagram', $filename, 'public');

                    // Simpan ke database
                    PathDiagram::create([
                        'nodocument' => $combinedValue,
                        'name' => $originalName,
                        'path' => $filename,
                        'file_code' => $fileCode,
                    ]);
                }
            }

            if ($request->has('distribusi_users')) {
                foreach ($request->distribusi_users as $userId) {
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

            // LogActivity
            $this->logActivity($logid, $this->userid, 'Prosedur Mutu', 'Created', $combinedValue, 'Document ditambahkan');

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ Ubah bagian ini agar selalu balas JSON, tidak tergantung ajax()
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
            $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);


            // dd($getstatusdocs);
            $document = DB::table('documents as d')
                ->join('master_docs as md', 'd.jenis_document_id', '=', 'md.id')
                ->join('department as dept', 'd.department_id', '=', 'dept.id')
                ->join('status as s', 'd.statusdocument', '=', 's.id')
                ->leftJoin('permissions as p', 'd.nodocument', '=', 'p.resource_id')
                ->leftJoin('users as u', 'p.approved_by', '=', 'u.id')
                ->leftJoin('users as u2', 'd.created_by', '=', 'u2.id')
                ->where('d.nodocument', $decryptID)
                ->select(
                    'd.*',
                    'md.name as namajenis',
                    'dept.name as namadept',
                    's.name as status',
                    'p.approved_by as approval',
                    'u.name as uname',
                    'u.avatar as uavatar',
                    'u2.name as created'
                )
                ->first();

            // LogActivity
            $this->logActivity($idlog, $this->userid, 'Prosedur Mutu', 'Viewed', $decryptID, 'Document dilihat');


            if (!$document) {
                dd("Dokumen tidak ditemukan: " . $decryptID);
            }

            $user = auth()->user()->role->name;
            $userd = User::all();
            $userapprove = User::whereIn('role_id', [1, 2])->get();
            $department = Department::all();
            $masterdocs = MasterDocs::all();
            $docs = Documents::where('nodocument', $decryptID)->first();
            $path_document = PathDocument::where('nodocument', $decryptID)->get(['id', 'nodocument', 'name', 'path']);
            $path_form = PathForm::where('nodocument', $decryptID)->get(['id', 'nodocument', 'name', 'path']);
            $path_diagram = PathDiagram::where('nodocument', $decryptID)->get(['id', 'nodocument', 'name', 'path']);

            $distribusi = Distribution::where('nodocument', $decryptID)
                ->with('user')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->user_id => [
                            'name' => $item->user->name,
                            'avatar' => $item->user->avatar
                        ]
                    ];
                })
                ->toArray();

            // dd($path_document, $path_form, $path_diagram);

            return view('docs_quality_procedure.detail', [
                'userd' => $userd,
                'userx' => $user,
                'userapprove' => $userapprove,
                'department' => $department,
                'masterdocs' => $masterdocs,
                'document' => $document,
                'path_document' => $path_document,
                'path_form' => $path_form,
                'path_diagram' => $path_diagram,
                'docs' => $docs,
                'distribusi' => $distribusi,
            ]);
        } catch (\Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nodocument)
    {
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QualityDocument $qualityDocument)
    {
        //
    }

    public function approve(Request $request, $encryptedNoDoc)
    {
        try {
            // Dekripsi nodocument
            $nodocument = Crypt::decryptString($encryptedNoDoc);
            $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);


            // Cari dokumen berdasarkan nodocument
            $document = Documents::where('nodocument', $nodocument)->firstOrFail();

            // Validasi status (1 = Waiting)
            if ($document->statusdocument != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen tidak dalam status Waiting'
                ], 400);
            }

            // Update status (2 = Approved)
            $document->statusdocument = 2;
            $document->save();
            // LogActivity
            $this->logActivity($idlog, $this->userid, 'Prosedur Mutu', 'Approved', $nodocument, 'Document disetujui');

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil disetujui'
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendekripsi nomor dokumen'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, $encryptedNoDoc)
    {
        try {
            $nodocument = Crypt::decryptString($encryptedNoDoc);
            $document = Documents::where('nodocument', $nodocument)->firstOrFail();
            $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);


            if ($document->statusdocument != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen tidak dalam status Waiting'
                ], 400);
            }


            // Update status (3 = Rejected)
            $document->statusdocument = 5;
            $document->save();

            // LogActivity
            $this->logActivity($idlog, $this->userid, 'Prosedur Mutu', 'Rejected', $nodocument, 'Document ditolak');


            return response()->json([
                'success' => true,
                'message' => 'Dokumen ditolak'
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendekripsi nomor dokumen'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        // dd($id);

        if ($user->role->name !== 'Admin') {
            return redirect()->route('docs_qualityprocedure.index')->with('warning', 'Access Denied. You do not have permission for this.');
        }

        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        try {
            DB::beginTransaction();
            $data = Documents::find($id);
            dd($data);
            if ($data) {
                $data->delete();
            }

            // LogActivity
            $this->logActivity($idlog, $this->userid, 'Prosedur Mutu', 'Delete', $data->nodocument, 'Document dihapus');

            DB::commit();
            return redirect()->route('docs_qualityprocedure.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
