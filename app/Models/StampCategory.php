<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class StampCategory extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "stamp_categories";
//    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

//    public static function getAllCategories() {
//        return self::get();
//    }

    public function getAllCategories() {
        return $this->all();
    }
    public function category() {
        return $this->belongsTo(Stamp::class, 'category_id');
    }
}
