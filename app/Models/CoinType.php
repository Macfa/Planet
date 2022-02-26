<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinType extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "coin_types";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = ['coin'];

    public function coin()
    {
        return $this->hasMany('App\Models\Coin', 'id', 'coinTypeID');
    }
}
