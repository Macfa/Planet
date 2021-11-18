$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var timer = null;


$(document).ready(function () {

    $('#open_post_modal').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });
    $("#header .header_icon_clickable a").click(function(){
        $('.multi-collapse').collapse('hide');
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
                    event.preventDefault()
                    event.stopPropagation()
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

