@extends('layouts.master')

@section('main')
<section id="channel">
  <div class="channel_wrap">
    <article class="board_box d-flex">
      <div class="left col-9">
        <div class="page_info mb30"><h2>토픽 만들기</h2></div>
        <div class="list">
                @if(isset($channel))
                    <form action="{{ route('channel.update', $channel->id) }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                    @method('PUT')
                @else
                    <form action="{{ route('channel.store') }}" method="POST" name="searchForm" onsubmit="return checkValue();">
                @endif
                @csrf
                <div class="input_box input_box_title">
                    <div class="sub_box sub_box_line">
                        <span class="menu">이름</span>
                    </div>
                    <div class="sub_box">
                        <input type="text" name="name" class="box is-invalid" placeholder="이름을 입력하세요" @if(isset($channel)) value="{{ $channel->name }}" readonly @else value="{{ ($channel->name) ?? old('name')}}" @endif >
                        @error('name')
{{--                            <span class="text-danger">{{ $errors->first('name') }}</span>--}}
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input_box">
                    <div class="sub_box sub_box_line">
                        <span class="menu">설명</span>
                    </div>
                    <div class="mt10 sub_box">
                        <textarea name="description" class="text_box is-invalid" id="" placeholder="내용을 입력하세요">@if(isset($channel)){{ $channel->description }}@else{{ ($channel->description) ?? old('description') }}@endif</textarea>
                        @error('description')
{{--                            <span class="text-danger">{{ $errors->first('description') }}</span>--}}
                            <div class="invalid-feedback">{{ $message }}</div>
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
                        <li><button type="button" class="btn_cancle" onclick="history.back();">취소</button></li>
                        {{-- <li><a href="">등록</a></li> --}}
{{--                        @isset($channel)--}}
                        @if(isset($channel))
                            <li><button type="submit" class="submit btn_enter">수정</button></li>
                        @else
                            <li>
                                <button type="submit" class="submit btn_enter">등록</button>
                            </li>
                        @endif
                    </ul>
                </div>
            </form>
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
    </article>
  </div>
</section>

@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/channel/create.css') }}">
@endpush
<script>
    function checkValue()
    {
        let form = document.searchForm;

        if(form.name.value === "")
        {
            alert("이름을 입력해주세요");
            return false;
        }
        if(form.name.value.length < 2 || form.name.value.length > 12)
        {
            alert("이름 양식은 2글자 이상 12글자 이하 입니다");
            return false;
        }
        if(form.description.value === "" || form.description.value.length > 255)
        {
            alert("설명을 입력해주세요 ( 255자 이하 )");
            return false;
        }
    }
</script>
