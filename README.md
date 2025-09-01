# Planet
커뮤니티 방향의 사이트

### Current 
운영 중이던 EC2 작업 삭제 후 일부 복원결과물
리팩토링 단계 진행 중 refactoring.md 참고

### Preview 
![메인](./public/image/scr_monde_index.png)
![페이지](./public/image/scr_monde.png)

### Changelog
- ChannelVisitHistoryService 반환값 누락으로 인한 null 문제 수정
- 게시글 모달(openPostModal) 및 댓글 처리 로직 개선

### how to use ?
npm i && composer i 
open docker application
sail up -d
sail artisan migrate

### Specs
Laravel
jquery
ckeditor5