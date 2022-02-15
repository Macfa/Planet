<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinSetup extends Model
{
    use HasFactory;
    protected $table = "coin_setups";
    protected $primaryKey = "id";
    protected $guarded = [];
}
