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
        return $this->hasMany(Post::class, 'id');
    }
    public function Points() {
        return $this->hasMany(Point::class, 'id', 'memberID');
    }
    public function Favorites() {
        return $this->hasMany(Favorite::class, 'id');
    }
    public function Comments() {
        return $this->hasMany(Comment::class, 'id');
    }
}