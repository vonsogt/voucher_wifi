@component('mail::message')
    # Kode Pembayaran TriPay

    123456789

    @component('mail::button', ['url' => ''])
        Konfirmasi Pembayaran
    @endcomponent

    <small>Jika sudah bayar, silahkan klik tombol konfirmasi diatas.</small>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
