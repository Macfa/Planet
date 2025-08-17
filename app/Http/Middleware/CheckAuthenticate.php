<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        print_r("asdasd");exit;
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login'); // 로그인 페이지 라우트
        }
    }
}