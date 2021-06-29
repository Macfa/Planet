@include('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('css/channel/create.css') }}">
<section id="channel">
  <div class="wrap">
    <article class="board_box">
      <div class="left">
        <div class="list">
{{--            @isset($channel)--}}
{{--            @isset($channel)--}}
                @if(isset($channel))
                    <form action="{{ route('channel.update', $channel->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('channel.store') }}" method="POST">
                @endif
                @csrf
                <div class="input_box">
                    <span class="menu">이름</span>

                </div>
                <div class="input_box">
                    <input type="text" name="name" class="box" placeholder="이름을 입력하세요" @if(isset($channel)) value="{{ $channel->name }}" @endif >
                </div>
                <div class="input_box">
                    <span class="menu">설명</span>
                </div>
                <div class="input_box">
                    <textarea name="description" class="text_box" id="" placeholder="정보를 적어주세요">@if(isset($channel)){{ $channel->description }}@endif</textarea>
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
                        {{-- <li><a href="">등록</a></li> --}}
{{--                        @isset($channel)--}}
                        @if(isset($channel))
                            <li><input type="submit" value="수정" class="submit"></li>
                        @else
                            <li><input type="submit" value="등록" class="submit"></li>
                        @endif
                    </ul>
                </div>
            </form>
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
    </article>
  </div>
</section>
</body>


</html>
