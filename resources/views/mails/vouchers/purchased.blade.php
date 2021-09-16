@component('mail::message')
Dear Pelanggan,<br>
Terima kasih telah membeli voucher <b>WiFi</b> di Voucher WiFi.

# Detail Pembelian

@component('mail::table')
        | Nama Item | Harga |
        |:------------------- |:-------------------------------------- |
    @foreach ($order_items as $item)
        | {{ $item->name }}   | Rp{{ number_format($item->price, 2) }} |
    @endforeach
@endcomponent

## Metode Pembayaran

{{ $payment_name }}

## Kode Pembayaran

@component('mail::panel')
<b>{{ $pay_code }}</b>
@endcomponent

@component('mail::button', ['url' => ''])
    Konfirmasi Pembayaran
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}

<hr>

# Cara Pembayaran

@foreach ($instructions as $instruction)
## {{ $instruction->title }}

<ul class="">
@foreach ($instruction->steps as $step)
<li>{!! $step !!}</li>
@endforeach
</ul>

@endforeach

@endcomponent



