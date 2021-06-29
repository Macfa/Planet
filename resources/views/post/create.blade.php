@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">

<section id="channel">
    <div class="wrap">
        <article class="board_box">
            @if(isset($post))
                <form action="{{ route('post.update', $post->id) }}" method="POST">
                @method('PUT')
            @else
                <form action="{{ route('post.store') }}" method="POST">
            @endif
                @csrf
                <div class="select_box">
                    <select class="cst_select" name="channelID" id="">
                        <option value="">등록할 채널을 선택해주세요</option>
                        @forelse ($channels as $channel)
                            @if(isset($post))
                                @if($post->channelID==$channel->id)
                                    <option value="{{ $channel->id }}" selected>{{ $channel->name }}</option>
                                @else
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endif
                            @else
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endif
                        @empty

                        @endforelse

                    </select>
                </div>
                <div class="left">
                    <div class="list">

                        <div class="input_box">
                            <span class="menu">포스트</span>
                        </div>
                        <div class="input_box">
                            <input type="text" class="box" name="title" @if(isset($post)) value="{{ $post->title }}" @endif placeholder="이름을 입력하세요">
                        </div>
                        <div class="input_box">
                            <textarea class="text_box" id="editor" name="content" placeholder="정보를 적어주세요">@if(isset($post)){{ $post->content }}@endif</textarea>
                            {{-- <textarea class="text_box" id="editor" name="content" placeholder="정보를 적어주세요" style="display:none"></textarea> --}}
                        </div>
                        {{-- <div style="float: right; font-size: 20px;"> --}}
                            <div class="point">
                                <div class='point_box'>
                                    <input type="checkbox">&nbsp;&nbsp;<span>10,000/100</span>
                                </div>
                            </div>
                            <div>
                                <ul class="btn">
                                    <li><a href="{{ url('/') }}">취소</a></li>
                                    @if(isset($post))
                                        <li><input type="submit" value="수정" class="submit"></li>
                                    @else
                                        <li><input type="submit" value="등록" class="submit"></li>
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="right">
                        <div class="banner banner_above">
                            <span>banner</span>
                        </div>
                        <div class="banner banner_below">
                            <span>banner</span>
                        </div>
                    </div>
                </form>
            </article>
        </div>
    </section>

{{-- <script src="{{ asset('js/ckeditor.js') }}"></script>--}}
 <script src="{{ asset('js/editor.js') }}"></script>
@endsection
