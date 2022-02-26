<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "likes";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function likeable() {
        return $this->morphTo('likeable', 'likeable_type', 'likeable_id');
    }
}
