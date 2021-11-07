// 무한 스크롤
var page = 1;
var checkRun = false;

$(window).scroll(function(event) {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if(checkRun == false) {
            checkRun = true;
            loadMoreData(page);
            page++;
        }
    }
});

function loadMoreData(page) {
    var channelID = "{{ request()->route('channel') }}";
    var type = $(".tab .on").attr('value');

    $.ajax({
        url: '/mainMenu',
        type: 'get',
        data: {
            "page": page,
            'type': type,
            'channel_id': channelID
        },
        success: function (data) {
            var valueList = [];
            if (data.result.length == 0) {
                // alert("데이터가 없습니다");
            } else {
                addDataPlaceHolder();
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
                        "created_at_modi": data.result[i].created_at_modi
                    });
                }
                delay(function() {
                    removeDataPlaceHolder();
                    $("#mainMenuItem").tmpl(valueList).insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
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

$(document).ready(function(){
    // $(window.location.hash).modal('show'); // URL 입력 확인 후 모달 오픈
    $(window).on('popstate', function(e) {
        if(e.type == "popstate") {
            var modalState = $("#open_post_modal").hasClass('show');
            if(modalState) {
                $("#open_post_modal").modal("hide");
            } else {
            }
        }
    });
});
// $(document).on('show.bs.modal', '#open_post_modal', function (event) {
$("#open_post_modal").on('hide.bs.modal', function(event) {
    if(history.state == "modal") {
        history.back();
    }
});
$("#open_post_modal").on('show.bs.modal', function(event) {
    if (event.target.id == 'open_post_modal') {
        var button = event.relatedTarget;
        // var button = event.currentTarget;

        // console.log(button.getAttribute('data-bs-post-id'));
        var postID = button.getAttribute('data-bs-post-id');
        var channelID = button.getAttribute('data-bs-channel-id');
        var modalBody = $(".modal-content");
        // console.log(history);
        if(history.state == null) {
            var urlPath = "/channel/"+channelID+"/post/"+postID;
        } else {
            var urlPath = location.href;
        }


        $.ajax({
            url: '/post/getPostData/'+postID,
            type: 'get',
            success: function(data) {
                modalBody.html(data);
                history.pushState('modal', 'modal', urlPath);
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
    // else if (event.target.id == 'openStampModal') {
    //     // do stuff when the outer dialog is hidden.
    // }
});

// var open_post_modal = document.getElementById('open_post_modal')
// open_post_modal.addEventListener('show.bs.modal', function (event) {
//     // event.stopPropagation();
//     // Button that triggered the modal
//
// })

$('#main .tab li').click(function(event){
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
function clickMainMenu(type) {
    // var channelID = "{{ request()->route('channel') }}";
    // alert(channelID);

    $.ajax({
        url: '/mainMenu',
        type: 'get',
        data: {
            'type': type,
            // 'channel_id': channelID
        },
        success: function(data) {
            var valueList = [];
            $("#main .main-wrap .left .list table tbody tr").remove();
            if(data.result.length==0) {
                // valueList.push("<tr class='none-tr'><td>데이터가 없습니다.</td></tr>");
                var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                $("#main .wrap .left .list table tbody").html(value);
            } else {
                for(var i=0; i<data.result.length; i++) {
                    valueList.push({
                        "totalLike": data.result[i].totalLike,
                        "postID": data.result[i].id,
                        "postTitle": data.result[i].title,
                        "commentCount": data.result[i].comments_count,
                        "postChannelID": data.result[i].channel.id,
                        "channelName": data.result[i].channel.name,
                        "userName": data.result[i].user.name,
                        "user_id": data.result[i].user.id,
                        "created_at_modi": data.result[i].created_at_modi
                    });
                }
                $("#mainMenuItem").tmpl(valueList).appendTo("#main .main-wrap .left .list table tbody");
            }
            page = 1;
            $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
        },
        error: function(err) {
            console.log(err);
        }
    })
}
