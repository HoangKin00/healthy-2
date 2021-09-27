<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryVideo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'categoryvideo';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','status'];

    // public function products(){
    //     return $this->hasMany(Product::class,'category_id','id');
    // }

    public function scopeSearchFilter($query)
    {
        if(request()->key){
            $query = $query->where('name','like','%'.request()->key.'%');
        }
        if(request()->order){
            $order = explode('-',request()->order);
            $orderBy = isset($order[0]) ? $order[0] : 'id';
            $orderValue = isset($order[1]) ? $order[1] : 'DESC';
            $query = $query->orderBy($orderBy,$orderValue);
        }
        if(request()->status != ''){
            $status = request()->status;
            $status == 2 ? request()->status = 0 : 1;
            $query = $query->where('status',$status);
        }
        return $query;
    }
}
