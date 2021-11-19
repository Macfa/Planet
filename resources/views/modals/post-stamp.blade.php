<!-- Modal -->
<div class="modal fade" id="openStampModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:250px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4>스탬프 목록</h4>
                {{--                            <input type="text" name="searchStamp" />--}}
            </div>
            <div class="modal-body">
                <div class="">
                    <nav id="category-header" class="flex-container">
                        @forelse(\App\Models\StampCategory::getAllCategories() as $category)
                            <button class="col" onclick="selectCategory({{ $category->id }});">
                                {{--                                                                                <img style="width:25px;" src="{{ asset($category->image) }}" alt="{{ $category->name }}">--}}
                                {{ $category->name }}
                            </button>
                        @empty
                            <div>데이터가 없습니다.</div>
                        @endforelse
                        <button class="col" onclick="return false;">테스트1</button>
                        <button class="col" onclick="return false;">테스트2</button>
                        <button class="col" onclick="return false;">테스트3</button>
                    </nav>
                    <div id="category-data">
                        @forelse(\App\Models\StampGroup::getDataFromCategory(1) as $group)
                            <div>
                                <div>
                                    <span id="group-name">{{ $group->name }}</span>
                                </div>
                                @forelse($group->stamps as $stamp)
                                    <div>
                                        <ul class="flex-container">
                                            <li class="col">
                                                <button onclick="purchaseStamp({{ $stamp->id }}, {{ $post->id }});">
                                                    <img src="{{ $stamp->image }}" />
                                                    <span>{{ $stamp->coin }}</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        @empty
                        @endforelse
                        <div>
                            <div>
                                <span id="group-name">동물</span>
                            </div>
                            <div>
                                <button onclick="return false;">
                                    <img src="/image/2_1629657939.gif" />
                                    <span>100</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div>
                                <span id="group-name">고양이</span>
                            </div>
                            <div>
                                <button onclick="return false;">
                                    <img src="/image/2_1629657939.gif" />
                                    <span>1500</span>
                                </button>
                            </div>
                        </div>
                        {{--                                    테스트 영역 끝--}}
                    </div>
                </div>
            </div>
            {{--                        <div class="modal-footer">--}}
            {{--                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
            {{--                            <button type="button" class="btn btn-primary">Save changes</button>--}}
            {{--                        </div>--}}
        </div>
    </div>
</div>
<script>
    function selectCategory(categoryID) {
        // alert(categoryID);
        $.ajax({
            url: "/stamp",
            data: { categoryID: categoryID },
            type: "get",
            success: function(data) {
                var result = {
                    'groups': data
                };
                $("#openStampModal #category-data > div").remove();
                $("#stampDataTemplate").tmpl(result).appendTo("#openStampModal #category-data");
            },
            errror: function(err) {
                alert("기능에러로 스탬프를 불러오지 못 했습니다.");
            }
        });
    }
    function purchaseStamp(stampID, postID) {
        if(confirm('구매하시겠습니까 ?')) {
            $.ajax({
                url: "/stamp/purchase",
                data: {
                    stampID: stampID,
                    postID: postID
                },
                type: "post",
                success: function (data) {
                    console.log(data);
                    $("#total_coin").text(data.currentCoin);
                    $("#openStampModal").hide();
                    if(data.method == "create") {
                        $(".modal-title .stamps").append(`<span class="stamp-${stampID}"><img style='width:31px;' src='${data.image}' alt=''><span></span></span>`);
                        console.log(`<span class="stamp-${stampID}"><img style='width:31px;' src="${data.image}" alt=''></span>`);
                    } else if(data.method == "update") {
                        $(`.modal-title .stamps span[class="stamp-${stampID}"] span`).text(data.count);
                    }
                    console.log(`.modal-title .stamps span[class="stamp-${stampID}"] span`);
                    console.log(data.count);

                    toastr.info("스탬프 정상 구매하였습니다");
                },
                errror: function (err) {
                    toastr.warning("기능에러로 스탬프를 불러오지 못 했습니다");
                }
            });
        }
    }
</script>
