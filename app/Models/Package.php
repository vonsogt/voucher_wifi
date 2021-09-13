<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    /**
     * Relationship
     */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
