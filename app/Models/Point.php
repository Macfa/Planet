<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Point extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "points";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function pointable()
    {
        return $this->morphTo('pointable', 'pointable_type', 'pointable_id');
    }

    public function pointType()
    {
        return $this->belongsTo('App\Models\PointType','pointTypeID', 'id');
    }
}
