<x-default-layout>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Tentang</h1>
                <p class="lead fw-normal text-white-50 mb-0">Voucher WiFi</p>
            </div>
        </div>
    </header>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{ route('home') }}">Villamas-WiFi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"
                            href="{{ route('home') }}">Utama</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-telephone-fill me-1"></i>
                        Hubungi Kami
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tentang Villamas-WiFi</h5>
                            <p class="card-text">Kami adalah penyedia layanan wifi di area Villamas Blok D9. Tujuan kami adalah memberi kepuasan pengguna
                                dengan layanan ini, sehingga menyelesaikan keterbatasan akses internet pada daerah ini.</p>
                            <a href="/" class="btn btn-primary">Beli Voucher Sekarang!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-default-layout>
