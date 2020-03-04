<style media="screen">

.header section {
position: relative;

}
.header .inner {
	position: absolute;
	left: 0;
	right: 0;
	height: 43px;
	z-index: 9;
	background-color: #fff;
}

[data-role="menu"].nav:hover {
	border-left: 1px solid rgba(0,0,0,.1);
}

[data-role="menu"].nav:hover .nav-item {
	border-right: 1px solid rgba(0,0,0,.1);
	background-color: #fff;
}

[data-role="menu"].nav .nav-item:hover {
	background-color: #f8f9fa
}

[data-role="menu"].nav:hover .nav-link {
	border-bottom: 1px solid rgba(0,0,0,.1);
}

.header [data-role="menu"] > .nav-item.active > .nav-link::after,
.header [data-role="menu"] > .nav-item:hover > .nav-link::after {
  left: 0;
  right: 0;
}

[data-role="menu"].nav .nav-item ul {
	width: 100%;
	height: calc(100% - 48px);
	z-index: 1;
	opacity: 0;
	margin: 0;
	padding: 0;
	font-size: 13px;
	font-weight: normal;
}

[data-role="menu"].nav:hover .nav-item ul {
	padding-top: 10px;
	transition: all 0.4s;
	transition-timing-function: ease;
	opacity: 1;
}

[data-role="menu"].nav .nav-item ul li {
  width: 100%;
  padding-bottom: 10px;
  text-align: center;
  font-size: 15px;
  letter-spacing: -1px;
  font-weight: normal;
	list-style: none;
}
[data-role="menu"].nav .nav-item ul li a {
	display: block;
	padding: 5px 0 0 0;
	color: #444;
	text-decoration: none;
}
[data-role="menu"].nav .nav-item ul li a:hover {
	text-decoration: underline;
}

</style>


  <li class="nav-item">
    <a href="https://www.oss.kr/oss_intro" class="nav-link" target="_self">공개SW 소개</a>
    <ul>
      <li><a href="https://www.oss.kr/oss_intro" target="_self">공개SW 개요</a></li>
      <li><a href="https://www.oss.kr/oss_importance" target="_self">공개SW 중요성</a></li>
      <li><a href="https://www.oss.kr/oss_trend" target="_self">공개SW 동향</a></li>
      <li><a href="https://www.oss.kr/oss_use" target="_self">공개SW 활용</a></li>
      <li><a href="https://www.oss.kr/oss_license" target="_self">공개SW 라이선스</a></li>
      <li><a href="https://www.oss.kr/oss_faq" target="_self">공개SW에 대한 진실</a></li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="https://www.oss.kr/plaza_intro" class="nav-link" target="_self">공개SW 사업</a>
    <ul>
      <li><a href="https://www.oss.kr/plaza_intro" target="_self">공개SW 역량프라자</a></li>
      <li><a href="https://www.oss.kr/dev_support_intro" target="_self">공개SW 개발지원사업</a></li>
      <li><a href="https://www.oss.kr/dev_competition" target="_self">공개SW 개발자대회</a></li>
      <li><a href="https://www.oss.kr/forum_intro" target="_self">공개SW 국제협력</a></li>
      <li><a href="https://www.oss.kr/kosslab" target="_self">공개SW 개발자센터</a></li>
      <li><a href="https://www.oss.kr/startup_center" target="_self">공개SW 창업지원센터</a></li>
      <li><a href="https://www.oss.kr/ability_up" target="_self">공개SW 역량강화 교육</a></li>
      <li><a href="https://www.oss.kr/contributhon_overview" target="_self">공개SW 컨트리뷰톤</a></li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="https://www.oss.kr/solution_guide" class="nav-link" target="_self">정보마당</a>
    <ul>
      <li><a href="https://www.oss.kr/solution_guide" target="_self">공개SW 활용 가이드</a></li>
      <li><a href="https://www.oss.kr/info_sec" target="_self">공개SW 보안취약점</a></li>
      <li><a href="https://www.oss.kr/oss_case" target="_self">공개SW 활용 성공사례</a></li>
      <li><a href="https://www.oss.kr/tech_support_intro" target="_self">공개SW 기술지원</a></li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="https://www.oss.kr/notice" class="nav-link" target="_self">열린마당</a>
    <ul>
      <li><a href="https://www.oss.kr/notice" target="_self">공지사항</a></li>
      <li><a href="https://www.oss.kr/news" target="_self">공개SW 소식</a></li>
      <li><a href="https://www.oss.kr/event" target="_self">공개SW 행사 안내</a></li>
      <li><a href="https://www.oss.kr/user_question" target="_self">공개SW 라이선스 문의</a></li>
      <li><a href="https://www.oss.kr/qna" target="_self">공개SW 묻고답하기</a></li>
      <li><a href="https://www.oss.kr/news_letter" target="_self">공개SW 뉴스레터</a></li>
      <li><a href="https://www.oss.kr/private_qna/create" target="_self">Contact Us</a></li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="https://www.oss.kr/data_hub" class="nav-link" target="_self">데이터 허브</a>
    <ul>
      <li><a href="https://www.oss.kr/open_os" target="_self">개방형 OS</a></li>
    </ul>
  </li>
