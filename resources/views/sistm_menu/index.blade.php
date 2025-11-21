@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="card m-0">
                    <h3>Menu Master</h3>
                </div>
                <div class="row p-3">
                    <div class="col-8 mt-3 p-0">
                        <a href="{{ route('sys_menu.create') }}" class="btn btn-primary btn-sm" id="btn-create">Create
                            New</a>

                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Main</th>
                                        <th>Parent</th>
                                        <th>Ordinal</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <input type="hidden" class="delete_id" value="{{ $item->id }}">
                                            <input type="hidden" class="delete_nama" value="{{ $item->name }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->mname }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->pname }}</td>
                                            <td>{{ $item->urut }}</td>
                                            <td>{{ $item->url }}</td>
                                            <td>{{ $item->icon }}</td>
                                            <td>{{ $item->created }}</td>
                                            <td>
                                                <form action="{{ route('sys_menu.destroy', $item->id) }}" method="POST"
                                                    id="delt{{ $item->id }}">
                                                    <a href="{{ route('sys_menu.edit', Crypt::encryptString($item->id)) }}"
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
