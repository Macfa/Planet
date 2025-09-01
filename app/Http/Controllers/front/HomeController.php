<?php  

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomeService;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        // Dependency Injection
        $this->homeService = $homeService;
    }

    public function index()
    {
        $homeCompactValue = $this->homeService->getHomeData();
        // refactoring view
        // return view('front.home.index', compact('homeCompactValue'));
        return view('main.index', $homeCompactValue);

    }
    public function login()
    {
        return view('auth.login');
    }
    // public function logout()
    // {
    //     auth()->logout();
    //     return redirect('/');
    // }
}