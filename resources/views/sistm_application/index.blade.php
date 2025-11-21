@extends('layouts.main')

@section('main')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card p-5">
                <div class="row ml-3 mr-3 d-flex justify-content-between">
                    <h2 class="title-body">
                        APPLICATION
                    </h2>
                    <div class="flex justify-end mb-4">
                        @if ($cek_data)
                            <button class="btn btn-warning" id="btUpdate">Update Application</button>
                        @else
                            <button class="btn btn-primary" id="btCreate">Insert Application</button>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <form action="{{ $cek_data ? route('application.update', $cek_data->id) : route('application.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama Aplikasi</label>
                                    <input type="text" class="form-control" name="nama_aplikasi"
                                        aria-describedby="defaultFormControlHelp" style="font-size: large" disabled
                                        value="{{ old('nama_aplikasi', $cek_data->name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">Nama Perusahaan</label>
                                    <input type="text" class="form-control" name="nama_perusahaan"
                                        aria-describedby="defaultFormControlHelp"
                                        style="font-size: large; font-weight: bold;" disabled
                                        value="{{ old('nama_perusahaan', $cek_data->company ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="" cols="30" rows="10" class="form-control"
                                        style="height: 100px; font-size: large;" disabled value="{{ old('alamat', $cek_data->alamat ?? '') }}"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="logo">Logo Aplikasi</label>
                                    <input type="file" name="logo" id="logo" class="form-control"
                                        accept="image/*" onchange="previewLogo(event)" disabled>

                                    <!-- Preview -->
                                    <div class="mt-2">
                                        <img id="logoPreview"
                                            src="{{ isset($cek_data->logo) ? asset('storage/' . $cek_data->logo) : '#' }}"
                                            alt="Preview Logo" style="max-height: 100px;"
                                            @if (!isset($cek_data->logo)) hidden @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">Version</label>
                                    <input type="text" class="form-control" name="version"
                                        aria-describedby="defaultFormControlHelp"
                                        style="font-size: large; font-weight: bold;" disabled
                                        value="{{ old('version', $cek_data->version ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">Path Backup</label>
                                    <input type="text" class="form-control" name="path_backup"
                                        aria-describedby="defaultFormControlHelp"
                                        style="font-size: large; font-weight: bold;" disabled
                                        value="{{ old('path_backup', $cek_data->backup ?? '') }}">
                                </div>

                                <div class="row justify-content-center">
                                    <button class="btn btn-primary btn-lg">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM dijalankan");

        const elements = document.querySelectorAll("input, textarea");
        elements.forEach(function(el) {
            console.log("disable active");
            if (el.id !== "btUpdate") {
                el.disabled = true;
            }
        });

        // Ketika tombol btUpdate diklik
        const btnUpdate = document.getElementById("btUpdate");
        if (btnUpdate) {
            btnUpdate.addEventListener("click", function() {
                console.log("Update click");
                elements.forEach(function(el) {
                    el.disabled = false;
                });
            });
        }
        const btnCreate = document.getElementById("btCreate");
        if (btnCreate) {
            btnCreate.addEventListener("click", function() {
                console.log("Create click");
                elements.forEach(function(el) {
                    el.disabled = false;
                });
            });
        }
    });

    function previewLogo(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('logoPreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.removeAttribute('hidden');
        } else {
            preview.setAttribute('hidden', true);
            preview.src = "#";
        }
    }
</script>
