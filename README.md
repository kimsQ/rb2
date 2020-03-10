# kimsQ Rb2

## 개요

## 설치환경

- PHP 7 이상
- MySQL 5.5 이상 또는 mariadb-10.0.x 이상
- https

### 웹서버 설정
- CGI 사용안함
- htaccess 사용
- [git 설치](https://git-scm.com/book/ko/v2/%EC%8B%9C%EC%9E%91%ED%95%98%EA%B8%B0-Git-%EC%84%A4%EC%B9%98)


### PHP 확장모듈
- CURL
- ZEND 2.x
- GD 2.x
- ICONV
- dom/xml

### PHP 설정
- allow_url_fopen : 허용안함
- register_globals : 허용안함
- magic_quotes_gpc : 허용


## 설치하기

### 터미널(SSH)을 통한 설치
1. <code>git init</code>
1. <code>git remote add origin https://github.com/kimsQ/rb2.git</code>
1. <code>git pull origin master</code>
1. <code>chmod 707  _var</code>
1. 브라우저를 통해 index.php 를 호출합니다.

### 인스톨러를 통한 설치
1. rb-installer.zip 을 [다운](https://github.com/kimsQ/rb2/archive/installer.zip) 받습니다.
1. 압축해제 후, rb-installer 폴더 내부의 index.php 를 FTP를 이용하여 서버계정 폴더에 업로드 합니다.
1. 브라우저를 통해 index.php 를 호출합니다.

## 업데이트
원격 업데이트는 킴스큐의 기본 패키지 파일들을 항상 최신의 상태로 유지할 수 있는 시스템입니다.
킴스큐 Rb2 저장소 의 master 브랜치의 최신 코드가 적용됩니다.
수정하거나 추가한 코드가 있을 경우, 수정내역이 삭제되므로 업데이트 실행전 레이아웃 또는 테마를 별도저장 해주세요.
최신패치는 git을 통해 동작하며 명령어 실행을 위해서는 서버에 git이 설치되어 있어야 합니다.

### 관리자모드를 통한 업데이트
- 데스크탑 : 관리자 모드 > 시스템 > 업데이트
- 모바일 : 설정 > 소프트웨어 정보 > 업데이트

### 수동 업데이트
터미널 접속 후 아래의 명령어를 순차적으로 실행합니다.
1. <code>git reset --hard</code>
1. <code>git pull origin master</code>

### 업데이트시 특정 파일 제외 방법
터미널 접속 후 아래의 명령어를 실행합니다.
- 제외목록에 추가 :  <code>git update-index --skip-worktree [file]</code>
- 제외목록에서 제외 :  <code>git update-index --no-skip-worktree [file]</code>

## 메뉴얼

[메뉴얼 보기](http://kimsq.com/docs)


## 라이센스
- 체험 및 교육과 비영리 목적 으로만 무료사용을 허가 합니다.
- 개인과 기업의 영리목적 사용을 위해서는 도메인 단위로 라이센스를 구매 하셔야 합니다.
- 무단 재배포를 금지 합니다.
- 본 소프트웨어는 (주)레드블럭에 저작권이 있습니다.
- 기타 문의 break@redblock.co.kr
