<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";
    protected $guarded = [];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_product','category_id','product_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class,'product_image','image_id','product_id');
    }
}
