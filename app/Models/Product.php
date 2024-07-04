<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'sku', 'name', 'slug', 
        'description', 'image', 'status', 'price', 'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public static function generateSKU() 
    {
        $lastrec=self::latest()->first();
        $nextsku=$lastrec ? intval(substr($lastrec->sku, -7)) : 0; 
        return 'SK'.str_pad($nextsku+1,7,'0',STR_PAD_LEFT);
       
    }
}
