<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinType extends Model
{
    use HasFactory;

    protected $table = "coin_types";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function coin()
    {
        return $this->hasMany('App\Models\Coin', 'id', 'coinTypeID');
    }
}
