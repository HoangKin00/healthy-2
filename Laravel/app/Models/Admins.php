<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admins extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = 'admin';
     protected $datas = ['deleted_at'];
    protected $fillable = ['name', 'email', 'phone', 'password','remember_token'];

    //thêm localScope
    public function scopeSearch($query)
    {
        if (request()->key) {
            $query = $query->where('name', 'like', '%' .request()->key . '%');
        }
        if(request()->order){ ///auth  đổi thử xem
            $order = explode('-', request()->order);
            $orderBy = isset($order[0]) ? $order[0] : 'id';
            $orderValue = isset($order[1]) ? $order[1] : 'DESC';
            $query = $query->orderBy($orderBy, $orderValue);
        }
        return $query;
    }
}
