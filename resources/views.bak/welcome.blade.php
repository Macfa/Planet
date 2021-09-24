<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>포디엄 보드</title>
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
</head>
<body>
<div id="body">
{{--    header--}}
    <div class="header">
        <div class="logo">
            logo
        </div>
        <div class="headerMargin headerSearchSection">
            <input type="text" id="headerSearch" placeholder="검색..." id="search">
        </div>
        <div class="headerMargin headerRightSection">
            <button class="btn headerJoin">회</button>
            <button class="btn headerLogin">로</button>
        </div>
    </div>
{{--    main--}}
    <div class="main">
        <div class="banner">
            banner
        </div>
        <div class="board">
            <div class="category">포디엄</div>
            <div class="tab"></div>
        </div>
    </div>
</div>
</body>
</html>
