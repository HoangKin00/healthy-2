<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','image','price','categoryProduct_id','content','status'];

    //1 sp có 1 dm 1-1
    public function cat(){
        return $this->hasOne(CategoryProduct::class, 'id', 'categoryProduct_id');
    }

    //check detail
    public function hasDetail(){
        
        return $this -> hasMany(OrderDetail::class, 'product_id', 'id');
    }

    

    //check images
    public function images(){
        
        return $this -> hasMany(ImageProduct::class, 'product_id', 'id');
    }

    public function scopeSearchFilter($query){
        if(request()->key){
            $query = $query->where('name','LIKE','%'.request()->key.'%');
        };
        if(request()->order){
            $order = explode('-',request() -> order);
            $orderBy = isset($order[0]) ? $order[0] : 'id';
            $orderValue = isset($order[1]) ? $order[1] : 'DESC';
            $query = $query -> orderBy($orderBy, $orderValue);
        }
        if(request()->cat){
            $query = $query->where('categoryProduct_id',request()->cat);
        }

        return $query;
    }
    

    

  
}


