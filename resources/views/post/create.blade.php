@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">
@endpush
@section('main')

<section id="channel">
    <div class="post_wrap">
        <article class="board_box">
            @if($setting["type"] === "create")
                <form id="form" action="{{ route('post.store') }}" name="searchForm" method="POST" onsubmit="return checkValue();">
            @else
                <form id="form" action="{{ route('post.update', $post->id) }}" method="POST">
                @method('PUT')
            @endif
            @csrf
                <div class="d-flex">
                    <div class="left col-9">
                        <div class="ch_list">
                            <div>
                                <div class="select_box d-flex">
                                    <select class="cst_select is-invalid" name="channel_id" id="channelList" onchange="checkOwner(this);">
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
                                    <div class="ml-2 invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="input_box input_box_title">
                                <div class="sub_box sub_box_line">
                                    <span class="menu">포스트</span>
                                </div>
                                <div id="checkOwner">

                                </div>
                                @if(auth()->user()->role === "admin")
                                <div>
                                    <div class="form-check">
                                        <input type='hidden' name="is_main_notice" value="0">
                                        <input class="form-check-input" type="checkbox" name="is_main_notice" value="1" id="is_main_notice" {{ (isset($post->is_main_notice) && $post->is_main_notice === 1) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="is_main_notice">
                                            메인 안내글
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <div class="sub_box sub_box_line">
                                    <input type="text" class="box is-invalid" name="title" value="{{ ($post->title) ?? old('title') }}" placeholder="이름을 입력하세요">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="sub_box">
                                    <textarea class="text_box is-invalid" id="editor" name="content" placeholder="내용을 적어주세요">{{ ($post->content) ?? old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div style="margin-top: 20px;">
                                    <ul class="btn">
                                        <li><button type="button" class="btn_cancle" onclick="history.back();">취소</button></li>
                                        <li><button type="submit" class="btn_enter" onclick="">{{ $setting["btn"] }}</button></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="right col-3 pl-4">
                            <div class="banner banner_above">
                                <span>banner</span>
                            </div>
                            <div class="banner banner_below">
                                <span>banner</span>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </div>
    </section>
@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}"></script>
<script>
    function checkOwner(obj) {
        if(obj.value) {
            $.ajax({
                url: '/channel/checkOwner',
                type: 'get',
                data: {
                    id: obj.value
                },
                success: function(data) {
                    window.d = data;
                    console.log(data);
                    if(data["result"]) {
                        $("#checkOwner").html('');
                        $.tmpl(checkOwnerTemplate).appendTo("#checkOwner");
                        // $("#checkOwnerTemplate").tmpl().appendTo("#checkOwner");
                    } else {
                        console.log("Issue");
                    }
                    // var valueList = {

                    // };
                    // $("#checkOwnerTemplate").tmpl(valueList).pre
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
        if(window.editor.data.get() === "")
        {
            alert("내용을 입력해주세요");
            return false;
        }
    }

    $(document).ready(function () {
        ClassicEditor.create(document.querySelector('#editor'), {
            // plugins: [ MediaEmbed ],
            video: {
                upload: {
                    types: ['mp4', 'avi', 'mpeg', 'mov'],
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
                        // https://vod.afreecatv.com/PLAYER/STATION/84704398
                        // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                editor.conversion.for('downcast').add(function(dispatcher) {
                    dispatcher.on('insert:video', function(evt, data, conversionApi) {

                        const viewWriter = conversionApi.writer;
                        const $figure = conversionApi.mapper.toViewElement(data.item);
                        const $video = $figure.getChild(0);
                        // viewWriter.addClass('test', $video);
                        viewWriter.setAttribute('controls', true, $video);
                        // viewWriter.setAttribute('autoplay', true, $video);
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
    <input type='hidden' name="is_channel_notice" value="0">
    <input class="form-check-input" type="checkbox" name="is_channel_notice" value="1" id="is_channel_notice">
    <label class="form-check-label" for="is_channel_notice">
        토픽 안내글
    </label>
</div>
</script>
@endpush
@endsection
