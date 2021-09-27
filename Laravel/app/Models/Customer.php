<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer  extends Authenticatable
{
    use HasFactory, SoftDeletes,Notifiable;
    protected $table = 'customer';
    protected $datas = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'password', 'address', 'birthday', 'gender','remember_token'];
    //thêm localScope
    public function scopeSearch($query)
    {
        if (request()->key) {
            $query = $query->where('name', 'like', '%' .request()->key . '%');
        }
        if(request()->order){
            $order = explode('-', request()->order);
            $orderBy = isset($order[0]) ? $order[0] : 'id';
            $orderValue = isset($order[1]) ? $order[1] : 'DESC';
            $query = $query->orderBy($orderBy, $orderValue);
        }
        return $query;
    }
    public function hasCustomer()
    {
        return $this->hasMany(Rating::class, 'customer_id', 'id');
    }
    public function myOrders()
    {
        return $this->hasMany(Order::class,'customer_id', 'id');
    }
}
