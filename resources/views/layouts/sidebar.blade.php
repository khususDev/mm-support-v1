@php
    // Daftar URL yang tidak ingin menggunakan PJAX
    $excludedPjaxUrls = ['/dashboard', '/qualityprocedure', '/qualitymanual'];
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-3">
            <img src="{{ asset('assets/img/mmqms2.png') }}" alt="" style="width: 80%;">
        </div>
        <div class="sidebar-brand sidebar-brand-sm mt-3">
            <a href="index.html"><img src="{{ asset('assets/img/logo_mm.png') }}" alt="" style="width: 50px"></a>
        </div>
        <hr style="margin-left: 10%; margin-right: 10%; margin-top: 0;">

        <ul class="sidebar-menu mt-4">
            {{-- Urutkan kategori berdasarkan no_urut dari menu_category --}}
            @foreach ($user->menus->unique('category_id')->sortBy(function ($menu) {
        return optional($menu->category)->no_urut ?? 9999;
    }) as $menu)
                @if (is_null($menu->parent_id))
                    <li class="menu-header">
                        {{ $menu->category ? $menu->category->name : 'Uncategorized' }}
                    </li>

                    {{-- Urutkan menu utama dalam kategori berdasarkan no_urut --}}
                    @foreach ($user->menus->where('category_id', $menu->category_id)->sortBy('no_urut') as $menuInCategory)
                        @if (is_null($menuInCategory->parent_id))
                            @if ($menuInCategory->children && $menuInCategory->children->isNotEmpty())
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link has-dropdown">
                                        <i class="{{ $menuInCategory->icon }}"></i>
                                        <span>{{ $menuInCategory->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu" id="submenu-with-line">
                                        {{-- Urutkan submenu berdasarkan no_urut --}}
                                        @foreach ($menuInCategory->children->sortBy('no_urut') as $submenu)
                                            @if ($user->menus->contains($submenu))
                                                <li>
                                                    <a class="nav-link" href="{{ url($submenu->url) }}"
                                                        @if (in_array($submenu->url, $excludedPjaxUrls)) data-pjax="false"
                                        @else data-pjax="true" @endif>
                                                        {{ $submenu->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a class="nav-link" href="{{ url($menuInCategory->url) }}"
                                        @if (in_array($menuInCategory->url, $excludedPjaxUrls)) data-pjax="false"
                        @else data-pjax="true" @endif>
                                        <i class="{{ $menuInCategory->icon }}"></i>
                                        <span>{{ $menuInCategory->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
<style>
    #submenu-with-line {
        position: relative;
        padding-left: 10px;
        margin-left: 20px;
    }

    #submenu-with-line::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 8px;
        /* geser garis sedikit biar pas */
        width: 2px;
        background-color: #4c84ff;
        /* bisa kamu sesuaikan */
        z-index: 1;
    }

    #submenu-with-line li {
        position: relative;
        z-index: 2;
        padding-left: 0;
    }

    #submenu-with-line li a {
        padding-left: 25;
        display: block;
        margin: 5px;
        color: #666;
        font-size: 14px;
    }

    #submenu-with-line li a:hover {
        color: #4c84ff;
        font-weight: 500;
        background-color: rgba(76, 132, 255, 0.05);
        /* soft background */
        border-radius: 5px;
        transition: all 0.2s ease-in-out;
        padding-left: 20px;
        /* sedikit gerak kanan pas hover */
    }

    #submenu-with-line li a::before {
        content: '';
        position: absolute;
        left: -12px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background-color: #4c84ff;
        border-radius: 50%;
        opacity: 0;
        transition: 0.2s ease;
    }

    #submenu-with-line li a:hover::before {
        opacity: 1;
    }

    .no-pjax-transition {
        opacity: 1;
        transition: opacity 0.3s ease-in-out;
    }

    .no-pjax-transition.fade-out {
        opacity: 0;
    }
</style>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".no-pjax-transition").forEach(function(link) {
                link.addEventListener("click", function(e) {
                    let url = this.getAttribute("href");

                    // Cek apakah menu ini tidak memakai PJAX
                    if (this.getAttribute("data-pjax") === "false") {
                        e.preventDefault(); // Hentikan navigasi langsung

                        // Tambahkan efek fade-out sebelum pindah halaman
                        document.body.classList.add("fade-out");

                        setTimeout(function() {
                            window.location.href = url; // Pindah halaman setelah animasi
                        }, 300); // Sesuai durasi transition di CSS
                    }
                });
            });
        });
    </script>
@endpush
