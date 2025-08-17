    public function store(Request $request)
    {
        $this->authorize('create', Channel::class);
        
        // Trim input before validation
        // 수정사유: trim()을 validation 전에 적용하여 일관된 데이터 검증
        $request->merge(['name' => trim($request->name)]);

        // Validation rules and messages
        // 수정사유: 주석을 더 명확하게 구분하고, 사용하지 않는 주석 제거
        $rules = [
            'name' => 'required|unique:channels|max:40|min:2',
            'description' => 'required|max:255',
        ];

        $messages = [
            'name.required' => '토픽명을 입력해주세요.',
            'description.required' => '토픽 소개란을 입력해주세요.',
            'name.min' => '토픽명은 최소 2 글자 이상입니다.',
            'name.max' => '토픽명은 40 글자 이하입니다.',
            'description.max' => '토픽 소개란은 최대 255 글자 이하입니다.',
            'name.unique' => '토픽명이 이미 사용 중입니다.'
        ];

        // Validate request
        // 수정사유: Validator::make 대신 request->validate() 사용으로 코드 간소화
        $request->validate($rules, $messages);

        // Get authenticated user
        // 수정사유: User::find(auth()->id()) 대신 auth()->user() 사용으로 코드 간소화
        $user = auth()->user();
        $hasCoin = $user->hasCoins()->sum('coin');
        $toUseCoin = 20;

        if ($hasCoin < $toUseCoin) {
            // 수정사유: response()->redirectTo 대신 redirect() 헬퍼 함수 사용
            return redirect('/')->with([
                'status' => 'warning',
                'msg' => '코인이 부족합니다'
            ]);
        }

        // Create channel
        // 수정사유: $request->input() 대신 $request->name 사용으로 코드 간소화
        $channel = Channel::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id
        ]);

        // Deduct coins
        // 수정사유: 주석을 더 명확하게 변경
        // 수정사유: 코인 모델의 일관성 유지 및 데이터 무결성 보장을 위해 코인 차감 로직 개선
        $user->coins()->create([
            'type' => '토픽생성',
            'coin' => -$toUseCoin,
            'user_id' => $user->id
        ]);

        // 수정사유: return 문을 더 읽기 쉽게 포맷팅
        return redirect()
            ->route('channel.show', $channel->id)
            ->with([
                'status' => 'success',
                'message' => '생성되었습니다'
            ]);
    }