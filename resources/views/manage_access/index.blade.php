@extends('layouts.main')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="card m-0">
                    <h2 class="title-body">AKSES KONTROL</h2>
                </div>
                <div class="row p-3">
                    <div class="col-8 mt-3 p-0">
                        <a href="{{ route('mng_access.create') }}" class="btn btn-primary btn-sm" id="btn-create">Tambah
                            Baru</a>

                    </div>
                    <div class="card-body p-0 mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Role</th>
                                        <th>Menu</th>
                                        <th>Status</th>
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
                                            <td>{{ $item->role }}</td>
                                            <td style="max-width: 400px">{{ $item->menus }}</td>
                                            {{-- <td>{{ $item->status }}</td> --}}
                                            <td>
                                                @switch($item->status)
                                                    @case('Active')
                                                        <span class="badge bg-success" style="color: azure">Active</span>
                                                    @break

                                                    @case('InActive')
                                                        <span class="badge bg-warning" style="color: azure">In-Active</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-light">Unknown</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <form action="{{ route('mng_access.destroy', $item->id) }}" method="POST"
                                                    id="delt{{ $item->id }}">
                                                    <a href="{{ route('mng_access.edit', Crypt::encryptString($item->id)) }}"
                                                        class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    @csrf
                                                    {{-- @method('DELETE') --}}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if (auth()->user()->role->name === 'Admin')
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="confirmDelete(<?= $item->id ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
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
