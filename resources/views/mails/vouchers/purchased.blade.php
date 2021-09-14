@component('mail::message')
# Dear Kostumer,

Anda telah berhasil memesan voucher "12 Jam" dengan harga "Rp5,000" rupiah.

Username: xxxxxxxx<br>
Password: xxxxxxxx

Agar dapat menggunakan akun diatas, silahkan lakukan pembayaran "TriPay" terlebih dahulu di Alfamart/Alfamidi atau e-wallet.

Jika selama 3 jam setelah email ini diterima tidak dilakukannya pembayaran, maka kode pembayaran otomatis kadaluarsa dan tidak dapat digunakan.

Kode Pembayaran: 123456789

@component('mail::button', ['url' => ''])
    Konfirmasi Pembayaran
@endcomponent

<small>Jika sudah bayar, silahkan klik tombol konfirmasi diatas.</small>

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent