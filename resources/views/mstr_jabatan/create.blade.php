@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('mst_post.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">New Position</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="">Position Name</label>
                                            <input type="text" class="form-control" id="post_name"
                                                aria-describedby="defaultFormControlHelp" name="post_name"
                                                value="{{ old('post_name') }}"
                                                oninput="this.value = this.value.toUpperCase()">
                                            @error('post_name')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="">Position Code</label>
                                            <input type="text" class="form-control" id="post_code"
                                                aria-describedby="defaultFormControlHelp" name="post_code"
                                                value="{{ old('post_code') }}"
                                                oninput="this.value = this.value.toUpperCase()" maxlength="2">
                                            @error('post_code')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="">Departmen / Divisi</label>
                                            <select class="form-control" name="departmen" id="departmen">
                                                <option value="" selected="selected" hidden="hidden">
                                                    Pilih Departmen</option>
                                                @foreach ($dept as $depts)
                                                    <option value="{{ $depts->id }}">
                                                        {{ $depts->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <a href="{{ route('mst_post.index') }}" class="btn btn-danger mt-3">Batal</a>
                                        <button type="submit" class="btn btn-primary ml-2 mt-3">Simpan</button>
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
