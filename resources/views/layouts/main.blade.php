<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_mm.ico') }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/fontawesome-iconpicker.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @stack('styles')

    @vite([])

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section mt-3 ml-3 mr-1" id="pjax-container">
                    <x-alert />
                    @yield('main')
                </section>
            </div>

            <!-- Footer -->
            @include('layouts.footer')

        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('dist/assets/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>


    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    <!-- Template JS -->
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Pjax -->
    <script src="{{ asset('assets/js/jquery.pjax.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('dist/assets/fontawesome-iconpicker.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('dist/assets/js/page/bootstrap-modal.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/eruda/3.4.1/eruda.min.js"
        integrity="sha512-3RVqOZtMevFOLeXCp0/Wl7np/l3J3MMysaFDUhNh+hdKx+Wb0lMXuHwA6CZ/+4DfYZM01Om1as8g+mnTaQH9vA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(document).pjax('a[data-pjax="true"]', '#pjax-container', {
                timeout: 5000,
                fragment: '#pjax-container'
                $('.dataTables_filter').hide();
                $('.dt-input').addClass('custom-style');
            });

            $(document).on('pjax:end', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');

                $('.nav-item.dropdown').removeClass('active');
                $('.dropdown-menu').slideUp();
                $('.dataTables_filter').hide();
                $('.dt-input').addClass('custom-style');

                $('.nav-item.dropdown > a').off('click').on('click', function(e) {
                    e.preventDefault();
                    $(this).parent().toggleClass('active');
                    $(this).next('.dropdown-menu').slideToggle();
                });

                $(document).ready(function() {
                    if ($("#documentTable").length >
                        0) {
                        $("#documentTable").DataTable();
                    }
                });
            });
        });
    </script>

    @stack('scripts')

    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                color: '#000',
                iconColor: '#198754',
                confirmButtonColor: '#198754',
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                color: '#000',
                iconColor: '#198754',
                confirmButtonColor: '#198754',
            })
        </script>
    @endif

    @if (session('warning'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}',
                color: '#ffff',
                iconColor: '#ffff',
                background: '#faad5a',
                confirmButtonColor: '#198754',
            })
        </script>
    @endif

</body>

</html>
