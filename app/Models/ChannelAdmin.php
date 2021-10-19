<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelAdmin extends Model
{
    use HasFactory;
    protected $table = "channel_admins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }
    public function channel() {
        return $this->belongsTo(Channel::class, 'channelID');
    }
}
