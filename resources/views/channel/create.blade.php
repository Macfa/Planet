@include('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('css/channel/create.css') }}">
<section id="channel">
  <div class="wrap">
    <article class="board_box">
      <div class="left">
        <div class="list">
                @if(isset($channel))
                    <form action="{{ route('channel.update', $channel->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('channel.store') }}" method="POST">
                @endif
                @csrf
                <div class="input_box input_box_title">
                    <div class="sub_box sub_box_line">
                        <span class="menu">이름</span>
                    </div>
                    <div class="sub_box">
                        <input type="text" name="name" class="box @error('name') is-invalid @enderror" placeholder="이름을 입력하세요" @if(isset($channel)) value="{{ $channel->name }}" readonly @else value="{{ old('name') }}" @endif >
                        @error('name')
{{--                            <span class="text-danger">{{ $errors->first('name') }}</span>--}}
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="input_box">
                    <div class="sub_box sub_box_line">
                        <span class="menu">설명</span>
                    </div>
                    <div class="mt10 sub_box">
                        <textarea name="description" class="text_box @error('description') is-invalid @enderror" id="" placeholder="내용을 입력하세요">@if(isset($channel)){{ $channel->description }}@else{{ old('description') }}@endif</textarea>
                        @error('description')
{{--                            <span class="text-danger">{{ $errors->first('description') }}</span>--}}
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- <div style="float: right; font-size: 20px;"> --}}
                <div class="point">
                    <div class='point_box'>
                        <input type="checkbox">&nbsp;&nbsp;<span>10,000/100</span>
                    </div>
                </div>
                <div>
                    <ul class="btn">
                        <li><button type="button" onclick="location.href='{{ url('/') }}'">취소</button></li>
                        {{-- <li><a href="">등록</a></li> --}}
{{--                        @isset($channel)--}}
                        @if(isset($channel))
                            <li><button type="submit" class="submit">수정</button></li>
                        @else
                            <li>
                                <button type="submit" class="submit">등록</button>
                            </li>
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
