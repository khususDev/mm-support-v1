<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\PathQualityManual;
use App\Models\QualityManual;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QualityManualController extends Controller
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
        $userRole = auth()->user();
        $nodocs = 'MM-QA-01';
        $statusdocument = '3';
        // dd($userRole->role_id);


        $data = QualityManual::first();
        // dd($data->perusahaan);
        if ($data->perusahaan == null) {
            $nodocument = 'MM-QA-01';
            $created = Auth::user()->name;
            // dd($created);

            $users = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'roles.name as position_name')
                ->orderByRaw("FIELD(roles.name, 'Admin', 'Direktur', 'Manager', 'User')")
                ->get()
                ->groupBy('position_name');

            // dd($users);

            $distribusi = Distribution::where('nodocument', $nodocument)
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

            $data = QualityManual::where('no_document', $nodocument)->first();

            $userd = User::get();
            // dd($userd);

            $kebijakan = PathQualityManual::where([
                ['no_document', '=', $nodocument],
                ['jenis', '=', 'kebijakan']
            ])->get(['id', 'no_document', 'title', 'url']);

            $sasaran = PathQualityManual::where([
                ['no_document', '=', $nodocument],
                ['jenis', '=', 'sasaran']
            ])->get(['id', 'no_document', 'title', 'url']);

            $organisasi = PathQualityManual::where([
                ['no_document', '=', $nodocument],
                ['jenis', '=', 'organisasi']
            ])->get(['id', 'no_document', 'title', 'url']);

            return view('docs_quality_manual.edit', compact('users', 'distribusi', 'data', 'kebijakan', 'sasaran', 'organisasi', 'nodocument', 'userd', 'created'));
            // return view('docs_quality_manual.edit');
        } else {
            $document = DB::table('quality_manuals as qm')
                ->join('users as u1', 'qm.created_by', '=', 'u1.id')
                ->join('users as u2', 'qm.checker', '=', 'u2.id')
                ->where('qm.no_document', 'MM-QA-01')
                ->select(
                    'qm.*',
                    'u1.name as uname1',
                    'u1.avatar as uavatar1',
                    'u2.name as uname2',
                    'u2.avatar as uavatar2'
                )
                ->first();
            // dd($document);
            $kebijakan = PathQualityManual::where([
                ['no_document', '=', $nodocs],
                ['jenis', '=', 'kebijakan']
            ])->get(['id', 'no_document', 'title', 'url']);

            $sasaran = PathQualityManual::where([
                ['no_document', '=', $nodocs],
                ['jenis', '=', 'sasaran']
            ])->get(['id', 'no_document', 'title', 'url']);

            $organisasi = PathQualityManual::where([
                ['no_document', '=', $nodocs],
                ['jenis', '=', 'organisasi']
            ])->get(['id', 'no_document', 'title', 'url']);

            $distribusi = Distribution::where('nodocument', $nodocs)
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

            $approvals = DB::table('permissions as p')
                ->join('users as u', 'p.approved_by', '=', 'u.id')
                ->where('p.resource_id', $nodocs)
                ->select('p.resource_id', 'u.name', 'u.avatar')
                ->get();

            $users = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'roles.name as position_name')
                ->orderByRaw("FIELD(roles.name, 'Admin', 'Direktur', 'Manager', 'User')")
                ->get()
                ->groupBy('position_name');

            return view('docs_quality_manual.index', compact('document', 'kebijakan', 'sasaran', 'organisasi', 'userRole', 'distribusi', 'statusdocument', 'approvals', 'nodocs'));
        }
    }

    public function saveManual(Request $request) {}


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);
        $nodocument = 'MM-QA-01';

        $data = QualityManual::first();

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'checker' => 'required',

            'filesDocumentKebijakan.*' => 'file|mimes:pdf,docx|max:5048',
            'filesDocumentSasaran.*' => 'file|mimes:pdf,docx|max:5048',
            'filesDocumentOrganisasi.*' => 'file|mimes:pdf,docx|max:5048',
        ]);

        try {
            DB::beginTransaction();

            $revisi = $data->revisi;
            $revisi = (int) $revisi + 1;
            $update = str_pad($revisi, 2, '0', STR_PAD_LEFT);
            $data->update(
                [
                    'revisi' => $update,
                    'nama_document' => $request->nama_dokumen,
                    'perusahaan' => $request->perusahaan,
                    'alamat' => $request->alamat,
                    'created_by' => Auth::user()->id,
                    'checker' => $request->checker,
                ]
            );

            $message = 'Document updated successfully';


            if ($request->hasFile('filesDocumentKebijakan')) {
                foreach ($request->file('filesDocumentKebijakan') as $index => $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $originalName . '-' . $index . '.' . $extension;

                    $path = $file->storeAs('quality_manual', $originalName, 'public');
                    // dd($path);

                    PathQualityManual::create([
                        'no_document' => $nodocument,
                        'jenis' => 'Kebijakan',
                        'title' => $originalName,
                        'url' => $path,
                        'created_by' => $this->userid,
                    ]);
                }
            }


            if ($request->hasFile('filesDocumentSasaran')) {
                foreach ($request->file('filesDocumentSasaran') as $index => $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $originalName . '-' . $index . '.' . $extension;

                    $path = $file->storeAs('quality_manual', $originalName, 'public');
                    // dd($path);

                    PathQualityManual::create([
                        'no_document' => $nodocument,
                        'jenis' => 'Sasaran',
                        'title' => $filename,
                        'url' => $path,
                        'created_by' => $this->userid,
                    ]);
                }
            }

            if ($request->hasFile('filesDocumentOrganisasi')) {
                foreach ($request->file('filesDocumentOrganisasi') as $index => $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $filename = $originalName . '-' . $index . '.' . $extension;

                    $path = $file->storeAs('quality_manual', $originalName, 'public');
                    // dd($path);

                    PathQualityManual::create([
                        'no_document' => $nodocument,
                        'jenis' => 'Organisasi',
                        'title' => $filename,
                        'url' => $path,
                        'created_by' => $this->userid,
                    ]);
                }
            }

            //     // //Distribusi
            $this->updateDistribution($nodocument, $request->input('distribusi_users', []));

            // LogActivity
            $this->logActivity($logid, $this->userid, 'Manual Mutu', 'Updated', $nodocument, 'Document diperbaharui');

            DB::commit();
            return redirect()->route('docs_qualitymanual.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }


    public function detail($id)
    {
        //
    }

    public function edit(string $nodocs)
    {
        $nodocument = Crypt::decryptString($nodocs);

        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'roles.name as position_name')
            ->orderByRaw("FIELD(roles.name, 'Admin', 'Direktur', 'Manager', 'User')")
            ->get()
            ->groupBy('position_name');

        // // dd($users);

        $distribusi = Distribution::where('nodocument', $nodocument)
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

        $data = DB::table('quality_manuals as qm')
            ->join('users as u1', 'qm.created_by', '=', 'u1.id')
            ->join('users as u2', 'qm.checker', '=', 'u2.id')
            ->where('qm.no_document', $nodocument)
            ->select(
                'qm.*',
                'u1.name as uname1',
                'u2.name as uname2'
            )
            ->first();
        // dd($data);

        $userd = User::get();

        $kebijakan = PathQualityManual::where([
            ['no_document', '=', $nodocument],
            ['jenis', '=', 'kebijakan']
        ])->get(['id', 'no_document', 'title', 'url']);

        $sasaran = PathQualityManual::where([
            ['no_document', '=', $nodocument],
            ['jenis', '=', 'sasaran']
        ])->get(['id', 'no_document', 'title', 'url']);

        $organisasi = PathQualityManual::where([
            ['no_document', '=', $nodocument],
            ['jenis', '=', 'organisasi']
        ])->get(['id', 'no_document', 'title', 'url']);

        return view('docs_quality_manual.edit', compact('users', 'distribusi', 'data', 'kebijakan', 'sasaran', 'organisasi', 'nodocument', 'userd'));
        // return view('docs_quality_manual.edit');
    }

    // Fungsi untuk memperbarui distribusi dokumen
    protected function updateDistribution($decryptID, $userIds)
    {
        $userIds = array_map('intval', $userIds);
        $existingUserIds = Distribution::where('nodocument', $decryptID)->pluck('user_id')->toArray();
        $newUserIds = array_diff($userIds, $existingUserIds);
        $deletedUserIds = array_diff($existingUserIds, $userIds);

        foreach ($newUserIds as $userId) {
            Distribution::create([
                'nodocument' => $decryptID,
                'user_id' => $userId,
                'created_by' => $this->userid,
            ]);
        }

        if (!empty($deletedUserIds)) {
            Distribution::where('nodocument', $decryptID)
                ->whereIn('user_id', $deletedUserIds)
                ->delete();
        }
    }



    public function destroy($id)
    {
        $data = PathQualityManual::where('id', $id)->first();
        $tampung = match ($data->jenis) {
            'Kebijakan' => 'Kebijakan',
            'Sasaran' => 'Sasaran',
            'Organisasi' => 'Organisasi',
            default => 'null'
        };

        $descript = 'File ' . $tampung . ' dihapus';
        // dd($descript);

        try {
            $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

            $file = PathQualityManual::findOrFail($id);

            Storage::disk('public')->delete($file->url);

            $file->delete();

            $this->logActivity($idlog, $this->userid, 'Manual Mutu File', 'Deleted', $file->url, $descript);

            return redirect()->back()->with('success', 'File berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }
}
