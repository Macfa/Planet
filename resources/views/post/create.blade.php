@include('layouts.header')

<link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

<section id="channel">
    <div class="wrap">
        <article class="board_box">
            <form action="{{ route('postStore') }}" method="POST">
                @csrf
                <div class="select_box">
                    <select class="cst_select" name="channelID" id="">
                        <option value="">등록할 채널을 선택해주세요</option>
                        @forelse ($channels as $channel)
                            
                            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
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
                            <input type="text" class="box" name="title" placeholder="이름을 입력하세요">
                        </div>
                        <div class="input_box" style="display:none" id="editor">
                            {{-- <textarea class="text_box" id="editor" name="content" placeholder="정보를 적어주세요"></textarea> --}}
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
                                    <li><input type="submit" value="등록" class="submit"></li>
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

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            // minHeight: '300px'
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>


</html>
