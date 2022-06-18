@extends('admin.master')

@section('content')
    <div class="container">
        <div>
            <table>
                <thead>
                    <tr>
                        <th>num</th>
                        <th>게시글명</th>
                        <th>작성자</th>
                        <th>신고자</th>
                        <th>신고횟수</th>
                        <th>[]</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td><a href="/post/{{ $post->reportable_id }}" target="_blank">{{ $post->title }}</a></td>
                        <td>{{ $post->posts.user-> }}</td>
                        <td>{{ $post->totalCount }}</td>
                        <td>ex) buttons</td>
                    </tr>
                    @empty
                        <tr><td>글이 없습니다</td></tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
