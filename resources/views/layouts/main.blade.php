@extends('layouts.master')

@section('main')
    <section id="main">
        <div class="main-wrap">
            <article class="board_box d-flex">
                <div class="left col-9">
                    <ul class="category">
                        <div class="category_title">최근 방문한 토픽</div>
                        {{-- <ul class="channel-history d-flex flex-nowrap justify-content-between align-items-center"> --}}
                        <ul class="channel-history d-flex flex-nowrap align-items-center">
                            <div><a href="{{ route('home') }}">실시간 화제글</a></div>
                            {{-- @auth --}}
                            @foreach ($channelVisitHistories as $history)
                                <div>
                                    {{-- <li class="channel_{{ $history->channel_id }}"> --}}
                                    <a
                                        href="{{ route('channel.show', $history->channel_id) }}">{{ $history->channel->name }}</a>
                                    {{-- </li> --}}
                                </div>
                            @endforeach
                            {{-- @endauth --}}
                        </ul>
                    </ul>


                    @hasSection('content-mainmenu')
                        @yield('content-mainmenu')
                    @endif
                    @hasSection('content-search')
                        @yield('content-search')
                    @endif
                    @hasSection('content-mypage')
                        @yield('content-mypage')
                    @endif
                    @hasSection('content-channel')
                        @yield('content-channel')
                    @endif

                    @hasSection('mainlist')
                        @yield('mainlist')
                    @endif
                </div>
                <div class="right col-3 p-4">
                    @yield('sidebar')
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // 무한 스크롤
        var page = 1;
        var checkRun = false;
        var popstate = false;

        $(document).ready(function() {
            $(window).on('popstate', function(e) {
                if (e.type === "popstate") {
                    // 자바스크립트 히스토리 API - 뒤로 또는 앞으로 가기
                    popstate = true;
                    var stampModalState = $("#openStampModal").hasClass('show');
                    var postModalState = $("#open_post_modal").hasClass('show');
                    if (stampModalState) {
                        // 뒤로가기
                        // history.go();
                        $("#openStampModal").modal("hide");
                    } else if (postModalState) {
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
                } else {
                    popstate = false;
                }
            });
            var checkPost = "{{ request()->route()->named('post.show') }}";
            if (checkPost === "1") {
                let url = window.location.href;
                // window.location.href = window.location.origin;
                var tmpPostID = url.split('/').pop();
                if ($.isNumeric(tmpPostID)) {
                    // history.pushState('asd', 'asd', window.location.origin);
                    // $(`#main #post-${tmpPostID} a[data-bs-post-id=${tmpPostID}]`).get(0).click();
                    openPostModal(tmpPostID);
                }
            }
            $(window).scroll(function(event) {
                if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                    if (checkRun === false) {
                        checkRun = true;
                        loadMoreData(page);
                        page++;
                    }
                }
            });

            $('#main .right .best>ul li').click(function() {
                $('#main .right .best li').removeClass('on');
                $(this).addClass('on');
            });

            // clickSidebarMenu('realtime');
            $('#main .right .best > ul .realtime').click();
        });

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
                success: function(data) {
                    var valueList = [];
                    if (data.result.length === 0) {
                        // alert("데이터가 없습니다");
                    } else {
                        addDataPlaceHolder();
                        var postIdArr = [];
                        for (var i = 0; i < data.result.length; i++) {
                            valueList.push({
                                "totalLike": data.result[i].totalLike,
                                "postID": data.result[i].id,
                                "postTitle": data.result[i].title,
                                "commentCount": data.result[i].comments_count,
                                "postChannelID": data.result[i].channel.id,
                                "channelName": data.result[i].channel.name,
                                "userName": data.result[i].user.name,
                                "user_id": data.result[i].user.id,
                                "created_at_modi": data.result[i].created_at_modi,
                                "postImage": data.result[i].image,
                                "stamps": data.result[i].stamps,
                                // "multiClassName": multiClassName,
                            });
                            postIdArr.push(data.result[i].id);
                        }
                        delay(function() {
                            removeDataPlaceHolder();
                            $("#mainMenuItem").tmpl(valueList).insertAfter(
                                "#main .main-wrap .left .list table tbody tr:last-child");
                            addReadPost(postIdArr);
                        }, 1500);
                    }
                    // $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        function addDataPlaceHolder() {
            $("#dataPlaceHolder").tmpl().insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
        }

        function removeDataPlaceHolder() {
            // 스크롤 시  생기는 placeholder 삭제
            $("#main .main-wrap .left .list table tbody tr:last-child").remove();
            checkRun = false;
        }

        function toggleUnread() {
            var checkExist = getCookie("unread");

            if(checkExist === null || checkExist === "undefined" || checkExist == 0) {
                setCookie("unread", 1);
            } else {
                setCookie("unread", 0);
            }
            location.reload();
        }

        $("#open_post_modal").on('hide.bs.modal', function(event) {
            // 게시글이 닫힐 떄 ( 모달 밖 클릭하는 경우 핸들링을 위한 이벤트 )
            if (event.target.id === 'open_post_modal') {
                var videos = $("iframe");
                if (videos.length >= 1) {
                    videos.each(function(idx, val) {
                        var src = $(this).attr('src');
                        $(this).attr('src', src);
                    });
                }
                $('video').trigger('pause');

                if (history.state === "modal") {
                    var isOpen = $("#open_post_modal").hasClass("show");

                    if (isOpen) {
                        history.back();
                    }
                }
            } else if (event.target.id === 'openStampModal') {
                var isOpen = $("#open_post_modal").hasClass("show");
                if (isOpen && popstate) {  // 뒤로가기 시, 게시글이 열려있으면 처리

                    $("#open_post_modal").modal("hide");
                }
            }
        });
        $("#open_post_modal").on('show.bs.modal', function(event) {
            if (event.target.id === 'open_post_modal') {
                var button = event.relatedTarget;
                if (button) {
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
                    success: function(data) {
                        modalBody.html(data);
                        $("#openStampModal").on('shown.bs.modal', function(event) {
                            // event.stopPropagation();
                            $("#openStampModal input[name=type]").val(type);
                            $("#openStampModal input[name=id]").val(id);
                            $("#category-data .stamp-list:first button").click();
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            }
        });

        $('#main .tab li').click(function(event) {
            $('#main .tab li').removeClass('on');
            $(this).addClass('on');
        });

        function willRemove() {
            location.href = "/test2";
        }

        function getSearchCategory(type) {
            $("#searchType").val(type);
            $("#mainSearchForm").submit();
        }

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
                success: function(data) {
                    modalBody.html(data);
                    if (history.state === null) {
                        history.pushState('modal', 'modal', urlPath);
                    }
                    var readPost = JSON.parse(localStorage.getItem('readPost'));

                    if (readPost === null) {
                        // 읽은 게시글이 없으면 새로 추가
                        localStorage.setItem('readPost', JSON.stringify([postID]));
                        var exist = $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).hasClass('visited');
                        if (exist === false) {
                            $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).addClass('visited');
                        }
                    } else {
                        var checkExist = readPost.includes(postID.toString());
                        if (checkExist === false) {
                            readPost.push(postID);
                            localStorage.setItem('readPost', JSON.stringify(readPost));
                            $(`#main #post-${postID} a[data-bs-post-id=${postID}]`).addClass('visited');
                        }
                    }
                    var readPosts = JSON.parse(localStorage.getItem('readPost'));
                    setCookie("readPost", readPosts);

                    $('#open_post_modal').modal('show');
                },
                error: function(err) {
                    console.log(err);
                }
            })
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
        function clickMainMenu(type) {
            var channelID = "{{ request()->route('channel.id') }}";

            $.ajax({
                url: '/mainMenu',
                type: 'get',
                data: {
                    'type': type,
                    'channelID': channelID
                },
                success: function(data) {
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
                            valueList.push({
                                "totalLike": data.result[i].totalLike,
                                "postID": data.result[i].id,
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
                error: function(err) {
                    console.log(err);
                }
            })
        }
    </script>
    <script id="mainMenuItem" type="text/x-jquery-tmpl">
        <tr id="post-${postID}" ${notice}>
            <td>
                <span class="
                @{{ if totalLike > 0 }}
                updown up
                @{{ else totalLike < 0 }}
                updown down
                @{{ else }}
                updown dash
                @{{ /if }}
                ">${totalLike}</span>
            </td>
            <td>
                <div class="thum" style="background-size: contain; background-image: url('${postImage}');"></div>
            </td>
            <td>
                <div class="title">
                    <a href="#post-show-${postID}" data-bs-toggle="modal" data-bs-post-id="${postID}" data-bs-channel-id="${channel_id}" data-bs-target="#open_post_modal">
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
            </td>
        </tr>
        </script>
    <script id="dataPlaceHolder" type="text/x-jquery-tmpl">
        <tr>
            <td>
                <span class="updown dash"></span>
            </td>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
@endpush
