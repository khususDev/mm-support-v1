@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">DATA USER</p>
                </div>
                <div class="row p-2">
                    <div class="card-body p-0">
                        <form action="{{ route('mng_user.update', Crypt::encryptString($data->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput"
                                                    aria-describedby="defaultFormControlHelp" name="name"
                                                    value="{{ $data->name }}">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-fullname">Email</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="defaultFormControlInput" class="form-control"
                                                        name="email" aria-describedby="defaultFormControlHelp"
                                                        value="{{ $data->email }}">
                                                    @error('email')
                                                        <small>{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">No Telp</label>
                                                <input type="text" id="basic-default-phone" name="phone"
                                                    class="form-control phone-mask" value="{{ $data->phone }}">
                                                @error('phone')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label>Position</label>
                                                <select class="form-control" name="department" id="department">
                                                    <option value="" selected="selected" hidden="hidden">
                                                        Pilih
                                                        Position</option>
                                                    @foreach ($dept as $posts)
                                                        <option value="{{ $posts->id }}"
                                                            {{ $data->department_id == $posts->id ? 'selected' : '' }}>
                                                            {{ $posts->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Role</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value="" selected="selected" hidden="hidden">
                                                        Pilih
                                                        Role</option>
                                                    @foreach ($roled as $roles)
                                                        <option value="{{ $roles->id }}"
                                                            {{ $data->role_id == $roles->id ? 'selected' : '' }}>
                                                            {{ $roles->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="users" class="form-label">Akses Menu</label>
                                                <div class="mb-2" id="custom">
                                                    <div class="left">
                                                        <input type="checkbox" id="selectAll" />
                                                        <label for="selectAll" style="font-weight: bold;">Pilih
                                                            Semua</label>
                                                    </div>
                                                </div>
                                                <div class="user-checkbox-list"
                                                    style="border: 1px solid #ced4da; border-radius: 5px; max-height: 400px; overflow-y: auto; padding: 10px;">

                                                    @foreach ($menud as $category)
                                                        <div style="margin-bottom: 15px;">
                                                            <strong
                                                                style="display: block; margin-bottom: 5px;">{{ $category->name }}</strong>
                                                            <div class="checkbox-grid" style="padding-left: 10px;">
                                                                @foreach ($category->menus as $menus)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="menus[]" value="{{ $menus->id }}"
                                                                            id="menu{{ $menus->id }}"
                                                                            {{ in_array($menus->id, $userMenus) ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="menu{{ $menus->id }}">
                                                                            {{ $menus->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                            <a href="{{ route('mng_user.index') }}" class="btn btn-danger">Batal</a>
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


<style>
    .user-checkbox-list {
        font-size: 14px;
        background-color: #f8f9fa;
    }

    .form-check {
        margin-bottom: 8px;
    }

    .form-check-input {
        margin-right: 10px;
    }

    .checkbox-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .form-check {
        width: calc(25% - 10px);
    }

    .user-checkbox-list {
        border: 1px solid #ced4da;
        border-radius: 5px;
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
    }

    #custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<link rel="stylesheet" href="{{ asset('assets/css/master.css') }}">
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAll = document.getElementById("selectAll");
        const checkboxes = document.querySelectorAll('.form-check-input');
        const roleDropdown = document.getElementById("role");
        const roleMenus = @json($defrole);

        const selectEdit = document.getElementById("selectEdit");

        // Fungsi untuk mengupdate status Select All
        function updateSelectAllStatus() {
            const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
            const anyChecked = Array.from(checkboxes).some((cb) => cb.checked);
            selectAll.checked = allChecked;
            selectAll.indeterminate = !allChecked && anyChecked;
        }

        // Event Listener: Select All checkbox
        selectAll.addEventListener("change", function() {
            const isChecked = selectAll.checked;
            checkboxes.forEach((checkbox) => {
                checkbox.checked = isChecked;
            });
        });

        // Event Listener: Individual checkboxes
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", updateSelectAllStatus);
        });

        roleDropdown.addEventListener("change", function() {
            const selectedRole = this.value;

            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });

            const filteredMenus = roleMenus.filter(rm => rm.role_id == selectedRole);
            filteredMenus.forEach(menu => {
                const checkbox = document.getElementById('menu' + menu.menu_id);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            updateSelectAllStatus();
        });
    });
</script>
