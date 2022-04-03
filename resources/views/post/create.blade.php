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
                                    <select class="cst_select is-invalid" name="channel_id" id="channelList">
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

                                    @if(auth()->user()->role === "admin")
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_notice" value="1" id="is_notice" {{ (isset($post->is_notice) && $post->is_notice === 1) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="is_notice">
                                            안내글
                                        </label>
                                    </div>
                                    @endif
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
    function AddCkeVideoControls(editor) {
        editor.conversion.for('downcast').add(function(dispatcher) {
            dispatcher.on('insert:videoBlock', function(evt, data, conversionApi) {
                console.log(evt,data,conversionApi);
                const viewWriter = conversionApi.writer;
                alert(11);
                //
                const figure = conversionApi.mapper.toViewElement(data.item);
            })
        });
    }
                // const img = figure.getChild(0);
                //
                // if (data.attributeNewValue !== null) {
                //     const src = data.attributeNewValue;
                //     const url = new URL(src, window.location.origin);
                //     const matches = url.pathname.match(/^\/(.+?)\/(.+)$/); // <-- parsing out the original values from the url
                //     const bucket = matches ? matches[1] : '';
                //     const path = matches ? matches[2] : '';
                //
                //     if (url) {
                //         viewWriter.setAttribute('data-upload-bucket', bucket, img);
                //         viewWriter.setAttribute('data-upload-key', path, img);
                //     }
                // } else {
                //     viewWriter.removeAttribute('data-upload-bucket', img);
                //     viewWriter.removeAttribute('data-upload-key', img);
                // }

    $(document).ready(function () {

        ClassicEditor.create(document.querySelector('#editor'), {
            extraPlugins: [ AddCkeVideoControls ],
            video: {
                upload: {
                    types: ['mp4', 'avi', 'mpeg'],
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
                providers: [
                    {
                        name: 'youtube',
                        url: [
                            /^(?:m\.)?youtube\.com\/watch\?v=([\w-]+)/,
                            /^(?:m\.)?youtube\.com\/v\/([\w-]+)/,
                            /^youtube\.com\/embed\/([\w-]+)/,
                            /^youtu\.be\/([\w-]+)/,
                        ],
                        html: match => {
                            const id = match[ 1 ];
                            return (
                                '<div style="position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;">' +
                                `<iframe src="https://www.youtube.com/embed/${ id }" ` +
                                'style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;" ' +
                                'frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>' +
                                '</iframe>' +
                                '</div>'
                            );
                        }
                    },
                ],
                extraProviders: [
                    {
                        name: 'afreecaTV',
                        url: [
                            /^v\.afree\.ca\/ST\/([\w-]+)/,
                            /^vod\.afreecatv\.com\/PLAYER\/STATION\/([\w-]+)/,
                            /^vod\.afreecatv\.com\/([\w-]+)/,
                            /^play\.afreecatv\.com\/\w+\/([\w-]+)/,
                        ],
                        html: match => {
                            const id = match[ 1 ];
                            var data = "vod_url=https://vod.afreecatv.com/PLAYER/STATION/84704398";
                            var url = "https://openapi.afreecatv.com/vod/embedinfo";
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", url);
                            // xhr.withCredentials = true;
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.send(data);
                        }
                    },
                ]
            }
        })
            .then(editor => {
                window.editor = editor;
                // Add a converter to editing downcast and data downcast.
                editor.conversion.for( 'downcast' ).elementToElement({
                    model: 'figcaption',
                    view: 'p1'
                } );


                // Dedicated converter to propagate image's attribute to the img tag.
                // editor.conversion.for('downcast').add((dispatcher: any) =>
                //     dispatcher.on('attribute:src:image', (evt: any, data: any, conversionApi: any) => {


            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    });

</script>
@endpush
@endsection
