<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>403 &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.all.min.css') }}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        {{-- <h1>403</h1> --}}
                        <img src="{{ asset('assets/img/500.svg') }}" alt="" width="300px" height="300px">
                        <div class="page-description">
                            <h3>
                                Oops! Server Lagi Liburan 😅</h3>
                        </div>
                        <div class="page-description mt-4">
                            Kami sedang membujuk server agar segera kembali bekerja.
                        </div>
                        <div class="page-description">
                            Kamu coba lagi nanti ya! Terima kasih.
                        </div>

                    </div>
                </div>
                <hr style="margin-top: 50px; width: 300px;">
                <div class="footer text-center">
                    Copyright &copy; Merindo 2024
                </div>
            </div>
        </section>
    </div>
</body>

</html>
