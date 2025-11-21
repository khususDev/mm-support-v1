@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">DEPARTMENT</p>
                </div>
                <div class="row p-2">
                    <div class="card-body p-0">
                        <form action="{{ route('mst_dept.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama
                                                    Department</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    aria-describedby="defaultFormControlHelp" name="name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Kode
                                                    Department</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    aria-describedby="defaultFormControlHelp" name="kode"
                                                    value="{{ old('kode') }}">
                                                @error('kode')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <a href="{{ route('mst_dept.index') }}" class="btn btn-danger">Batal</a>
                                            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
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
