@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">

<section id="channel">
    <div class="wrap">
        <article class="board_box">
            @if(isset($post))
                <form id="form" action="{{ route('post.update', $post->id) }}" method="POST">
                @method('PUT')
            @else
                <form id="form" action="{{ route('post.store') }}" method="POST">
            @endif
                @csrf
                <div class="select_box">
                    <select class="cst_select" name="channelID" id="channelList">
                        <option value="">등록할 채널을 선택해주세요</option>
                        @forelse ($channels as $channel)
                            @if(isset($post))
                                @if($post->channelID==$channel->id)
                                    <option value="{{ $channel->id }}" selected>{{ $channel->name }}</option>
                                @else
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endif
                            @else
                                <option value="{{ $channel->id }}" @if($fromChannelID==$channel->id) selected @endif>{{ $channel->name }}</option>
                            @endif
                        @empty

                        @endforelse

                    </select>
                </div>
                <div class="left">
                    <div class="ch_list">

                        <div class="input_box input_box_title">
                            <div class="sub_box sub_box_line">
                                <span class="menu">포스트</span>
                            </div>
                            <div class="sub_box sub_box_line">
                                <input type="text" class="box" name="title" @if(isset($post)) value="{{ $post->title }}" @endif placeholder="이름을 입력하세요">
                            </div>
                            <div class="sub_box">
                                <textarea class="text_box" id="editor" name="content" placeholder="내용을 적어주세요">@if(isset($post)){{ $post->content }}@endif</textarea>
                            </div>
                        </div>
                            <div style="margin-top: 20px;">
                                <ul class="btn">
                                    <li><button type="button" onclick="location.href='{{ url('/') }}'">취소</button></li>
                                    @if(isset($post))
                                        <li><button type="submit" onclick="clickSubmit()">수정</button></li>
                                    @else
                                        <li><button type="submit" onclick="clickSubmit()">등록</button></li>
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

<script src="{{ asset('js/ckeditor.js') }}"></script>
<script>
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

    function clickSubmit() {
        var val = $("#channelList").val();
        if(val != "") {
            $("#form").submit();
        } else {
            alert('채널을 선택해주세요');
            $("#channelList").focus();
        }
    }
</script>
@endsection
