<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
// class User extends Model
{
    use HasFactory, Notifiable;
    protected $table = "users";
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function Posts() {
//        return $this->hasMany(Post::class, 'id');
        return $this->hasMany(Post::class, 'userID', 'id');
    }
    public function coins() {
        return $this->morphMany(Coin::class, 'coinable');
    }
    public function channelJoins() {
        return $this->hasMany(ChannelJoin::class, 'userID', 'id');
    }
    public function grade() {
        return $this->hasOne(Grade::class, "id", "gradeID");
    }
    public function Favorites() {
        // to be delete !
//        return $this->hasMany(Favorite::class, 'userID', 'id');
    }
    public function channelVisitHistories() {
        return $this->hasMany(ChannelVisitHistory::class, 'userID', 'id');
    }
    public function channelAdmins() {
        return $this->hasMany(ChannelAdmin::class, 'userID', 'id');
    }
    public function Comments() {
        return $this->hasMany(Comment::class, 'userID', 'id');
    }
    public function Channels() {
        return $this->hasMany(Channel::class, 'userID', 'id');
    }
    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }
    public function scrap() {
        return $this->hasMany(Scrap::class, 'userID', 'id');
    }
    public function hasCoins() {
        return $this->hasMany(Coin::class, 'userID', 'id');
    }
    public function hasExperiences() {
        return $this->hasMany(Experience::class, "userID", "id");
    }

    // Custom Functions...
    public function setSetNameAttribute($name) {
        $this->attributes['name'] = $name;
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
//            dd($this);
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
    public static function responseToastNotLogged() {
        $checkLogged = auth()->check();

        if(!$checkLogged) {
            // if not logged
            return redirect()->back()->with(['msg' => '로그인이 필요한 기능입니다', 'type' => 'warning']);
        }
    }
}
