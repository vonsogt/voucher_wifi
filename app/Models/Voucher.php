<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    /**
     * Relationship
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
