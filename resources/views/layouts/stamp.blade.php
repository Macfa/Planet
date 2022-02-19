<!-- Modal -->
<div>
    <div class="modal-header justify-content-start">
        <div class="mr-4">
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
                        <button onclick="selectCategory({{ $category->id }});">
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
                                <img src="{{ asset($stamp->image) }}" />
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
