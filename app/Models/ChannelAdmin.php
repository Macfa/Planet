<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelAdmin extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "channel_admins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
