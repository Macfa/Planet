<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Stamp extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "stamps";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function category() {
        return $this->belongsTo(StampCategory::class,'category_id', 'id');
    }
    public function coins() {
        return $this->morphMany(Coin::class, 'coinable');
    }
    public function getStamps($categoryID) {
        if($categoryID == 1) {
            return StampGroup::get();
        } else {
            return StampGroup::where("categoryID", $categoryID)->get();
        }
    }
    public function getAllStamps()
    {
        return $this->all();
    }
}
