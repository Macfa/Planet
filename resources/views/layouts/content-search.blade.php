@section('content-search')
<ul class="tab_title">
    검색결과
</ul>
<ul class="tab">
    <li value="a" @if($searchType === 'a') class="on" @endif><a href="javascript:getSearchCategory('a')">제목+내용</a></li>
    <li value="t" @if($searchType === 't') class="on" @endif><a href="javascript:getSearchCategory('t')">제목</a></li>
    <li value="c" @if($searchType === 'c') class="on" @endif><a href="javascript:getSearchCategory('c')">내용</a></li>
    <li value="ch" @if($searchType === 'ch') class="on" @endif><a href="javascript:getSearchCategory('ch')">토픽</a></li>
</ul>
@endsection

@section('message')
    검색결과가 없어요 !
@endsection
