@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">JENIS DOKUMEN</p>
                </div>
                <div class="row p-2">
                    <div class="card-body p-0">
                        <form action="{{ route('mst_docs.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card">
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-fullname">Nama
                                                        Dokumen</label>
                                                    <input type="text" class="form-control" id="defaultFormControlInput"
                                                        name="name" value="{{ $data->name }}" />
                                                    @error('name')
                                                        <small>{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-fullname">Kode
                                                        Dokumen</label>
                                                    <input type="text" class="form-control" id="defaultFormControlInput"
                                                        name="kode" value="{{ $data->kode }}" />
                                                    @error('kode')
                                                        <small>{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <a href="{{ route('mst_docs.index') }}" class="btn btn-danger">Batal</a>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
