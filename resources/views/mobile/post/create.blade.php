@extends('mobile.layouts.master')

@section('main')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/post/create.css') }}">

    <section id="channel" style="width: 100vw; height: calc(var(--vh, 89vh) * 89);">
        <div class="post_wrap">
            <article class="board_box">
                <div class="left">
                    <div class="list">
                        @if(isset($post))
                            <form id="form" action="{{ route('post.update', $post->id) }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                                @method('PUT')
                                @else
                                    <form id="form" action="{{ route('post.store') }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                                        @endif
                                        @csrf
                                        <div class="ch_list">
                                            <div class="input_box input_box_title">
                                                <div class="sub_box">
                                                    <span class="menu">포스트</span>
                                                    <select style="float: right;" class="cst_select" name="channel_id" id="channelList">
                                                        <option value="">등록할 채널을 선택해주세요</option>
                                                        @if($setting["type"] === "create")
                                                            @foreach (auth()->user()->allChannels() as $channel)
                                                                <option value="{{ $channel->id }}"
                                                                        @if(old('channel_id') === $channel->id)
                                                                        selected
                                                                        @elseif($setting["previous"] === $channel->id)
                                                                        selected
                                                                    @endif
                                                                >
                                                                    {{ $channel->name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach (auth()->user()->allChannels() as $channel)
                                                                <option value="{{ $channel->id }}"
                                                                        @if(old('channel_id') === $channel->id) selected
                                                                        @elseif($post->channel_id === $channel->id) selected
                                                                    @endif>
                                                                    {{ $channel->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('channel_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                    {{--                                <div style="float: right;" class="select_box">--}}
                                                    {{--                                </div>--}}
                                                </div>
                                                <div class="sub_box_0">
                                                    <input type="text" class="box" name="title" @if(old('title')) value="{{ old('title') }}" @elseif(isset($post)) value="{{ $post->title }}" @endif placeholder="이름을 입력하세요">
                                                    @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <textarea class="text_box" id="editor" name="content" placeholder="내용을 적어주세요">@if(old('content')){{ old('content') }}@elseif(isset($post)){{ $post->content }} @endif</textarea>
                                                    @error('content')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div style="margin-top: 20px;">
                                                <ul class="btn">
                                                    <li><button type="button" class="btn_cancle" onclick="location.href='{{ url('/') }}'">취소</button></li>
                                                    @if(isset($post))
                                                        <li><button class="btn_enter" type="submit" onclick="">수정</button></li>
                                                    @else
                                                        <li><button class="btn_enter" type="submit" onclick="">등록</button></li>
                                                    @endif
                                                </ul>
                                            </div>

                                        </div>
                    </div>
                    {{--                    <div class="right">--}}
                    {{--                        <div class="banner banner_above">--}}
                    {{--                            <span>banner</span>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="banner banner_below">--}}
                    {{--                            <span>banner</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    </form>
                </div>
            </article>
        </div>
    </section>

    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        function checkValue()
        {
            let form = document.searchForm;

            if(form.channel_id.value === '')
            {
                alert("채널을 선택해주세요");
                return false;
            }
            if(form.title.value === "" || form.title.value.length > 70)
            {
                alert("제목을 입력해주세요 ( 70자 이하 )");
                return false;
            }
            if(window.editor.data.get() === "")
            {
                alert("내용을 입력해주세요");
                return false;
            }
        }
        $(window).ready(function () {
            ClassicEditor.create( document.querySelector( '#editor' ), {
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: '{{ route('ck.upload') }}',

                    // Enable the XMLHttpRequest.withCredentials property.
                    // withCredentials: true,

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            } )
                .then( editor => {
                    window.editor = editor;
                } )
                .catch( error => {
                    console.error( 'There was a problem initializing the editor.', error );
                } );
        });

        // function clickSubmit() {
        //     var val = $("#channelList").val();
        //     if(val != "") {
        //         $("#form").submit();
        //     } else {
        //         alert('채널을 선택해주세요');
        //         $("#channelList").focus();
        //     }
        // }
    </script>
@endsection
