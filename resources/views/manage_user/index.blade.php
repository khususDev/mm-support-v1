@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-1">
                    <p class="title-body">AKUN USER</p>
                </div>
                <div class="row p-3">
                    <div class="col-8 mt-3 p-0">
                        <a href="{{ route('mng_user.create') }}" class="btn btn-primary btn-sm" id="btn-create">Tambah Baru</a>
                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($datax as $item)
                                        <tr>
                                            <input type="hidden" class="delete_id" value="{{ $item->id }}">
                                            <input type="hidden" class="delete_nama" value="{{ $item->name }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->dept }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>
                                                <form action="{{ route('mng_user.destroy', $item->id) }}" method="POST"
                                                    id="delt{{ $item->id }}">
                                                    <a href="{{ route('mng_user.edit', Crypt::encryptString($item->id)) }}"
                                                        class="btn btn-info"><i class="fas fa-edit"></i></a>

                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmDelete(<?= $item->id ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
