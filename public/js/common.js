$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var timer = null;

$(document).ready(function () {
    // $(document).off('focusin.modal');
    var readPostList = JSON.parse(localStorage.getItem("readPost"));
    if(readPostList !== null) {
        readPostList.forEach(function(val, idx, arr) {
            $(`#main #post-${val} a[data-bs-post-id=${val}]`).addClass('visited');
        });
    }

    $("#header .header_icon_clickable a").click(function(){
        $('.multi-collapse').collapse('hide');
    });

    $(document).click(function (event) {
        var clickover = $(event.target);
        var _opened = $(".multi-collapse").hasClass("show");

        if (_opened === true && !clickover.hasClass("header-collapse-icon-img")) {
            $("li.header_icon a.header-collapse-icon:not(.collapsed)").click();
        }
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

    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    // event.preventDefault()
                    // event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })

});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function addReadPost(vals) {
    var lastVals = [];
    if (typeof(vals) === "object") {
        // 무한스크롤로 대량을 데이터를 끌고 올 때,
        var readPostList = JSON.parse(localStorage.getItem("readPost"));
        if(readPostList !== null) {
            vals.forEach(function(val, idx) {
                var exist = readPostList.includes(val.toString());
                if(exist)
                {
                    lastVals.push(val);
                }
            });
        }
    } else {
        // 게시글을 클릭했을 경우
        lastVals.push(vals);

    }
    lastVals.forEach(function (val, idx, arr) {
        var exist = $(`#main #post-${val} a[data-bs-post-id=${val}]`).hasClass('visited');
        if (exist === false)
        {
            $(`#main #post-${val} a[data-bs-post-id=${val}]`).addClass('visited');
        }
    });
}

function searchingCallback() {
    // var timer = null;

    if (timer) {
        window.clearTimeout(timer);
    }
    timer = window.setTimeout( function() {
        timer = null;
        search();
    }, 600 );
}

function search() {
    var obj = $("input[name=searchText]");
    var word = obj.val();
    var dataToAppend = [];

    $.ajax({
        type: "get",
        url: "/searchHelper",
        data: {
            'searchText': word
        },
        success: function(data) {
            var elementToPlace = $("#searched-list");

            if(data['list']) {
                $.each(data['list'], function(idx,val) {
                    if(data['type'] === "channel") {
                        dataToAppend.push('<option label="in channel">'+val['name']+'</option>');
                    } else if(data['type'] === "post") {
                        dataToAppend.push('<option label="in post">'+val['title']+'</option>');
                    }
                });
                    // alert(1);
                elementToPlace.children().remove();
                elementToPlace.html(dataToAppend);
            }
        },
        error: function(err) {
            // console.log(err);
        }
    })
}


function notLogged() {
    // if(!auth()->check()) {
    // toastr.warning("로그인이 필요한 기능입니다");
    alert("로그인이 필요한 기능입니다");
    return;
    // }
}

// (function () {
//     'use strict'
//
//     // Fetch all the forms we want to apply custom Bootstrap validation styles to
//     var forms = document.querySelectorAll('.needs-validation')
//
//     // Loop over them and prevent submission
//     Array.prototype.slice.call(forms)
//         .forEach(function (form) {
//             form.addEventListener('submit', function (event) {
//                 if (!form.checkValidity()) {
//                     event.preventDefault()
//                     event.stopPropagation()
//                 }
//
//                 form.classList.add('was-validated')
//             }, false)
//         })
// })()

