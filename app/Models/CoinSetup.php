<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 코인 설정을 관리하는 모델
 * 
 * 수정 사유:
 * 1. CascadeSoftDeletes trait 제거
 *   - 현재 모델에서 cascade delete가 필요하지 않음
 *   - 불필요한 의존성 제거로 코드 복잡도 감소
 * 
 * 2. guarded -> fillable 변경
 *   - 대량 할당 취약점 방지를 위해 명시적 허용 필드 지정
 *   - 보안 강화 및 코드 의도 명확화
 * 
 * 3. casts 속성 추가
 *   - 데이터 타입 명시로 타입 안정성 확보
 *   - 자동 타입 변환으로 코드 간소화
 * 
 * 4. attributes 속성 추가
 *   - is_active 기본값 설정으로 일관성 확보
 *   - 코드 중복 제거
 * 
 * 5. scopeActive 메서드 추가
 *   - 활성 설정 조회 로직 재사용성 향상
 *   - 쿼리 빌더 체이닝 지원
 * 
 * 6. 정적 메서드 추가
 *   - 보상 및 제한 값 조회 인터페이스 단순화
 *   - 비즈니스 로직 캡슐화
 */
class CoinSetup extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "coin_setups";
    protected $primaryKey = "id";

    protected $fillable = [
        'post',
        'comment',
        'post_limit',
        'comment_limit',
        'is_active'
    ];

    protected $casts = [
        'post' => 'integer',
        'comment' => 'integer',
        'post_limit' => 'integer',
        'comment_limit' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'is_active' => true
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getPostReward(): int
    {
        return static::active()->firstOrFail()->post;
    }

    public static function getCommentReward(): int
    {
        return static::active()->firstOrFail()->comment;
    }

    public static function getPostLimit(): int
    {
        return static::active()->firstOrFail()->post_limit;
    }

    public static function getCommentLimit(): int
    {
        return static::active()->firstOrFail()->comment_limit;
    }
}
