<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointType extends Model
{
    use HasFactory;
    protected $table = "point_types";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function point() {
        return $this->belongsTo(Point::class, 'id');
    }
}
