<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    protected $fillable = [
        'sales_id',
        'month',
        'year',
        'target_amount',
    ];

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }
}