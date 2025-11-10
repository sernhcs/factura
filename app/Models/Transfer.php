<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable=[
        'serie',
        'correlative',
        'date',
        'total',
        'observation',
        'origin_warehouse_id',
        'destination_warehouse_id',
    ];

    protected $casts=[
      'date'=>'datetime'
    ];
    // realcioinbn uno aa muchos inversa
    public function originWarehouse()
    {
      return $this->belongsTo(Warehouse::class,'origin_warehouse_id');
    }
    public function destinationWarehouse()
    {
      return $this->belongsTo(Warehouse::class,'destination_warehouse_id');
    }



    // realcion muchos a muchos polimorfica
    public function products()
    {
      return $this->morphToMany(Product::class,'productable')
        ->withPivot('quantity','price','subtotal')
        ->withTimeStamps();
    }
  }
