<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Report extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "reports";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function reportable()
    {
        return $this->morphTo('reportable', 'reportable_type', 'reportable_id');
    }
}
