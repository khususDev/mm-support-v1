<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ExternalDocumentController;
use App\Http\Controllers\WorkInstructionController;
use App\Http\Controllers\MasterDocsController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OfficialAnnoucementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QualityProcedureController;
use App\Http\Controllers\QualityManualController;
use App\Http\Controllers\UploadDocumentController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('mst_docs', MasterDocsController::class);
    Route::resource('mst_dept', DepartmentController::class);
    Route::resource('mst_post', JabatanController::class);
    Route::resource('mng_user', UserController::class);
    Route::resource('mng_role', RoleController::class);
    Route::resource('mng_access', AccessController::class);
    Route::resource('sys_menu', MenuController::class);
    Route::resource('sys_menucat', MenuCategoryController::class);
    Route::resource('sys_app', ApplicationController::class);
    Route::resource('sys_logs', LogActivityController::class);
    Route::resource('docs_qualitymanual', QualityManualController::class);
    Route::post('/docs_qualitymanual/upload-file', [QualityManualController::class, 'uploadFile'])->name('docs_qualitymanual.uploadFile');
    Route::resource('docs_qualityprocedure', QualityProcedureController::class);
    Route::get('docs_qualityprocedure/{id}/detail', [QualityProcedureController::class, 'detail'])->name('qualityprocedure.detail');
    Route::post('/docs_qualityprocedure/{encryptedNoDoc}/approve', [QualityProcedureController::class, 'approve'])->name('docs_qualityprocedure.approve');
    Route::post('/docs_qualityprocedure/{encryptedNoDoc}/reject', [QualityProcedureController::class, 'reject'])->name('docs_qualityprocedure.reject');

    Route::resource('docs_workinstruction', WorkInstructionController::class);
    Route::delete('/docs_workinstruction/delete/{nodocument}/{filecode}', [WorkInstructionController::class, 'destroy'])->name('document.delete');
    Route::get('/file/view/{filename}', [WorkInstructionController::class, 'viewFile'])->name('file.view');
    Route::get('docs_workinstruction/{id}/detail', [WorkInstructionController::class, 'detail'])->name('workinstruction.detail');

    Route::resource('docs_formulir', FormulirController::class);
    Route::get('docs_formulir/{id}/detail', [RecordController::class, 'detail'])->name('record.detail');

    Route::resource('docs_external', ExternalDocumentController::class);
    Route::get('docs_external/{id}/detail', [ExternalDocumentController::class, 'folderDetail'])->name('external_folder.detail');
    Route::get('docs_external/{id}/show', [ExternalDocumentController::class, 'show'])->name('external_folder.show');
    Route::post('docs_external/upload_file', [ExternalDocumentController::class, 'uploadFile'])->name('external_folder.upload');
    Route::post('docs_external/folder', [ExternalDocumentController::class, 'createFolder'])->name('external_folder.new_folder');
    Route::delete('docs_external/{id}', [ExternalDocumentController::class, 'destroy'])->name('external_folder.delete_folder');
    Route::delete('docs_external/delete-file/{id}', [ExternalDocumentController::class, 'deleteFile'])->name('docs_external.delete_file');
    Route::get('docs_external/download/{id}', [ExternalDocumentController::class, 'download'])->name('docs_external.download');

    Route::resource('docs_official', OfficialAnnoucementController::class);
    Route::get('docs_official/{id}/detail', [OfficialAnnoucementController::class, 'detail'])->name('official.detail');
    Route::resource('uploaddocs', UploadDocumentController::class);



    Route::get('/preview/{folder}/{filename}', function ($folder, $filename) {
        $path = storage_path("app/public/$folder/$filename");

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline',
            'Content-Type' => mime_content_type($path)
        ]);
    })->where('folder', 'documents|forms')->where('filename', '.*')->name('previewFile');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::fallback(function () {
    return redirect('/login');
});

Auth::routes();
