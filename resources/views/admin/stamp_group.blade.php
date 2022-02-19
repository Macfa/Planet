@extends('admin.master')

@section('content')
    <div class="container" style="max-height:600px; overflow:scroll;">
        <div>
            <a href="/admin/stampCategory/create">생성</a>
        </div>
        <div class="list">
            <table>
                <thead>
                <tr>
                    <th>num</th>
                    <th>name</th>
                    <th>image</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td><img src="{{ asset($category->image) }}" alt="img" /></td>
                        <td>
                            <form action="/category/{{ $category->id }}" method="post">
                                @method("delete")
                                @csrf
                                <input type="submit" value="del" />
                            </form>
                    </tr>
                @empty
                    <tr>
                        <td>데이터가 없습니다</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
