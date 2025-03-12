<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_no',
        'item_code',
        'item_name',
        'quantity',
        'location',
        'store_id',
        'in_stock_date',
        'status'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'id' => 'integer',
        'stock_no' => 'string',
        'item_code' => 'string',
        'item_name' => 'string',
        'quantity' => 'integer',
        'location' => 'string',
        'store_id ' => 'integer',
        'in_stock_date' => 'date:Y-m-d',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
