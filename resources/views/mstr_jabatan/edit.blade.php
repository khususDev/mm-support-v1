@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">POSITION</p>
                </div>
                <div class="row">
                    <div class="card-body p-0">
                        <form action="{{ route('mst_post.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Position Name</label>
                                                <input type="text" class="form-control" id="post_name" name="post_name"
                                                    value="{{ $data->name }}" />
                                                @error('post_name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Position Code</label>
                                                <input type="text" class="form-control" id="post_code" name="post_code"
                                                    value="{{ $data->code }}" />
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
                                                        <option value="{{ $depts->id }}"
                                                            {{ $data->department_id == $depts->id ? 'selected' : '' }}>
                                                            {{ $depts->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <a href="{{ route('mst_post.index') }}" class="btn btn-danger">Batal</a>
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
