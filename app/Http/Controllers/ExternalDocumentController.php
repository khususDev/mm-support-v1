<?php

namespace App\Http\Controllers;

use App\Models\ExternalDocument;
use App\Models\File;
use App\Models\Folder;
use App\Models\RootFoolder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Distribution;
use App\Models\Documents;
use App\Traits\Loggable;
use App\Models\MasterDocs;
use App\Models\PathDocument;
use App\Models\PathForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExternalDocumentController extends Controller
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
        $folders = Folder::whereNull('parent_id')->whereHas('users', fn($q) => $q->where('user_id', Auth::id()))->get();

        $userd = User::all();
        return view('docs_external_document.index', compact('folders', 'userd'));
    }


    public function create()
    {
        //
    }

    public function createFolder(Request $request)
    {
        try {
            $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

            DB::beginTransaction();

            $request->validate([
                'name' => 'required',
                // 'parent_id' => 'nullable|exists:folders,id',
                'users' => 'required|array'
            ]);

            $folder = Folder::create([
                'name' => $request->name,
                'parent_id' => $request->location_id,
                'created_by' => $this->userid
            ]);

            $folder->users()->sync($request->users);

            // LogActivity
            $this->logActivity($idlog, $this->userid, 'External Document', 'Created', $request->name, 'Membuat folder');

            DB::commit();

            return back()->with('success', 'Folder berhasil ditambahkan!');
            // return redirect()->route('docs_external.index')->with('success', 'Folder berhasil ditambahkan!');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('Ada Masalah !', $e->getMessage());
        }
    }

    public function folderDetail($id)
    {
        $decryptID = Crypt::decryptString($id);
        $folder = ExternalDocument::findOrFail($decryptID);
        $files = $folder->documents()->orderBy('created_at', 'desc')->get();

        return view('docs_external_document.detail', compact('folder', 'files'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'array',
            'users.*' => 'exists:users,id',
            'location_id' => 'required|string' // atau integer, tergantung tipenya
        ]);
        dd($validated);

        $folder = Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'created_by' => Auth::id()
        ]);


        $folder->users()->sync($request->user_ids);

        return back()->with('success', 'Folder berhasil dibuat');
    }


    public function show($id)
    {
        $decryptID = Crypt::decryptString($id);
        $folder = Folder::findOrFail($decryptID);
        // dd($folder);
        $userd = User::all();

        // Cek izin akses
        abort_unless($folder->users->contains(Auth::id()), 403);

        $subfolders = $folder->children()->whereHas('users', fn($q) => $q->where('user_id', Auth::id()))->get();
        $files = $folder->files;

        return view('docs_external_document.detail', compact('folder', 'subfolders', 'files', 'userd', 'decryptID'));
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120', // max 5MB
            // 'location_id' => 'required|exists:file_external,id',
        ]);

        // Simpan file ke storage/app/uploads
        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('external');

        // Simpan data ke database
        File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => $path,
            'folder_id' => $request->location_id,
            'created_by' => $this->userid,
        ]);

        return back()->with('success', 'File berhasil diupload!');
    }

    public function detail($id)
    {
        // try {
        //     $decryptID = Crypt::decryptString($id);
        //     // dd($decryptID);

        //     $document = DB::table('documents')
        //         ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
        //         ->join('department', 'documents.department_id', '=', 'department.id')
        //         ->join('users', 'documents.verified', '=', 'users.id')
        //         ->join('status', 'documents.statusdocument', '=', 'status.id')
        //         ->where('documents.nodocument', $decryptID)
        //         ->select(
        //             'documents.id',
        //             'documents.nodocument as nodocs',
        //             'documents.namadocument as namadocs',
        //             'documents.deskripsi as desc',
        //             'documents.path as path',
        //             'documents.tanggal_berlaku as berlaku',
        //             'documents.revisidocument as revisi',
        //             'documents.created_at',
        //             'documents.updated_at',
        //             'master_docs.name as namajenis',
        //             'department.name as namadept',
        //             'users.name as verified',
        //             'status.name as status'
        //         )
        //         ->first();


        //     if (!$document) {
        //         dd("Dokumen tidak ditemukan: " . $decryptID);
        //     }

        //     // dd($document);

        //     $user = auth()->user()->role->name;
        //     $userd = User::all();
        //     $userapprove = User::whereIn('role_id', [1, 2])->get();
        //     $department = Department::all();
        //     $masterdocs = MasterDocs::all();
        //     $docs = Documents::where('nodocument', $decryptID)->first();
        //     $path_document = PathDocument::where('nodocument', $decryptID)->get(['name', 'path']);
        //     $path_form = PathForm::where('nodocument', $decryptID)->get(['name', 'path']);

        //     $distribusi = Distribution::where('nodocument', $decryptID)
        //         ->pluck('user_id')
        //         ->toArray();

        //     // dd($distribusi);

        //     // dd($user);

        //     return view('docs_external_document.detail', [
        //         'userd' => $userd,
        //         'userx' => $user,
        //         'userapprove' => $userapprove,
        //         'department' => $department,
        //         'masterdocs' => $masterdocs,
        //         'document' => $document,
        //         'path_document' => $path_document,
        //         'path_form' => $path_form,
        //         'docs' => $docs,
        //         'distribusi' => $distribusi
        //     ]);
        // } catch (\Exception $e) {
        //     dd("Error: " . $e->getMessage());
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalDocument $externalDocument)
    {
        //
    }

    // Delete file
    public function deleteFile($id)
    {
        $file = File::findOrFail($id);

        // Jika perlu, hapus file dari storage
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }

    // Download file
    public function download($id)
    {
        $file = File::findOrFail($id);

        return Storage::download($file->path, $file->name);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        // dd($folder);

        // Jika perlu, hapus juga file/folder terkait
        $folder->delete();

        return redirect()->back()->with('success', 'Folder berhasil dihapus.');
    }
}
