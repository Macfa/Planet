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

    // public function channel() {
    //     return $this->belongsTo(Channel::class, 'id', 'id');
    // }

    // public function point_types() {
    //     return $this->belongsTo(PointType::class, 'pointTypeID', 'id');
    // }
    public function user() {
        return $this->belongsTo(User::class, 'memberID', 'id');
    }
}
