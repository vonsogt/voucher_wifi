<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Utama - Villamas-WiFi</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('vendor/startbootstrap/shop-homepage/css/styles.css') }}" rel="stylesheet" />

        @stack('styles')
    </head>
    <body>

        {{ $slot }}

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">&copy; {{ now()->format('Y') }} Voucher WiFi by <a class="text-decoration-none" href="">Villamas</a> </p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('vendor/startbootstrap/shop-homepage/js/scripts.js') }}"></script>

        <!-- Custom JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        @stack('scripts')
    </body>
</html>
