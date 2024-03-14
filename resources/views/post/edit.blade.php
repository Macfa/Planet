@extends('layouts.master')

@section('main')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">

    <section id="channel">
        <div class="wrap">
            <article class="board_box">
                    <form id="form" action="{{ route('post.update', $post->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="select_box d-flex">
                            <select class="cst_select is-invalid" name="channel_id" id="channelList">
                                <option value="">등록할 채널을 선택해주세요</option>
                                @foreach ($user->channels as $channel)
                                    <option value="{{ $channel->id }}"
                                        @if($post->channel_id == $channel->id) selected
                                        @elseif(old('channel_id')==$channel->id) selected @endif>
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('channel_id')
                                <div class="ml-2 invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="left">
                        <div class="ch_list">
                            <div class="input_box input_box_title">
                                <div class="sub_box sub_box_line">
                                    <span class="menu">포스트</span>
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
                                    <li><button type="submit" class="btn_enter" onclick="">수정</button></li>
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

    @push('scripts')
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