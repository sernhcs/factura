<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    use HasFactory;
    
    protected $fillable=[
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
        'observation',
    ];
    // realcion uno a muchos inversa
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // realcion uno a muchos 
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    // realcion poplimorfica
    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }
}
