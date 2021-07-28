<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Coin extends Model
{
    use HasFactory;

    protected $table = "coins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function coinable()
    {
        return $this->morphTo('coinable', 'coinable_type', 'coinable_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'userID');
    }
    public function coinType() {
        return $this->belongsTo(CoinType::class, 'coinTypeID', 'id');
    }

    // Custom Functions
    public function PurchaseStamp() {
        $user = User::where('id', auth()->id())->first();
        $totalCoin = $user->coins()->sum('coin');
        if($totalCoin >= 5) {
            // purchase
            $user->coins()->create([
                'coin'=>-5,
                'coinable_type'=>'test',
                'coinable_id'=>1,
                'userID'=>1,
                'type'=>'test'
            ]);
            return true;
        } else {
            // can't purchase
            return false;
        }
    }
}
