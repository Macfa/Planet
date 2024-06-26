@extends('mobile.layouts.master')

@section('main')
<section id="main">
    <div class="main-wrap">
        <article class="board_box">
            <div class="left">
                <div class="category_title">최근 방문한 토픽</div>
                <ul class="category flex-container flex-nowrap channel-history justify-content-start align-items-center">
                    <div><a href="/">실시간 화제글</a></div>
                    @foreach ($channelVisitHistories as $history)
                        @if($loop->first)
                            <span>/</span>
                        @endif
                        {{--                            <li style="flex: 1 1 20%; text-overflow: ellipsis;" class="history_channel_{{ $history->channel_id }}">--}}
                        <div>
                            <a href="{{ route('channel.show', $history->channel_id) }}">{{ $history->channel->name }}</a>
                        </div>
                        @if($loop->remaining)
                            <span>/</span>
                        @endif
                        {{--                            </li>--}}
                    @endforeach
                </ul>
                {{--                @endauth--}}

                {{-- search, user.show, content  --}}
                @hasSection('mobile.content-mainmenu')
                    @yield('mobile.content-mainmenu')
                @endif
                @hasSection('mobile.content-search')
                    @yield('mobile.content-search')
                @endif
                @hasSection('mobile.content-mypage')
                    @yield('mobile.content-mypage')
                @endif
                @hasSection('mobile.content-channel')
                    @yield('mobile.content-channel')
                @endif

                @hasSection('mainlist')
                    @yield('mainlist')
                @endif
            </div>
        </article>
    </div>
</section>
<div id="footer">
    <section>
        <section class="container-fluid">
            <nav style="padding: 8px; text-align: center;" class="flex-container flex-justify-space-between">
                {{--        <li><a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif">게시글 작성</a></li>--}}
                <a href="@if(auth()->check()) {{ route('channel.create') }} @else javascript:notLogged(); @endif"
                   class="col">토픽 만들기</a>
                <a href="javascript:$('.list').animate({ scrollTop: 0}, 300);" class="col">맨 위로</a>
                <a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif"
                   class="col">글쓰기</a>
            </nav>
        </section>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // 무한 스크롤
    var page = 1;
    var checkRun = false;

    function loadMoreData(page) {
        var channelID = "{{ request()->route('channel.id') }}";
        var type = $(".tab .on").attr('value');
        // var readPost = JSON.parse(localStorage.getItem('readPost'));

        $.ajax({
            url: '/mainMenu',
            type: 'get',
            data: {
                "page": page,
                'type': type,
                'channelID': channelID,
                // 'readPost': readPost
            },
            success: function (data) {
                var valueList = [];
                if (data.result.length === 0) {
                    // toastr.info("데이터가 없습니다");
                } else {
                    addDataPlaceHolder();
                    var postIdArr = [];
                    for (var i = 0; i < data.result.length; i++) {
                        valueList.push({
                            "totalLike": data.result[i].totalLike,
                            "post_id": data.result[i].id,
                            "postTitle": data.result[i].title,
                            "commentCount": data.result[i].comments_count,
                            "postChannelID": data.result[i].channel.id,
                            "channelName": data.result[i].channel.name,
                            "userName": data.result[i].user.name,
                            "user_id": data.result[i].user.id,
                            "created_at_modi": data.result[i].created_at_modi,
                            "postImage": data.result[i].image,
                            "stamps": data.result[i].stamps,
                        });
                        postIdArr.push(data.result[i].id);
                    }
                    delay(function () {
                        removeDataPlaceHolder();
                        $("#mainMenuItem").tmpl(valueList).insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
                        addReadPost(postIdArr);
                    }, 1500);
                }
                // $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
            },
            error: function (err) {
                console.log(err);
            }
        })
    }

    function addDataPlaceHolder() {
        $("#dataPlaceHolder").tmpl().insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
    }

    function removeDataPlaceHolder() {
        $("#main .main-wrap .left .list table tbody tr:last-child").remove();
        checkRun = false;
    }

    $(document).ready(function () {
        // setContentHeight();
        $('#main .tab li').click(function (event) {
            $('#main .tab li').removeClass('on');
            $(this).addClass('on');
        });

        $(window).on('popstate', function (e) {
            if (e.type === "popstate") {
                var stampModalState = $("#openStampModal").hasClass('show');
                var postModalState = $("#open_post_modal").hasClass('show');
                if (stampModalState) {
                    // 뒤로가기
                    // history.go();
                    $("#openStampModal").modal("hide");
                } else if(postModalState) {
                    $("#open_post_modal").modal("hide");
                } else {
                    // 앞으로 가기
                    let url = window.location.href;
                    var tmpPostID = url.split('/').pop();
                    if ($.isNumeric(tmpPostID)) {
                        // $(`#post-${tmpPostID} .title a`).get(0).click();
                        openPostModal(tmpPostID);
                    }
                }
            }

        });
        var checkPost = "{{ request()->route()->named("post.show") }}";
        if(checkPost === "1") {
            let url = window.location.href;
            var tmpPostID = url.split('/').pop();

            if($.isNumeric(tmpPostID))
            {
                openPostModal(tmpPostID);
            }
        }
        $(".list").scroll(function (event) {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if (checkRun === false) {
                    checkRun = true;
                    loadMoreData(page);
                    page++;
                }
            }
        });
        let vh = window.innerHeight * 0.01;

        document.documentElement.style.setProperty('--vh', `${vh}px`);
        window.addEventListener('resize', () => {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
            // set Content Max-Height
            setContentHeight();
        });
        setContentHeight();
        $('#open_post_modal').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
        });
        var myCollapsible = document.getElementById('header-noti');
        if(myCollapsible) {
            myCollapsible.addEventListener('show.bs.collapse', function () {
                $.ajax({
                    type: "get",
                    url: "/mark",
                })
            });
        }
    });
    $("#collapseOne").on('shown.bs.collapse', function() {
        var height = $("#collapseOne .accordion-body-channelinfo").height();
        var beforeChangeValue = parseFloat($("#main .main-wrap .left .list").css('max-height'));
        var afterChangeValue = beforeChangeValue - height;

        $("#main .main-wrap .left .list").css('max-height', afterChangeValue);
    })
    $("#collapseOne").on('hide.bs.collapse', function() {
        var height = $("#collapseOne .accordion-body-channelinfo").height();
        var beforeChangeValue = parseFloat($("#main .main-wrap .left .list").css('max-height'));
        var afterChangeValue = height + beforeChangeValue;

        $("#main .main-wrap .left .list").css('max-height', afterChangeValue);
    })
    $("#open_post_modal").on('hide.bs.modal', function (event) {
        if (event.target.id === 'open_post_modal') {
            if (history.state === "modal") {
                var isOpen = $("#openStampModal").hasClass("show");
                if (isOpen) {
                    history.back();
                }
            }
        } else if (event.target.id === 'openStampModal') {

            // if (history.state === "modal") {
            //     var isOpen = $("#openStampModal").hasClass("show");
            //     if (isOpen) {
            //         history.back();
            //     }
            // }
        }
    });
    $("#open_post_modal").on('show.bs.modal', function (event) {
        if (event.target.id === 'open_post_modal') {
            var button = event.relatedTarget;
            if(button) {
                var postID = button.getAttribute('data-bs-post-id');
                openPostModal(postID);
            }

        } else if (event.target.id === 'openStampModal') {
            var modalBody = $("#openStampModal .modal-content");
            var button = event.relatedTarget;
            var id = button.getAttribute('data-bs-id');
            var type = button.getAttribute('data-bs-type');

            $.ajax({
                url: '/stamp',
                type: 'get',
                success: function (data) {
                    modalBody.html(data);
                    $("#openStampModal").on('shown.bs.modal', function (event) {
                        // event.stopPropagation();
                        $("#openStampModal input[name=type]").val(type);
                        $("#openStampModal input[name=id]").val(id);
                        $("#category-data .stamp-list:first button").click();
                    });
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }
    });

    function openPostModal(postID) {
        var modalBody = $(".modal-content");
        var urlPath = '';

        if (history.state == null) {
            urlPath = "/post/" + postID;
        } else {
            urlPath = location.href;
        }


        $.ajax({
            url: '/post/' + postID + "/get",
            type: 'get',
            success: function (data) {
                modalBody.html(data);
                if(history.state === null) {
                    history.pushState('modal', 'modal', urlPath);
                }
                var readPost = JSON.parse(localStorage.getItem('readPost'));

                if (readPost === null) {
                    // 읽은 게시글이 없으면 새로 추가
                    localStorage.setItem('readPost', JSON.stringify([postID]));
                    var exist = $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).hasClass('visited');
                    if (exist === false)
                    {
                        $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).addClass('visited');
                    }
                } else {
                    //
                    var checkExist = readPost.includes(postID.toString());
                    if (checkExist === false) {
                        readPost.push(postID);
                        localStorage.setItem('readPost', JSON.stringify(readPost));
                        $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).addClass('visited');
                    }
                }
                var readPosts = JSON.parse(localStorage.getItem('readPost'));
                setCookie("readPost", readPosts);

                setModalHeight();
                $('#open_post_modal').modal('show');
                // $.fn.modal.Constructor.prototype.enforceFocus = function () {};
                // var button = event.relatedTarget;
                // $("#openStampModal").on('hide.bs.modal', function(event) {
                //     event.stopPropagation();
                // });
            },
            error: function (err) {
                console.log(err);
            }
        })
    }
    function setContentHeight() {
        let list = $(".list").offset().top;
        let footer = $("#footer").offset().top;

        let distance = footer - list;
        $(".list").css("max-height", distance);
    }
    function setModalHeight() {
        let height = $("#header").outerHeight();
        $("#open_post_modal").css("top", height);
    }
    // function setContentHeight() {
    //     let list = $(".list").offset().top;
    //     let footer = $("#footer").offset().top;
    //
    //     let distance = footer - list;
    //     $(".list").css("max-height", distance);
    // }
    function willRemove() {
        location.href = "/test2";
    }

    function getCookie(key) {
        var cookie = document.cookie;
        var cookies = cookie.split(";");

        for(var i=0; i<cookies.length; i++) {
            var item = cookies[i].split("=");
            if(key === item[0].trim()) {
                return item[1];
            }
        }
    }
    function setCookie(key, value) {
        document.cookie = key + "=" + value;
    }
    function getSearchCategory(type) {
        $("#searchType").val(type);
        $("#mainSearchForm").submit();
    }

    function clickMainMenu(type) {
        var channelID = "{{ request()->route('channel.id') }}";

        $.ajax({
            url: '/mainMenu',
            type: 'get',
            data: {
                'type': type,
                'channelID': channelID
            },
            success: function (data) {
                var valueList = [];
                $("#main .main-wrap .left .list table tbody tr").remove();
                if (data.result.length === 0) {
                    // valueList.push("<tr class='none-tr'><td>데이터가 없습니다.</td></tr>");
                    var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                    $("#main .wrap .left .list table tbody").html(value);
                } else {
                    var postIdArr = [];
                    for (var i = 0; i < data.result.length; i++) {
                        var notice = (data.result[i].notice) ? 'style=background-color:#d7aeae' : ''
                        // console.log(data.result[i]);
                        valueList.push({
                            "totalLike": data.result[i].totalLike,
                            "post_id": data.result[i].id,
                            "postTitle": data.result[i].title,
                            "commentCount": data.result[i].comments_count,
                            "postChannelID": data.result[i].channel.id,
                            "channelName": data.result[i].channel.name,
                            "userName": data.result[i].user.name,
                            "user_id": data.result[i].user.id,
                            "stampInPosts": data.result[i].stamp_in_posts,
                            "created_at_modi": data.result[i].created_at_modi,
                            "postImage": data.result[i].image,
                            "stamps": data.result[i].stamps,
                            "notice": notice,
                        });
                        postIdArr.push(data.result[i].id);
                    }
                    $("#mainMenuItem").tmpl(valueList).appendTo("#main .main-wrap .left .list table tbody");
                    addReadPost(postIdArr);
                    checkRun = false;
                }
                page = 1;
                $("#main .wrap .left .tab li[class=" + type + "]").attr('class', 'on');
            },
            error: function (err) {
                console.log(err);
            }
        })
    }
</script>
<script id="mainMenuItem" type="text/x-jquery-tmpl">
<tr id="post-${post_id}" class="post-title" ${notice}>
    <td>
        <div class="thum" style="background-size: contain; background-image: url('${postImage}');"></div>
    </td>
    <td>
        <div class="title">
            <a href="#post-show-${post_id}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="${post_id}" data-bs-channel-id="${postChannelID}" data-bs-target="#open_post_modal">
            <p>${postTitle}&nbsp;&nbsp;</p>
            @{{if commentCount > 0}}
                <span class="titleSub">[&nbsp;<span class="commentCount">${commentCount}</span>&nbsp;]</span>
            @{{/if}}
            </a>
        </div>
        <div class="stamps">
        @{{each stamps}}
            <div class="stamp-item stamp-${id} multi-stamps">
                <img src="${image}" alt="" />
                <span class="stamp_count">${stampTotalCount}</span>
            </div>
        @{{/each}}
        </div>
        <div class="user">
            <p><span><a href="/channel/${postChannelID}">[ ${channelName} ]</a></span> ${created_at_modi} / <a href="/user/${userID}">${userName}</a></p></div>
        </div>
    </td>
    </tr>
</script>
<script id="dataPlaceHolder" type="text/x-jquery-tmpl">
<tr>
    <td><div class="thum" style="background-image:url('/image/thum.jpg')"></div></td>
    <td>
        <div class="title">
            <p class="placeholder col-6"></p>
        </div>
        <div class="user">
            <p class="placeholder col-4"></p>
        </div>
    </td>
</tr>
</script>
@endpush
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/post/show.css') }}">
@endpush
