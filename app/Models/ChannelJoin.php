<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelJoin extends Model
{
    use HasFactory;
    protected $table = "channel_joins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channelID');
    }
}
