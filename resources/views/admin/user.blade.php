@extends('admin.master')

@section('content')
<div class="container" style="max-height:600px; overflow:scroll;">
    <table class="table">
        <thead>
            <tr>
                <th>idx</th>
                <th>name</th>
                <th>email</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td><a href="#">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
