<x-default-layout>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Voucher WiFi</h1>
                <p class="lead fw-normal text-white-50 mb-0">Terhubung Kapan dan Dimana Saja</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
                @forelse ($data['packages'] as $package)
                    <div class="col mb-5">
                        <div class="card h-100">
                            @if ($loop->iteration <= 3)
                                <!-- Sale badge-->
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">BARU</div>
                            @endif
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
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
                                <div class="text-center"><button class="btn bg-warning mt-auto" href="#" data-bs-toggle="modal" data-bs-target="#buyVoucherModal" data-bs-title="{{ $package->name }}" data-bs-id="{{ $package->id }}">Beli Voucher</button></div>
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
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="package_id">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan email anda">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Beli Sekarang</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var buyVoucherModal = document.getElementById('buyVoucherModal')
            buyVoucherModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = event.relatedTarget

                // Extract info from data-bs-* attributes
                var package_name =  button.getAttribute('data-bs-title')
                var package_id =    button.getAttribute('data-bs-id')

                // Update the modal's content.
                var modalTitle = buyVoucherModal.querySelector('.modal-title')
                var modalBodyPackageIdInput = buyVoucherModal.querySelector('.modal-body input[name=package_id]')

                modalTitle.textContent = 'Voucher ' + package_name
                modalBodyPackageIdInput.value = package_id;
            })
        </script>
    @endpush
</x-default-layout>
