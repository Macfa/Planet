<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Grade extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "grades";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

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
