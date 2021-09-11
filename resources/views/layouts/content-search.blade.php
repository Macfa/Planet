@section('mainmenu')
<ul class="tab">
    <li value="a" @if($searchType === 'a') class="on" @endif><a href="javascript:search('a')">제목+내용</a></li>
    <li value="t" @if($searchType === 't') class="on" @endif><a href="javascript:search('t')">제목</a></li>
    <li value="c" @if($searchType === 'c') class="on" @endif><a href="javascript:search('c')">내용</a></li>
</ul>
@endsection

@section('message')
    검색결과가 없어요 !
@endsection
