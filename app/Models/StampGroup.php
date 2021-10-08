<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampGroup extends Model
{
    use HasFactory;
    protected $table = "stamp_groups";
    protected $guarded = [];

    public function stamps() {
        return $this->hasMany(Stamp::class, "groupID", "id");
    }
    public static function getDataFromCategory($categoryID) {
        if($categoryID == 1) {
            return self::with("stamps")->get();
        } else {
            return self::where("categoryID", $categoryID)->with("stamps")->get();
        }
    }
}
