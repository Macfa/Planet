@section('mobile.content-search')
<ul class="tab">
    <li value="a" @if($searchType === 'a') class="on" @endif><a href="javascript:getSearchCategory('a')">제목+내용</a></li>
    <li value="t" @if($searchType === 't') class="on" @endif><a href="javascript:getSearchCategory('t')">제목</a></li>
    <li value="c" @if($searchType === 'c') class="on" @endif><a href="javascript:getSearchCategory('c')">내용</a></li>
</ul>
@endsection

@section('mobile.message')
    검색결과가 없어요 !
@endsection
