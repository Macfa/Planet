@extends('layouts.master')

@section('main')
<link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">
{{--{{ dd($user->allChannels()) }}--}}
<section id="channel">
    <div class="post_wrap">
        <article class="board_box">
            <form id="form" action="{{ route('post.store') }}" name="searchForm" method="POST" onsubmit="return checkValue();">
                @csrf
                <div class="d-flex">
                    <div class="left col-9">
                        <div class="ch_list">
                            <div>
                                <div class="select_box d-flex">
                                    <select class="cst_select is-invalid" name="channel_id" id="channelList">
                                        <option value="">등록할 채널을 선택해주세요</option>
                                        @foreach ($user->allChannels() as $channel)
                                            <option value="{{ $channel->id }}"
                                                    @if(old('channel_id')==$channel->id) selected
                                                    @elseif($fromChannelID == $channel->id) selected  @endif>
                                                {{ $channel->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('channel_id')
                                    <div class="ml-2 invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="input_box input_box_title">
                                <div class="sub_box sub_box_line">
                                    <span class="menu">포스트</span>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="is_notice">
                                        <label class="form-check-label" for="is_notice">
                                            안내글
                                        </label>
                                    </div>
                                </div>
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
                                        <li><button type="button" class="btn_cancle" onclick="location.href='{{ url('/') }}'">취소</button></li>
                                        <li><button type="submit" class="btn_enter" onclick="">등록</button></li>
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
    function checkValue()
    {
        let form = document.searchForm;

        if(form.channel_id.value === '')
        {
            alert("채널을 선택해주세요");
            return false;
        }
        if(form.title.value === "" || form.title.value.length > 20)
        {
            alert("이름을 입력해주세요 ( 20자 이하 )");
            return false;
        }
        if(window.editor.data.get() === "")
        {
            alert("내용을 입력해주세요");
            return false;
        }
    }
    $(document).ready(function () {
        var IFRAME_SRC = '//cdn.iframe.ly/api/iframe';
        var API_KEY = '6341e81a116ba645f8ee8336332eb524';

        ClassicEditor.create(document.querySelector('#editor'), {
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: '{{ route('ck.upload') }}',

                // Enable the XMLHttpRequest.withCredentials property.
                // withCredentials: true,

                // Headers sent along with the XMLHttpRequest to the upload server.
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            },
            mediaEmbed: {
                previewsInData: false,

                providers: [
                    {
                        // hint: this is just for previews. Get actual HTML codes by making API calls from your CMS
                        name: 'iframely previews',

                        // Match all URLs or just the ones you need:
                        url: /.+/,

                        html: match => {
                            const url = match[ 0 ];

                            var iframeUrl = IFRAME_SRC + '?app=1&api_key=' + API_KEY + '&url=' + encodeURIComponent(url);
                            // alternatively, use &key= instead of &api_key with the MD5 hash of your api_key
                            // more about it: https://iframely.com/docs/allow-origins

                            return (
                                // If you need, set maxwidth and other styles for 'iframely-embed' class - it's yours to customize
                                '<div class="iframely-embed">' +
                                '<div class="iframely-responsive">' +
                                `<iframe src="${ iframeUrl }" ` +
                                'frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>' +
                                '</iframe>' +
                                '</div>' +
                                '</div>'
                            );
                        }
                    }
                ]
            }
        })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
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
@endpush
@endsection
