<script>
    var checkPost = "{{ request()->route()->named("post.show") }}";
    if (checkPost === "1") {
        let url = window.location.href;
        var tmpPostID = url.split('/').pop();
        if ($.isNumeric(tmpPostID)) {
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


    $("#open_post_modal").on('hide.bs.modal', function (event) {
        if (event.target.id === 'open_post_modal') {
            if (history.state === "modal") {
                var isOpen = $("#openStampModal").hasClass("show");
                if (isOpen) {
                    history.back();
                }
            }
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
</script>
