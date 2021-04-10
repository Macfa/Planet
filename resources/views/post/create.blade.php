@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/post/create.css') }}">
<section id="channel">
  <div class="wrap">
    <article class="board_box">
        <div class="select_box">
            <select class="cst_select" name="" id="">
                <option value="">등록할 채널을 선택해주세요</option>
            </select>
        </div>        
      <div class="left">
        <div class="list">
            <form action="">
                <div class="input_box">
                    <span class="menu">포스트</span>
                </div>
                <div class="input_box">
                    <input type="text" class="box" placeholder="이름을 입력하세요">
                </div>
                <div class="input_box">
                    <textarea name="" class="text_box" id="" placeholder="정보를 적어주세요"></textarea>
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
                        <li><a href="#">등록</a></li>
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
