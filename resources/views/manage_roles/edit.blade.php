@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">ROLE USER</p>
                </div>
                <div class="row">
                    <div class="card-body">
                        <form action="{{ route('mng_role.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    name="name" value="{{ $data->name }}" />
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <a href="{{ route('mng_role.index') }}" class="btn btn-danger">Batal</a>
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
