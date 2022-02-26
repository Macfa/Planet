<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointType extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "point_types";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function point()
    {
        return $this->hasMany('App\Models\Point', 'id', 'pointTypeID');
    }
}
