@extends('admin.master')

@section('content')
    <div class="container" style="max-height:600px; overflow:scroll;">
        <form action="/admin/stampCategory/store" method="post" enctype="multipart/form-data">
            @csrf
            <label>이름 :
                <input type="text" name="name" value="">
            </label>
            <label>이미지 :
                <input type="file" name="image" value="">
            </label>
            <input type="submit" value="생성">
        </form>
    </div>
@endsection
