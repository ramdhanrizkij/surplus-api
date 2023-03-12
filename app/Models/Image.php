<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = "image";
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Category::class,'product_image','product_id','image_id');
    }
}
