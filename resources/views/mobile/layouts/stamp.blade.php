<!-- Modal -->
<div>
    <div class="modal-header justify-content-start">
        <div class="mr-4 pl-4">
            <span style="font-size: 25px;">스탬프</span>
        </div>
        <div>
            <img style="width: 28px;" src="{{ asset('image/coin_4x.png') }}" alt="coin">
            {{--                    {{ number_transform() }}--}}
            @auth
                <span style="line-height: 100%; vertical-align: middle;">{{ coin_transform() }}</span>
            @endauth
        </div>
    </div>
    {{--            <div class="modal-body d-flex">--}}
    <div class="d-flex modal-body-section">
        <input type="hidden" name="id">
        <input type="hidden" name="type">
        <div class="wid70 pt-3">
            <div class="stamp-left pl-4">
                <nav id="category-header" class="d-flex justify-content-start">
                    {{-- Categories --}}
                    <button onclick="selectCategory(0);">모두</button>
                    {{--                        {{ dd(\App\Models\StampCategory::getAllCategories()) }}--}}
                    @foreach($allCategories as $category)
                        <button class="ml-5" onclick="selectCategory({{ $category->id }});">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </nav>
                <div id="category-data" class="mt-4">
                    <div class="category-data-list">
                        <ul class="d-flex">
                            @foreach($allStamps as $stamp)
                                <li class="stamp-list">
                                    {{--                            <button onclick="purchaseStamp({{ $stamp->id }}, {{ $post->id }});">--}}
                                    <button onclick="selectStamp({{ $stamp->id }});">
                                        <img src="{{ asset('image/'.$stamp->image) }}" />
                                        <p class="mt-1">{{ $stamp->coin }}</p>
                                    </button>
                                </li>
                                {{--                        <li class="stamp-list">--}}
                                {{--                            <button onclick="purchaseStamp({{ $stamp->id }}, 1);">--}}
                                {{--                                <img src="/image/2_1629657939.gif" />--}}
                                {{--                                <p class="mt-1">{{ $stamp->coin }}</p>--}}
                                {{--                            </button>--}}
                                {{--                        </li>--}}
                                {{--                        <li class="stamp-list">--}}
                                {{--                            <button onclick="purchaseStamp({{ $stamp->id }}, 1);">--}}
                                {{--                                <img src="/image/2_1629657939.gif" />--}}
                                {{--                                <p class="mt-1">{{ $stamp->coin }}</p>--}}
                                {{--                            </button>--}}
                                {{--                        </li>--}}
                            @endforeach
                        </ul>
                    </div>
                    {{--                to be delete items --}}
                </div>
            </div>
        </div>
        <div class="wid30 border-left pt-3" id="selectStampItem">
        </div>
    </div>
</div>
<script>
{{--    function selectStamp(id) {--}}
{{--        $.ajax({--}}
{{--            url: "/stamp/"+id,--}}
{{--            data: {--}}
{{--                stampID: id--}}
{{--            },--}}
{{--            type: "get",--}}
{{--            success: function (data) {--}}
{{--                var replaceData = {--}}
{{--                    'id': data.id,--}}
{{--                    'coin': data.coin,--}}
{{--                    'name': data.name,--}}
{{--                    'image': '/image/'+data.image,--}}
{{--                    'description': data.description,--}}
{{--                    'hasCoin': data.hasCoin,--}}
{{--                    'afterPurchaseCoin': data.afterPurchaseCoin--}}
{{--                };--}}
{{--                $("#openStampModal #selectStampItem .category-data-item").remove();--}}
{{--                $("#selectStampTemplate").tmpl(replaceData).prependTo("#openStampModal #selectStampItem");--}}
{{--            },--}}
{{--            errror: function (err) {--}}
{{--                alert("관리자에게 문의해주세요");--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}
{{--    function selectCategory(id) {--}}
{{--        $.ajax({--}}
{{--            url: "/category/",--}}
{{--            data: {--}}
{{--                categoryId: id--}}
{{--            },--}}
{{--            type: "get",--}}
{{--            success: function (data) {--}}
{{--                console.log(data.length);--}}
{{--                // console.log(data);--}}
{{--                // console.log(id);--}}
{{--                var replaceData = [];--}}
{{--                for(var i=0; i<data.length; i++) {--}}
{{--                    replaceData.push({--}}
{{--                        'stampId': data[i].id,--}}
{{--                        'stampImage': '/image/'+data[i].image,--}}
{{--                        'stampCoin': data[i].coin,--}}
{{--                    })--}}
{{--                    console.log(replaceData);--}}
{{--                }--}}
{{--                $(".category-data-list ul.d-flex li").remove();--}}
{{--                $("#stampListTemplate").tmpl(replaceData).appendTo(".category-data-list ul.d-flex");--}}
{{--            },--}}
{{--            errror: function (err) {--}}
{{--                alert("관리자에게 문의해주세요");--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}
{{--    function purchaseStamp(stampID) {--}}
{{--        var type = $("#openStampModal input[name=type]").val();--}}
{{--        var id = $("#openStampModal input[name=id]").val();--}}
{{--        // var url = '';--}}
{{--        // if(type === "post") {--}}
{{--        // }--}}

{{--        if(confirm('구매하시겠습니까 ?')) {--}}
{{--            $.ajax({--}}
{{--                url: "/stamp/purchase",--}}
{{--                data: {--}}
{{--                    stampID: stampID,--}}
{{--                    type: type,--}}
{{--                    id: id--}}
{{--                },--}}
{{--                type: "post",--}}
{{--                success: function (data) {--}}
{{--                    $("#total_coin").text(data.currentCoin);--}}
{{--                    $("#openStampModal").modal("hide");--}}
{{--                    if(data.target === "post") {--}}
{{--                        if(data.method == "create") {--}}
{{--                            $(".modal-title .stamps").append(`<span class="stamp-${stampID}"><img style='width:31px;' alt='${data.name}' src='/image/${data.image}' ></span>`);--}}
{{--                        } else if(data.method == "update") {--}}
{{--                            $(`.modal-title .stamps span[class="stamp-${stampID}"] span`).text(data.count);--}}
{{--                        }--}}
{{--                    } else if(data.target === "comment") {--}}
{{--                        if(data.method == "create") {--}}
{{--                            // $(".modal-title .stamps").append(`<span class="stamp-${stampID}"><img style='width:31px;' alt='${data.name}' src='${data.image}' alt=''></span>`);--}}
{{--                        } else if(data.method == "update") {--}}
{{--                            // $(`.modal-title .stamps span[class="stamp-${stampID}"] span`).text(data.count);--}}
{{--                        }--}}
{{--                    }--}}

{{--                    alert("스탬프 정상 구매하였습니다");--}}
{{--                },--}}
{{--                error: function (err) {--}}
{{--                    if(err.errorCode === 401) {--}}
{{--                        alert("로그인이 필요한 기능입니다");--}}
{{--                    } else {--}}
{{--                        alert("코인이 부족합니다");--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}
{{--<script id="stampListTemplate" type="text/x-jquery-tmpl">--}}
{{--    @{{each groups}}--}}
{{--        <li class="stamp-list">--}}
{{--            <button onclick="selectStamp(${stampId});">--}}
{{--                <img src="${stampImage}" />--}}
{{--                <p class="mt-1">${stampCoin}</p>--}}
{{--            </button>--}}
{{--        </li>--}}
{{--    @{{/each}}--}}
{{--</script>--}}
{{--<script id="selectStampTemplate" type="text/x-jquery-tmpl">--}}
{{--    <div class="category-data-item">--}}
{{--        <div class="item-header text-center">--}}
{{--            <img src="${image}" alt="stamp" class="item-img">--}}
{{--                <p class="mt-1 item-name">${name}</p>--}}
{{--                <p class="mt-1 item-description">${description}</p>--}}
{{--                <div>--}}
{{--                    <img style="width: 24px;" src="/image/coin_4x.png" alt="coin">--}}
{{--                        <span class="item-coin">${coin}</p>--}}
{{--                </div>--}}
{{--        </div>--}}
{{--        <div class="mt-4 item-body d-flex justify-content-end mr-2">--}}
{{--            <ul style="display: block">--}}
{{--                <li>보유 코인 : ${hasCoin}</li>--}}
{{--                <li>결제 코인 : ${coin}</li>--}}
{{--                <li>남은 코인 : ${afterPurchaseCoin}</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <div class="purchase-btn-section mt-4 mb-4 text-center">--}}
{{--            <button onclick="purchaseStamp(${id})" class="base-btn">구입</button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</script>--}}
