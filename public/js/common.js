$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "1500",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

var timer = null;


$(document).ready(function () {

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

    $.ajax({
        type: "get",
        url: "/searchHelper",
        data: {
            'searchText': word
        },
        success: function(data) {
            var elementToPlace = $("#header-search");
            var dataToAppend = [];

            elementToPlace.children().remove();

            if(data['list'] === null) {
                // pass
                // dataToAppend.push('<a href="" class="list-group-item list-group-item-action">검색</a>');
            } else {
                $.each(data['list'], function(idx,val) {
                    if(data['type'] == "channel") {
                        dataToAppend.push('<a href="/channel/'+val['id']+'" class="list-group-item list-group-item-action">'+val['name']+'</a>');
                    } else if(data['type'] == "post") {
                        dataToAppend.push('<a href="/post/'+val['id']+'" class="list-group-item list-group-item-action">'+val['title']+'</a>');
                        // dataToAppend.push('<a href="/post/'+val['id']+'" class="list-group-item list-group-item-action">'+val['title']+'</a>');
                    }
                });
            }
            elementToPlace.append(dataToAppend);
        },
        error: function(err) {
            // console.log(err);
        }
    })
}


function notLogged() {
    // if(!auth()->check()) {
    toastr.warning("로그인이 필요한 기능입니다");
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

