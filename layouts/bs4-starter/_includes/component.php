<!--
컴포넌트 모음

1. 일반모달 : 회원가입
2. 일반모달 : 로그인
3. 일반모달 : 알림
4. 일반모달 : 게시물 보기
5. 일반모달 : 게시물 쓰기
6. 포토모달 : 댓글형
7. 포토모달 : 갤러리형
8. 마크업 참조: 링크공유
-->

<!-- 1. 일반모달 : 회원가입 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_main'].'/join/component.php'; ?>

<!-- 2. 일반모달 : 로그인 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_main'].'/login/component.php';  ?>

<!-- 3. 일반모달 : 알림 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_main'].'/noti/component.php';  ?>

<!-- 4. 일반모달 : 게시물 보기-->
<div class="modal" id="modal-bbs-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <input type="hidden" name="bid" value="">
  <input type="hidden" name="uid" value="">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 95%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" data-role="title">게시물 보기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="닫기(Esc)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">

        <div class="row no-gutters">
          <main class="col-7">
            <div data-role="article"></div>
          </main>
          <aside class="col-5 border-left">
            <div class="commentting-container" data-role="comment-area"></div>
            <div data-role="comment-alert" class="d-none">
              <div class="d-flex align-items-center justify-content-center text-muted" style="height: calc(100vh - 9.5rem);">
                댓글이 지원되지 않습니다.
              </div>
            </div>
          </aside>
        </div><!-- /.row -->

      </div><!-- /.modal-body -->

    </div>
  </div>
</div>

<!-- 5. 일반모달 : 게시물 쓰기 -->
<?php
if ($m=='bbs') {
  $bbs_component = $g['path_module'].'bbs/themes/'.$d['bbs']['skin'].'/component.php';
  if (file_exists($bbs_component)) include_once $bbs_component;
}
?>

<!-- 6. 포토모달 : 댓글형 -->
<div class="pswp pswp-comment" tabindex="-1" role="dialog" aria-hidden="true">
  <input type="hidden" name="uid" value="">
  <input type="hidden" name="bid" value="">
  <div class="pswp__bg"></div>

  <!-- Slides wrapper with overflow:hidden. -->
  <div class="pswp__scroll-wrap">

    <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>

    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
    <div class="pswp__ui pswp__ui--hidden">

      <div class="pswp__top-bar">

        <!--  Controls are self-explanatory. Order can be changed. -->
        <div class="pswp__subject">
          <span data-role="category" class="text-primary"></span>
          <span data-role="subject"></span>
        </div>
        <div class="pswp__counter"></div>
        <button class="pswp__button pswp__button--fs" data-toggle="tooltip" title="전체 화면으로 보기"></button>

        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
        <!-- element will get class pswp__preloader-active when preloader is running -->
        <div class="pswp__preloader">
          <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>

      <button class="pswp__button pswp__button--arrow--left" title="이전">
            </button>

      <button class="pswp__button pswp__button--arrow--right" title="다음">
            </button>

      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>

    </div>

  </div>

  <div class="rb__area">
    <div data-role="article"></div>
    <div class="commentting-container mt-4" data-role="comment-area"></div>
    <div data-role="comment-alert" class="d-none">
      <div class="d-flex align-items-center justify-content-center text-muted" style="height: calc(100vh - 27.5rem);">
        댓글이 지원되지 않습니다.
      </div>
    </div>
  </div>

  <button class="pswp__button pswp__button--close" data-toggle="tooltip" title="닫기(Esc)"></button>

</div>

<!-- 7. 포토모달 : 갤러리형 -->
<div class="pswp pswp-gallery" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="닫기 (Esc)"></button>

                <button class="pswp__button pswp__button--fs" title="전체화면 보기"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader-active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

          </div>

        </div>

</div>

<!-- 8. 마크업 참조 : 링크공유 -->
<div id="rb-share" hidden>
  <ul class="share list-inline mt-2 mb-0 mx-2">
    <li class="list-inline-item text-center">
      <a href="" role="button" data-role="facebook" target="_blank" class="muted-link">
        <img src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북공유" class="rounded-circle" style="width: 50px">
        <p><small>페이스북</small></p>
      </a>
    </li>
    <li class="list-inline-item text-center">
      <a href="" role="button" data-role="kakaostory" target="_blank" class="muted-link">
        <img src="<?php echo $g['img_core']?>/sns/kakaostory.png" alt="카카오스토리" class="rounded-circle" style="width: 50px">
        <p><small>카카오스토리</small></p>
      </a>
    </li>
    <li class="list-inline-item text-center">
      <a href="" role="button" data-role="naver" target="_blank" class="muted-link">
        <img src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" class="rounded-circle" style="width: 50px">
        <p><small>네이버</small></p>
      </a>
    </li>
    <li class="list-inline-item text-center">
      <a href="" role="button" data-role="twitter" target="_blank" class="muted-link">
        <img src="<?php echo $g['img_core']?>/sns/twitter.png" alt="트위터" class="rounded-circle" style="width: 50px">
        <p><small>트위터</small></p>
      </a>
    </li>
  </ul>
  <div class="input-group input-group-sm mb-2" hidden>
    <input type="text" class="form-control" value="" readonly data-role="share" id="share-input">
    <div class="input-group-append">
      <button class="btn btn-light" type="button"
        data-plugin="clipboard"
        data-clipboard-target="#share-input"
        data-toggle="tooltip" title="클립보드 복사">
        <i class="fa fa-clipboard"></i>
      </button>
    </div>
  </div>
</div>

<!-- 레이아웃 위젯 찾아보기 -->
<div class="modal" tabindex="-1" role="dialog" id="modal-widget-selector">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">위젯 찾아보기 <span class="badge badge-secondary align-middle"><?php echo $d['layout']['dir'] ?></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="min-height: 400px">

        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label class="small text-muted">레이아웃 위젯목록</label>
              <select class="form-control custom-select" name="widget_selector" data-area="">
                <option>선택하세요.</option>
                <?php include $g['dir_layout'].'_var/_var.config.php'; ?>
                <?php $_i=1;foreach($d['layout']['widget'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
                <optgroup label="<?php echo $_val[0]?>">
                  <?php foreach($_val[1] as $_v):?>
                  <option value="<?php echo $_key ?>/<?php echo $_v[0]?>"><?php echo $_v[1]?></option>
                  <?php endforeach?>
                </optgroup>
                <?php $_i++;endforeach?>

              </select>
            </div><!-- /.form-group -->

            <div data-role="readme"></div>
          </div>
          <div class="col-8 text-center">
            <div data-role="none">
              <div class="d-flex justify-content-center align-items-center bg-light"  style="height:370px">
                <div class="text-muted">
                  <i class="fa fa-puzzle-piece" aria-hidden="true" style="color: #ccc;font-size: 100px"></i>
                  <p>위젯을 선택해주세요.</p>
                </div>
              </div>
            </div>
            <img src="" alt="" data-role="thumb" class="img-fluid d-none">
          </div>
        </div><!-- /.row -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary" data-act="submit">적용</button>
      </div>
    </div>
  </div>
</div>
