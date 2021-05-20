<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointInfoList extends Model
{
    use HasFactory;
    protected $table = "point_info_lists";
    protected $primaryKey = "id";
    protected $guarded = [];

}
