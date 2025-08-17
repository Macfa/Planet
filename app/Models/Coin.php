<?php

namespace App\Models;

use Carbon\Carbon;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * 코인 관련 기능을 관리하는 모델
 * 
 * 수정 사유:
 * 1. MorphMany 제거 및 MorphTo, BelongsTo 추가
 *   - 관계 정의 명확화
 *   - 다형성 관계 최적화
 * 
 * 2. guarded -> fillable 변경
 *   - 대량 할당 취약점 방지를 위해 명시적 허용 필드 지정
 *   - 보안 강화 및 코드 의도 명확화
 * 
 * 3. casts 속성 추가
 *   - 데이터 타입 명시로 타입 안정성 확보
 *   - 자동 타입 변환으로 코드 간소화
 * 
 * 4. 쿼리 스코프 추가 (scopeToday, scopeByType, scopeByUser)
 *   - 재사용 가능한 쿼리 로직 제공
 *   - 코드 중복 제거 및 가독성 향상
 * 
 * 5. 정적 메서드 추가 (getTotalCoin, getTodayCoin)
 *   - 코인 관련 통계 기능 캡슐화
 *   - 비즈니스 로직 중앙화
 * 
 * 6. 트랜잭션 처리 추가
 *   - 데이터 일관성 보장
 *   - 동시성 문제 해결
 * 
 * 7. 메타데이터 구조화
 *   - 확장 가능한 데이터 저장
 *   - 유연한 정보 관리
 */
class Coin extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "coins";
    protected $primaryKey = "id";
    
    protected $fillable = [
        'type',
        'coin',
        'user_id',
        'coinable_type',
        'coinable_id',
        'metadata'
    ];

    protected $casts = [
        'coin' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function coinable(): MorphTo
    {
        return $this->morphTo('coinable', 'coinable_type', 'coinable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public static function getTotalCoin(User $user): int
    {
        return $user->hasCoins()->sum('coin');
    }

    public static function getTodayCoin(User $user, ?string $type = null): int
    {
        $query = $user->hasCoins($type);
        return $query->whereDate('created_at', Carbon::today())->sum('coin');
    }

    public function writePost(Post $post): bool
    {
        return DB::transaction(function () use ($post) {
            $today = Carbon::now();
            $coin_setup = CoinSetup::findOrFail(1);
            $limit = $coin_setup->post_limit;

            if (!auth()->check()) {
                return false;
            }

            $user = auth()->user();
            $totalCoin = $user->hasCoins("post")
                ->whereDate('coins.created_at', $today)
                ->sum('coin');

            if ($totalCoin > $limit) {
                return false;
            }

            return (bool) $post->coins()->create([
                'type' => '글작성',
                'coin' => $coin_setup->post,
                'user_id' => auth()->id(),
                'metadata' => [
                    'post_id' => $post->id,
                    'channel_id' => $post->channel_id
                ]
            ]);
        });
    }

    public function writeComment(Comment $comment): bool
    {
        return DB::transaction(function () use ($comment) {
            $today = Carbon::now();
            $coin_setup = CoinSetup::findOrFail(1);
            $limit = $coin_setup->comment_limit;

            if (!auth()->check()) {
                return false;
            }

            $user = auth()->user();
            $totalCoin = $user->hasCoins("comment")
                ->whereDate('coins.created_at', $today)
                ->sum('coin');

            if ($totalCoin > $limit) {
                return false;
            }

            return (bool) $comment->coins()->create([
                'type' => '댓글작성',
                'coin' => $coin_setup->comment,
                'user_id' => auth()->id(),
                'metadata' => [
                    'comment_id' => $comment->id,
                    'post_id' => $comment->post_id
                ]
            ]);
        });
    }

    public function changeUserName(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            $checkChanged = $user->isNameChanged;
            $limit = 100;
            $totalCoin = $user->hasCoins()->sum('coin');

            if ($checkChanged === 'Y') {
                if ($totalCoin > $limit) {
                    return (bool) $user->coins()->create([
                        'type' => '아이디변경',
                        'coin' => -100,
                        'user_id' => auth()->id(),
                        'metadata' => [
                            'old_name' => $user->name
                        ]
                    ]);
                }
                return false;
            }
            return true;
        });
    }
}
