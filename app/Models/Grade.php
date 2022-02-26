<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "grades";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        if($this->exists() === false) {
            $this->insert([
                'level' => 1,
                'name' => '기본',
                'icon' => '',
                'minExp' => 0,
                'maxExp' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        parent::__construct($attributes);
    }

    public function user() {
        return $this->belongsTo(User::class, 'level', 'level');
    }
}
