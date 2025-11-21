@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('mmenu.update', $data->nodocument) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="mb-1">Document Detail</h3>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">No Document</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="nodocs" value="{{ $data->nodocument }}" style="width: 150px"
                                                    readonly />
                                                @error('nodocs')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Document</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="namadocs" value="{{ $data->namadocument }}" readonly />
                                                @error('namadocs')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Document</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="namadocs" value="{{ $data->namadocument }}" readonly />
                                                @error('namadocs')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Document</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="namadocs" value="{{ $data->namadocument }}" readonly />
                                                @error('namadocs')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Document</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="namadocs" value="{{ $data->namadocument }}" readonly />
                                                @error('namadocs')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <a href="{{ route('mmenu.index') }}" class="btn btn-danger">Batal</a>
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
@endsection
