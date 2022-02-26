<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class StampGroup extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "stamp_groups";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function stamps() {
        return $this->hasMany(Stamp::class, "category_group_id", "id");
    }
    public static function getDataFromCategory($categoryID) {
        if($categoryID == 0) {
            return self::with("stamps")->get();
        } else {
            return self::where("category_id", $categoryID)->with("stamps")->get();
        }
    }
}
