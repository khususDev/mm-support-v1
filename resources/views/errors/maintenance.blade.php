<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Under &mdash; Construction</title>

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
                        <img src="{{ asset('assets/img/construction2.svg') }}" alt="" width="400px"
                            height="400px">
                        <div class="page-description">
                            <h3>
                                Maaf! Halaman Belum Siap 🙏</h3>
                        </div>
                        <div class="page-description mt-4">
                            Kami sedang memperbarui sistem untuk pengalaman yang lebih baik.
                        </div>
                        <div class="page-description">
                            Stay tuned ya! Kita balik sebentar lagi! 😉
                        </div>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-danger btn-lg mt-4">Balik Dulu</a>
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
