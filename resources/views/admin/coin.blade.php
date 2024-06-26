@extends('admin.master')

@section('content')
    @if (session('status'))
        <div class="alert alert-success w-100">
            {{ session('msg') }}
        </div>
    @endif

    <div class="container">
        <form action="/admin/coin/set" method="post">
            @csrf
            <div>
                <div class="header">
                    코인 설정
                </div>
                <div class="body">
                    <div class="mb-3">
                        <label for="post" class="form-label">글 작성</label>
                        <input type="text" class="form-control" id="post" placeholder="" name="post" value="{{ $coin_setup->post ?? 0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">댓글 작성</label>
                        <input type="text" class="form-control" id="comment" placeholder="" name="comment" value="{{ $coin_setup->comment ?? 0}}">
                    </div>
{{--                    <div class="mb-3">--}}
{{--                        <label for="formGroupExampleInput3" class="form-label">화재글등극기준</label>--}}
{{--                        <input type="text" class="form-control" id="formGroupExampleInput3" placeholder="" name="issue" readonly>--}}
{{--                    </div>--}}
                    <div class="mb-3">
                        <label for="post_limit" class="form-label">글 일일최대제한</label>
                        <input type="text" class="form-control" id="post_limit" placeholder="" name="post_limit" value="{{ $coin_setup->post_limit ?? 0}}">
                    </div>
                    <div class="mb-3">
                        <label for="comment_limit" class="form-label">일일최대제한</label>
                        <input type="text" class="form-control" id="comment_limit" placeholder="" name="comment_limit" value="{{ $coin_setup->comment_limit ?? 0}}">
                    </div>
                    <div><button type="submit">등록</button></div>
                </div>
            </div>
        </form>
    </div>
@endsection
