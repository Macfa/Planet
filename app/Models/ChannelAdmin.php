<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class ChannelAdmin extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "channel_admins";
    protected $primaryKey = "id";
    protected $guarded = [];
//    protected $cascadeDeletes = ['user', 'channel'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
