<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelJoin extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "channel_joins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
