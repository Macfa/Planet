<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class User extends Authenticatable
// class User extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory, Notifiable;
    protected $table = "users";
    protected $primaryKey = "id";
    protected $cascadeDeletes = ['posts', 'channelJoins', 'channelVisitHistories', 'channelAdmins', 'comments', 'channels', 'reports', 'scraps', 'hasCoins', 'hasExperiences'];

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
        'avatar', 'provider_id', 'provider',
        'access_token'
   ];

 
   //You can also use below statement
   protected $guarded = ['*'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
//        return $this->hasMany(Post::class, 'id');
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    public function coins() {
        return $this->morphMany(Coin::class, 'coinable');
    }
    public function channelJoins() {
        return $this->hasMany(ChannelJoin::class, 'user_id', 'id');
    }
    public function grade() {
        return $this->hasOne(Grade::class, "level", "level");
    }
    public function channelVisitHistories() {
        return $this->hasMany(ChannelVisitHistory::class, 'user_id', 'id');
    }
    public function channelAdmins() {
        return $this->hasMany(ChannelAdmin::class, 'user_id', 'id');
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
    public function channels() {
        return $this->hasMany(Channel::class, 'user_id', 'id');
    }
    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }
    public function scraps() {
        return $this->hasMany(Scrap::class, 'user_id', 'id');
    }
    public function hasCoins($obj = null) {
        $q = $this->hasMany(Coin::class, 'user_id', 'id');
        if($obj === "post") {
            return $q->where("coinable_type", '=', 'App\Models\Post');
        } else if($obj === "comment") {
            return $q->where("coinable_type", '=', 'App\Models\Comment');
        } else {
            return $q;
        }
    }
    public function hasExperiences($obj = null) {
        $q = $this->hasMany(Experience::class, "user_id", "id");
        if($obj === "post") {
            return $q->where("experienced_type", '=', 'App\Models\Post');
        } else if($obj === "comment") {
            return $q->where("experienced_type", '=', 'App\Models\Comment');
        } else {
            return $q;
        }
    }
    // migrate to repository class
    // public function allChannels($page = 1) {
    //     $userId = $this->id; // 본인이 아닌 대상유저
    //     $joins = Channel::whereHas('channelJoins', function($q) use ($userId) {
    //         $q->where('user_id', $userId);
    //     })
    //         ->get();
    //     $channels = Channel::where('user_id', $userId)
    //         ->with('channelJoins')
    //         ->get();
    //     $values = $joins->merge($channels)->sortBy('updated_at', SORT_REGULAR, true)->forPage($page, 10);

    //     return $values;
    // }

    // Custom Functions...
    public function setSetNameAttribute($name) {
        $this->attributes['name'] = $name;
    }
    public function getGradeIconAttribute() {
        return $this->grade->attributes['icon'] ?? null;
    }
    public function changeUserName($name) {
        // 무료 이름 변경을 이전에 이용했었는지 체크
        if($this->isNameChanged == "N") {
            // 처음이라면 이름 변경 후 저장
            $this->name = $name;
            $this->isNameChanged = "Y";

            $this->save();

            return true;
        } else {
            $coin = new Coin();
            $result = $coin->changeUserName($this);

            if($result) {
                $this->name = $name;
                $this->save();

                return true;
            } else {
                return false;
            }
        }
    }
    public function isAdmin() {
        return $this->role === "admin" ? true : false;
    }
}
