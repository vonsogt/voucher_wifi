<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BelumBayar()
 * @method static static SudahBayar()
 * @method static static Kadaluarsa()
 * @method static static Dikembalikan()
 * @method static static Gagal()
 */
final class PaymentStatus extends Enum
{
    const BelumBayar =      0;
    const SudahBayar =      1;
    const Kadaluarsa =      2;
    const Dikembalikan =    3;
    const Gagal =           4;
}
