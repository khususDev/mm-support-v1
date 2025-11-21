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
                        <form action="{{ route('mst_docs.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="document-name">Nama Dokumen</label>
                                        <input type="text" class="form-control" id="document-name" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="document-code">Kode Dokumen</label>
                                        <input type="text" class="form-control" id="document-code" name="kode"
                                            value="{{ old('kode') }}">
                                        @error('kode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <a href="{{ route('mst_docs.index') }}" class="btn btn-danger">Batal</a>
                                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
