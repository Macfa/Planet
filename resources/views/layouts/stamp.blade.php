<!-- Modal -->
<div>
    <div class="modal-header justify-content-start">
        <div class="mr-4">
            <span style="font-size: 25px;">스탬프</span>
        </div>
        <div>
            <img style="width: 28px;" src="{{ asset('image/coin_4x.png') }}" alt="coin">
            @auth
                <span style="line-height: 100%; vertical-align: middle;">{{ coin_transform() }}</span>
            @endauth
        </div>
    </div>
    <div class="d-flex modal-body-section">
        <input type="hidden" name="id">
        <input type="hidden" name="type">
        <div class="wid70 pt-3">
            <div class="stamp-left pl-4">
                <nav id="category-header" class="d-flex justify-content-start">
                    <button onclick="selectCategory(0);">모두</button>
                    @foreach($allCategories as $category)
                        <button onclick="selectCategory({{ $category->id }});">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </nav>
                <div id="category-data" class="mt-4">
                <div class="category-data-list">
                    <ul style="display: grid; grid-template-columns: repeat(5, 1fr)">
                        @foreach($allStamps as $stamp)
                            <li class="stamp-list">
                                <button onclick="selectStamp({{ $stamp->id }});">
                                    <img src="{{ asset($stamp->image) }}" />
                                    <p class="mt-1">{{ $stamp->coin }}</p>
                                </button>
                            </li>
                            @if($loop->index+1 % 5 == 0)
                                </ul>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="wid30 border-left pt-3" id="selectStampItem">
        </div>
    </div>
</div>
<script>
