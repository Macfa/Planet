<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampCategory extends Model
{
    use HasFactory;
    protected $table = "stamp_categories";
//    protected $primaryKey = "id";
    protected $guarded = [];

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
