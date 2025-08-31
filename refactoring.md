# Refactoring

### How to Refactoring
	기존에 만든 프로젝트를 대상으로 한다
	규칙을 정의하고 책임을 분리
	프론트 대부분 유지 ( 일부 기능 제거 및 수정 )
	디비 설계 일부 수정

### RULE
* 네이밍 정의 
	서비스 메서드는 '비즈니스적 행위'를 나타내는 동사를 사용한다.
	Get (데이터 조회): getRecentPosts(), getUserProfile()
	Create (데이터 생성): createNewComment(), registerUser()
	Process (복잡한 처리): processPayment(), handleOrderCancellation()
	Calculate (계산): calculateShippingFee()

	레포지토리 메서드는 '데이터 접근 방식'을 나타내는 동사를 사용한다.
	Find (단일 데이터 조회): findById(), findBySlug()
	Get (여러 데이터 조회): getAll(), getLatestPosts()
	Save/Update (데이터 저장/수정): save(), updateStatus()
	Delete (데이터 삭제): deleteById(), deleteExpiredTokens()


* 컨트롤러 책임
	서비스, 레포지토리 분리

* 서비스 컨테이너, 프로바이더 이해

* 패키지 활용
	Gate, 
* 화면 구성
  React 대체 ( 미정 )

* 모바일 구성
  플러터로 대체 ( 미정 )

* 도메인 설계 및 모델링
	...미정
	
* 디비 재설계
	...미정
