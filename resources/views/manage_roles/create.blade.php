@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">NEW ROLE</p>
                </div>
                <div class="row p-2">
                    <div class="card-body p-0">
                        <form action="{{ route('mng_role.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Role</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    aria-describedby="defaultFormControlHelp" name="name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <a href="{{ route('mng_role.index') }}" class="btn btn-danger">Batal</a>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
