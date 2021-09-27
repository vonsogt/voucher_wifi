<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table class="voucher" style=" width: 220px;">
        <tbody>
            <!-- Logo Hotspotname -->
            <tr>
                <td style="text-align: left; font-size: 14px; font-weight:bold; border-bottom: 1px black solid;">
                    {{ config('app.name') }}
                    <span id="num">[{{ $voucher->id }}]</span>
                </td>
            </tr>
            <tr>
                <td>
                    <table style=" text-align: center; width: 210px; font-size: 12px;">
                        <tbody>
                            <tr>
                                <td>
                                    <table style="width:100%;">
                                        <tr>
                                            <td font-size: 12px;>Kode Voucher</td>
                                        </tr>
                                        <tr>
                                            <td style="width:100%; border: 1px solid black; font-weight:bold; font-size:16px;">
                                                {{ $voucher->username }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            <tr>
                                <!-- Price  -->
                                <td colspan="2" style="border-top: 1px solid black;font-weight:bold; font-size:12px;background-color:white; -webkit-print-color-adjust: exact;">
                                    Rp{{ number_format($voucher->package->price) }}
                                </td>
                            </tr>
                            <tr>
                                <!-- Limit -->
                                <td colspan="2" style="border-top: 1px solid black;font-weight:bold; font-size:10px">
                                    {{ $voucher->package->time_limit }}
                                </td>
                            </tr>
                            <tr>
                                <!-- Note  -->
                                <td colspan="2" style="font-weight:bold; font-size:10px">Login: {{ url('') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
