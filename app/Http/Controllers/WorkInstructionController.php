<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\MasterDocs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WorkInstructionController extends Controller
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
            $data = DB::table('path_document as pd')
                ->join('documents as d', 'pd.nodocument', '=', 'd.nodocument')
                ->join('distribution as dist', 'pd.nodocument', '=', 'dist.nodocument')
                ->where('dist.user_id', $userId)
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
        }

        // dd($documents);
        return view('docs_work_instruction.index', compact('data', 'user', 'masterdocs', 'departments'));
    }

    public function viewFile($filename)
    {
        $path = 'instruksi/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $stream = Storage::disk('public')->readStream($path);
        $mime = Storage::disk('public')->mimeType($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Transfer-Encoding' => 'binary',
            'Accept-Ranges' => 'bytes'
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function detail($id)
    {
        //
    }


    public function edit(string $nodocument)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy($nodocument, $filecode)
    {
        $document = DB::table('path_document')
            ->where('nodocument', $nodocument)
            ->where('file_code', $filecode)
            ->first();

        if ($document) {
            // Hapus file dari storage
            if (Storage::exists('public/' . $document->path)) {
                Storage::delete('public/' . $document->path);
            }

            // Hapus dari DB
            DB::table('path_document')
                ->where('nodocument', $nodocument)
                ->where('file_code', $filecode)
                ->delete();
        }

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
