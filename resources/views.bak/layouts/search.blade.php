@section('search')
    <ul class="tab">
        <li @if($searchType === 'a') class="on" @endif><a href="javascript:search('a')">제목+내용</a></li>
        <li @if($searchType === 't') class="on" @endif><a href="javascript:search('t')">제목</a></li>
        <li @if($searchType === 'c') class="on" @endif><a href="javascript:search('c')">내용</a></li>
    </ul>
@endsection
