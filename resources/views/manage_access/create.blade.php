@extends('layouts.main')


@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card m-3">
                    <p class="title-body">AKSES KONTROL</p>
                </div>
                <div class="row p-2">
                    <div class="card-body p-0">
                        <form action="{{ route('mng_access.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pengguna</label>
                                    <select class="form-control" name="username" id="username" onchange="changeDept(this)">
                                        <option value="" selected="selected" hidden="hidden">
                                            Pilih
                                            Jenis</option>
                                        @foreach ($userd as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
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
                                            <option value="{{ $roles->id }}">
                                                {{ $roles->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="users" class="form-label">Akses Menu</label>
                                    <div class="mb-2" id="custom">
                                        <div class="left">
                                            <input type="checkbox" disabled id="selectAll" />
                                            <label for="selectAll" style="font-weight: bold;">Pilih
                                                Semua</label>
                                        </div>
                                        @if ($isAdmin)
                                            <div class="right" id="edit">
                                                <input type="checkbox" id="selectEdit" />
                                                <label for="edit" style="font-weight: bold;">Edit</label>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="user-checkbox-list"
                                        style="border: 1px solid #ced4da; border-radius: 5px; max-height: 200px; overflow-y: auto; padding: 10px;">
                                        <div class="checkbox-grid">
                                            @foreach ($menud as $menus)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="menus[]"
                                                        value="{{ $menus->id }}" id="menu{{ $menus->id }}">
                                                    <label class="form-check-label" for="menu{{ $menus->id }}">
                                                        {{ $menus->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('mng_access.index') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary ml-2">Simpan</button>
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
        /* Membuat elemen berbaris baru jika melebihi baris */
        gap: 10px;
        /* Jarak antar elemen */
    }

    .form-check {
        width: calc(25% - 10px);
        /* Setiap elemen menempati 25% dari lebar kontainer */
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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', (event) => {
        console.log("DOM dijalankan");

        const selectAll = document.getElementById("selectAll");
        const checkboxes = document.querySelectorAll('.form-check-input'); // Semua checkbox individu
        const roleDropdown = document.getElementById("role"); // Dropdown role
        const roleMenus = @json($defrole); // Data dari backend untuk mapping role-menu

        const selectEdit = document.getElementById("selectEdit");

        // Event Listener: "Edit" Checkbox
        selectEdit.addEventListener("change", function() {
            const isEditable = selectEdit.checked;
            checkboxes.forEach((checkbox) => {
                checkbox.readOnly = !isEditable; // Aktifkan/Nonaktifkan checkbox
            });
        });

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

        // Event Listener: Dropdown Role
        roleDropdown.addEventListener("change", function() {
            const selectedRole = this.value; // Ambil role_id yang dipilih

            // Reset semua checkbox
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });

            // Centang checkbox sesuai role-menu yang dipilih
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
