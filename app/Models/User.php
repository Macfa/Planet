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
    public function Favorites() {
        return $this->hasMany(Favorite::class, 'id');
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

    // Custom Functions...
    public function setSetNameAttribute($name) {
        $this->attributes['name'] = $name;
    }
}
