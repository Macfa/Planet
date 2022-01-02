<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;
    protected $table = "stamps";
    protected $guarded = [];

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
