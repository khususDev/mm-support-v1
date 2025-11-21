@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="card m-1">
                    <p class="title-body">DEPARTMENT</p>
                </div>
                <div class="row p-3">
                    <div class="col-8 mt-3 p-0">
                        <a href="{{ route('mst_dept.create') }}" class="btn btn-primary btn-sm" id="btn-create">Tambah Baru</a>
                        <a href="{{ route('mst_dept.create') }}" class="btn btn-secondary btn-sm ml-2"
                            id="btn-export">Export
                            Data</a>
                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kode</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <input type="hidden" class="delete_id" value="{{ $item->id }}">
                                            <input type="hidden" class="delete_nama" value="{{ $item->name }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->created_name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>
                                                <form action="{{ route('mst_dept.destroy', $item->id) }}" method="POST"
                                                    id="delt{{ $item->id }}">
                                                    <a href="{{ route('mst_dept.edit', Crypt::encryptString($item->id)) }}"
                                                        class="btn btn-info"><i class="fas fa-edit"></i></a>

                                                    @csrf
                                                    {{-- @method('DELETE') --}}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="confirmDelete(<?= $item->id ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Vertically Centered Modal -->
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
