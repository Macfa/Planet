<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CoinSetup extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "coin_setups";
    protected $primaryKey = "id";
    protected $guarded = [];
//    protected $cascadeDeletes = [];
}
