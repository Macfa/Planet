@section('mainlist')
    <div class="list">
        <table>
            <colgroup>
{{--                @if(!blank($posts))--}}
{{--                    <col style="width:40px;">--}}
{{--                    <col style="width:75px;">--}}
{{--                    <col style="width:100%;">--}}
{{--                @endif--}}
            </colgroup>
            @forelse ($posts as $list)
                <tr>
                    <td>
                        <div class="p-1 ml-1">
{{--                            <div class="float-left">--}}
                            <a style="font-size:15px;" class="float-left" href="{{ route('channel.show', $list->id) }}">{{ $list->name }}</a>
{{--                            </div>--}}
{{--                            <div class="float-right">--}}
                            <p class="float-right">
                                가입 수:&nbsp;
                                <span class="total">
{{--                                    {{ dd($list) }}--}}
                                    {{ number_transform($list->count('user_id')) }}
                                </span>
                                &nbsp;명
{{--                            </div>--}}
                            </p>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="none-tr">
                    <td>
                        @yield('message')
                    </td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
