<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $table = "points";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function pointable()
    {
        return $this->morphTo('pointable', 'pointable_type', 'pointable_id');
    }

    public function pointType()
    {
        return $this->belongsTo('App\Models\PointType','pointTypeID', 'id');
    }
}
