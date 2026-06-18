<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReportComment extends Model
{
    protected $fillable = [
        'sales_report_id',
        'user_id',
        'comment',
    ];

    public function report()
    {
        return $this->belongsTo(SalesReport::class, 'sales_report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}