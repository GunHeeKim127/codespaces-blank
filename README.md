# PHP + MariaDB Admin Lab
로컬 화이트햇/웹 취약점 점검 실습용 더미 관리자 사이트입니다.

구성:
- PHP 8.x + PDO
- MariaDB
- 로그인/세션
- 관리자 권한 관리
- 콘텐츠 게시판 CRUD
- 동영상 업로드
- 대시보드
- 일부러 단순하게 만든 보안 실습 지점

기본 계정:
admin / admin123
editor / editor123
viewer / viewer123

실행:
1. MariaDB에서 sql/schema.sql 실행
2. public/config.php의 DB 접속정보 수정
3. php -S localhost:8080 -t public
4. http://localhost:8080/login.php

주의: 실제 서비스에 배포하지 말고 로컬/격리된 실습 환경에서 사용하세요.
