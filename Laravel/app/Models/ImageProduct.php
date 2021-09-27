<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $fillable = ['product_id','image','status'];
    public $timestamps = false; //loại bỏ created_at và updated_at
    
}
