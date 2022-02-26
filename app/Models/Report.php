<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "reports";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function reportable()
    {
        return $this->morphTo('reportable', 'reportable_type', 'reportable_id');
    }
}
