<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Like extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "likes";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function likeable() {
        return $this->morphTo('likeable', 'likeable_type', 'likeable_id');
    }
}
