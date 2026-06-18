<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected $fillable = [
        'sales_id',
        'tanggal',
        'no_sq',
        'no_po',
        'customer_name',
        'description',
        'qty',
        'price_unit',
        'total',
        'status',
        'sales_comment',
        'next_followup_date',
    ];

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function comments()
    {
        return $this->hasMany(SalesReportComment::class);
    }
}