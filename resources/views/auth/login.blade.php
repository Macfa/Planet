@extends('layouts.app')

@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-96">
    <h1 class="text-2xl font-bold mb-6 text-center">로그인</h1>

    {{-- 일반 로그인 --}}
    {{-- <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">이메일</label>
            <input type="email" name="email" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">비밀번호</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            로그인
        </button>
    </form> --}}

    <div class="my-6 text-center text-gray-500">또는</div>

    {{-- 소셜 로그인 버튼들 --}}
    <div class="space-y-3">
        <a href="{{ url('/auth/google/redirect') }}" 
           class="w-full block text-center bg-red-500 py-2 rounded hover:bg-red-600">
           구글 로그인
        </a>
        <a href="{{ url('/auth/apple/redirect') }}" 
           class="w-full block text-center bg-black text-white py-2 rounded hover:bg-gray-800">
           애플 로그인
        </a>
        <a href="{{ url('/auth/kakao/redirect') }}" 
           class="w-full block text-center bg-yellow-400 text-black py-2 rounded hover:bg-yellow-500">
           카카오 로그인
        </a>
    </div>
</div>

@endsection
