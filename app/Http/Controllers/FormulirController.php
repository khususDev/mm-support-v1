<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\MasterDocs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormulirController extends Controller
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

        $formQuery = DB::table('path_form as pf')
            ->select(
                'pf.nodocument',
                'pf.file_code',
                'pf.name as filename',
                'pf.path',
                DB::raw("'Formulir' as jenis")
            );

        $diagramQuery = DB::table('path_diagram as pdg')
            ->select(
                'pdg.nodocument',
                'pdg.file_code',
                'pdg.name as filename',
                'pdg.path',
                DB::raw("'Diagram' as jenis")
            );

        $union = $formQuery->unionAll($diagramQuery);

        $data = DB::table(DB::raw("({$union->toSql()}) as pu"))
            ->mergeBindings($union)
            ->join('documents as d', 'pu.nodocument', '=', 'd.nodocument')
            ->join('distribution as dist', 'pu.nodocument', '=', 'dist.nodocument')
            ->where('dist.user_id', $userId)
            ->select(
                'pu.nodocument',
                'pu.file_code',
                'pu.filename',
                'pu.path',
                'pu.jenis',
                'd.namadocument',
                'd.deskripsi',
                'd.mark_dokumen',
                'd.tanggal_berlaku',
                'd.tanggal_review',
                'd.statusdocument'
            )
            ->orderBy('pu.file_code', 'asc')
            ->get();

        return view('docs_form_record.index', compact('data', 'masterdocs', 'departments'));

    }

    public function viewFile($filename)
    {
        $path = 'formulir/' . $filename;

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
    public function show(Formulir $formulir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulir $formulir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulir $formulir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
