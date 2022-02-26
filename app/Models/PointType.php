<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class PointType extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "point_types";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function point()
    {
        return $this->hasMany('App\Models\Point', 'id', 'pointTypeID');
    }
}
