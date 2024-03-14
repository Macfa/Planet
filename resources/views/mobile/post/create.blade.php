@extends('mobile.layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/post/create.css') }}">
@endpush
@section('main')

<section id="channel" style="width: 100vw; height: calc(var(--vh, 89vh) * 89);">
    <div class="post_wrap">
        <article class="board_box">
            <div class="left">
                <div class="list">
                    @if($setting["type"] === "create")
                        <form id="form" action="{{ route('post.store') }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                    @else
                        <form id="form" action="{{ route('post.update', $post->id) }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="ch_list">
                        <div class="input_box input_box_title">
                            <div class="sub_box">
                                <span class="menu">포스트</span>
                                <select style="float: right;" class="cst_select" name="channel_id" id="channelList" onchange="checkOwner(this);">
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
                            </div>
                            <div id="checkOwner">

                            </div>
                            @if(auth()->user()->role === "admin")
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_main_notice" value="1" id="is_main_notice" {{ (isset($post->is_main_notice) && $post->is_main_notice === 1) ? 'checked' : '' }} >
                                    <label class="form-check-label" for="is_main_notice">
                                        메인 안내글
                                    </label>
                                </div>
                            </div>
                            @endif
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
                </form>
            </div>
        </article>
    </div>
</section>

<script src="{{ asset('js/ckeditor.js') }}"></script>
<script>
    let ckEditor;
    function checkOwner(obj) {
        if(obj.value) {
            $.ajax({
                url: '/channel/checkOwner',
                type: 'get',
                data: {
                    id: obj.value
                },
                success: function(data) {
                    if(data["result"]) {
                        $("#checkOwner").html('');
                        $.tmpl(checkOwnerTemplate).appendTo("#checkOwner");
                    } else {
                        console.log("Issue");
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        } else {
            $("#checkOwner").html('');
        }
    }
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
        // if(window.editor.data.get() === "")
        if(ckEditor.getData() === "")
        {
            alert("내용을 입력해주세요");
            return false;
        }
        var hasTopic = $("#is_channel_notice:checked").length;

        if(hasTopic > 0) {
            var main = $("#is_main_notice").is(':checked');

            if(main) {
                // 토픽 안내글 과 메인 안내글은 같이 선택될 수 없다
                alert("안내글은 토픽 또는 메인 하나만 선택해야합니다");
                return false;
            }
        }
    }

    $(document).ready(function () {
        $("#channelList").trigger("change");

        var ckeditor = ClassicEditor.create(document.querySelector('#editor'), {
            // plugins: [ MediaEmbed ],
            video: {
                upload: {
                    types: ['mp4', 'avi', 'mpeg', 'quicktime'],
                    allowMultipleFiles: true,
                }
            },
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: '{{ route('ck.upload') }}',

                // Enable the XMLHttpRequest.withCredentials property.
                withCredentials: true,

                // Headers sent along with the XMLHttpRequest to the upload server.
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            },
            mediaEmbed: {
                previewsInData: true,
                extraProviders: [
                    {
                        name: 'afreecaTV',
                        url: [
                            /^v\.afree\.ca\/ST\/([\w-]+)/,
                            /^vod\.afreecatv\.com\/PLAYER\/STATION\/([\w-]+)/,
                            /^vod\.afreecatv\.com\/player\/([\w-]+)/,
                            /^play\.afreecatv\.com\/\w+\/([\w-]+)/,
                        ],
                        html: match => {
                            const fullUrl = match[ 0 ];
                            var data = "vod_url="+fullUrl;
                            var url = "https://openapi.afreecatv.com/vod/embedinfo";
                            const xhr = new XMLHttpRequest();

                            xhr.open("POST", url, false);
                            xhr.withCredentials = true;
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.send(data);

                            var jsonResponse = JSON.parse(xhr.response);
                            return jsonResponse.html;
                        }
                    },
                ]
            }
        })
        .then(editor => {
            ckEditor = editor;
            editor.conversion.for('downcast').add(function(dispatcher) {
                dispatcher.on('insert:video', function(evt, data, conversionApi) {

                    const viewWriter = conversionApi.writer;
                    const $figure = conversionApi.mapper.toViewElement(data.item);
                    const $video = $figure.getChild(0);

                    viewWriter.setAttribute('controls', true, $video);
                    viewWriter.setStyle('width', '100%', $video);
                    // viewWriter.addClass('wid100', $video);
                })
            });
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
});
</script>
<script id="checkOwnerTemplate" type="text/x-jquery-tmpl">
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="is_channel_notice" value="1" id="is_channel_notice">
    <label class="form-check-label" for="is_channel_notice">
        토픽 안내글
    </label>
</div>
</script>
@endsection