<x-default-layout>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-lg-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Voucher WiFi</h1>
                <p class="lead fw-normal text-white-50 mb-0">Selamat datang di layanan Villamas-WiFi, silahkan pilih
                    paket yang anda inginkan.<br><small>Kepuasan anda adalah prioritas utama kami!</small></p>
            </div>
        </div>
    </header>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{ route('home') }}">Villamas-WiFi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Utama</a></li>
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
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
                @forelse ($data['packages'] as $package)
                    <div class="col mb-5">
                        <div class="card h-100">
                            @if ($loop->iteration <= 3)
                                <!-- Sale badge-->
                                <div class="badge bg-danger text-white position-absolute"
                                    style="top: 0.5rem; right: 0.5rem">
                                    BARU
                                </div>
                            @endif
                            <!-- Product image-->
                            <img class="card-img-top"
                                src="{{ $package->featured_image ? url('/uploads/' . $package->featured_image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}"
                                alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $package->name }}</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    Rp{{ number_format($package->price, 2) }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <button class="btn bg-warning mt-auto" href="#" data-bs-toggle="modal"
                                        data-bs-target="#buyVoucherModal" data-bs-title="{{ $package->name }}"
                                        data-bs-id="{{ $package->id }}">
                                        Beli Voucher
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    Belum ada paket.
                @endforelse
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="buyVoucherModal" tabindex="-1" aria-labelledby="buyVoucherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyVoucherModalLabel">Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="buyVoucherForm">
                    <div class="modal-body">
                        <input type="hidden" name="package_id" id="package_id">
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" name="customer_email" class="form-control" id="customer_email"
                                placeholder="Masukkan email anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-select"
                                aria-label="Default select example">
                                <option selected disabled>Pilih metode pembayaran</option>
                                @foreach ($data['payment_methods'] as $payment_method)
                                    <option value="{{ $payment_method->code }}">
                                        {{ $payment_method->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Beli Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var buyVoucherModal = document.getElementById('buyVoucherModal')
            buyVoucherModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget

                // Extract info from data-bs-* attributes
                var package_name = button.getAttribute('data-bs-title')
                var package_id = button.getAttribute('data-bs-id')

                // Update the modal's content.
                var modalTitle = buyVoucherModal.querySelector('.modal-title')
                var modalBodyPackageIdInput = buyVoucherModal.querySelector('.modal-body input[name=package_id]')

                modalTitle.textContent = 'Voucher ' + package_name
                modalBodyPackageIdInput.value = package_id;
            })

            $(document).ready(function() {

                $("#buyVoucherForm").on('submit', function(e) {
                    e.preventDefault()

                    let package_id = $("#package_id").val()
                    let customer_email = $("#customer_email").val()
                    let payment_method = $("#payment_method :selected").val()

                    $.ajax({
                        type: "POST",
                        url: "{{ route('api.v1.buy-voucher') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "package_id": package_id,
                            "customer_email": customer_email,
                            "payment_method": payment_method,
                        },
                        beforeSend: function() {
                            // Show loading
                            Swal.fire({
                                title: 'Sedang Memproses',
                                html: 'Harap tunggu sebentar, sedang memproses pembelian.',
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                            });

                            // To prevent double click
                            $("#buyVoucherForm").find(":submit").prop('disabled', true)
                        },
                        success: function(response) {
                            Swal.fire('Berhasil', response.msg, 'success')

                            // Close & Reset the Voucher Modal
                            $("#buyVoucherModal").modal("hide")
                            $("#buyVoucherForm").trigger("reset").find(":submit").prop('disabled',
                                false)
                        }
                    })
                })

            });
        </script>
    @endpush
</x-default-layout>
