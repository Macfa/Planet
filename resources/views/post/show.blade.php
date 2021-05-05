@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
<div class="modal-parent">
    <div class="modal-wrap">
        <div class="modal-top">
            <div class="modal-page">
                <div class="arrow-top">
                    <img src="{{ asset('image/arrow-top.png') }}" alt="앞으로" />
                </div>
                
                <span class="now-page">{{ $post->like }}</span>
                
                <div class="arrow-bot">
                    <img src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" />
                </div>
            </div>
            
            <div class="modal-title">
                <h4>
                    {{ $post->title }} [{{ $post->comments_count }}]
                </h4>
            </div>
            
            <div class="write-info">
                <p><span><a href="{{ route('channelShow', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('userMypage', 'post') }}">{{ $post->memberID }}</a> / n분 전</p>
            </div>
            
            <div class="modal-close">
                <img src="{{ asset('image/close.png') }}" alt="닫기" />
            </div>
        </div>
        
        <div class="modal-body">
            <!-- 왼쪽 게시글 내용 -->
            <div class="modal-left">
                <div class="modal-content">
                    <div class="board-text">
                        <p>
                            {{ $post->content }}
                        </p>
                    </div>
                    
                    <!-- 게시글 기타 기능 -->
                    <div class="board-etc-function" id="post">
                        <ul>
                            <li>
                                <img @click="upvote({{ $post->id }})" src="{{ asset('image/square-small.png') }}" alt="" />
                                
                                <div class="function-text">
                                    <p>{{ $post->like }}</p>
                                </div>
                            </li>
                            <li>
                                <img src="{{ asset('image/square-small.png') }}" alt="" />
                            </li>
                            <li>
                                <img src="{{ asset('image/square-small.png') }}" alt="" />
                                
                                <div class="function-text">
                                    <p>스탬프</p>
                                </div>
                            </li>
                            <li>
                                <img src="{{ asset('image/square-small.png') }}" alt="" />
                                
                                <div class="function-text">
                                    <p>공유</p>
                                </div>
                            </li>
                            <li>
                                <img src="{{ asset('image/square-small.png') }}" alt="" />
                                
                                <div class="function-text">
                                    <p>스크랩</p>
                                </div>
                                {{-- <scrap-template></scrap-template> --}}
                            </li>
                            <li>
                                <img src="{{ asset('image/square-small.png') }}" alt="" />
                                
                                <div class="function-text">
                                    <p>신고</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    @include('post.comment');
                
                <!-- 오른쪽 광고배너 -->
                <div class="modal-right">
                    <div class="modal-banner">
                        <div class="banner-item">
                            <h3>광고 배너</h3>
                        </div>
                        
                        <div class="banner-item">
                            <h3>광고 배너</h3>
                        </div>
                        
                        <div class="banner-item">
                            <h3>광고 배너</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        new Vue({
            el: '#post',
            data: {
                vote: null,
            },
            methods: {
                upvote(id) {
                    alert("처리되었습니다.");
                    axios.post("/post/upvote/"+id)
                    .then((res) => {
                        console.log(res);
                    })
                    .catch(function(err) {
                        console.log(err);
                    })
                },
                commentUpvote: function(id) {
                    alert("comment : "+id);
                }
            },
        });
    </script>