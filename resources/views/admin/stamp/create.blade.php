@extends('admin.master')

@section('content')
    <div class="container" style="max-height:600px; overflow:scroll;">
        <form action="/admin/stamp/store" method="post" enctype="multipart/form-data">
            @csrf
            <label>카테고리 :
                <select name="category_id">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>이미지 :
                <input type="file" name="image" value="">
            </label>
            <label>이름 :
                <input type="text" name="name" value="">
            </label>
            <label>설명 :
                <input type="text" name="description" value="">
            </label>
            <label>코인 :
                <input type="text" name="coin" value="">
            </label>
            <label>별칭 :
                <input type="text" name="abbr" value="">
            </label>
            <input type="submit" value="생성">
        </form>
    </div>
@endsection
