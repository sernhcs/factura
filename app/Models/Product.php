<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

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
        'stock'
    ];


// accesores
    protected function image():  Attribute
    {
        return  Attribute::make(
            get: fn() => $this->images()->first() ? Storage::url($this->images()->first()->path) : 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="150" height="150"><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="50">🛒</text></svg>',
        );
    }

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
// relacion muchos a muchos plimorifcas
    public function purchaseOrders()
    {
        return $this->morphedByMany(PurchaseOrder::class,'productable');
    }
    public function quotes()
    {
        return $this->morphedByMany(Quote::class,'productable');
    }

    // realcion poplimorfica
    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }
}
