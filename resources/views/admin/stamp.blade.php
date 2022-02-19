@extends('admin.master')

@section('content')
    <div class="container" style="max-height:600px; overflow:scroll;">
        <div>
            <a href="/admin/stamp/create">생성</a>
        </div>
        <div class="list">
            <table>
                <thead>
                <tr>
                    <th>num</th>
                    <th>category</th>
                    <th>image</th>
                    <th>name</th>
                    <th>description</th>
                    <th>coin</th>
                    <th>abbr</th>
                </tr>
                </thead>
                <tbody>
                @forelse($stamps as $stamp)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $stamp->category->name }}</td>
                        <td><img src="{{ asset($stamp->image) }}" alt="img" /></td>
                        <td>{{ $stamp->name }}</td>
                        <td>{{ $stamp->description }}</td>
                        <td>{{ $stamp->coin }}</td>
                        <td>{{ $stamp->abbr }}</td>
                        <td>
                            <form action="/stamp/{{ $stamp->id }}" method="post">
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
