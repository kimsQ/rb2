<div data-role="loader">
  <div class="d-flex justify-content-center align-items-center text-muted" style="height:90vh">
    <div class="spinner-border" role="status"></div>
  </div>
</div>

<div class="d-flex justify-content-center align-items-center text-muted" style="height:90vh">
  <div class="">

    <div class="content-padded">
      <ul class="media-list">
        <li class="media mb-2" data-role="item" data-landing="true"
            data-target="#modal-post-view" id ="veiw-<?php echo $R['cid'] ?>"
            data-toggle="modal"
            data-format="<?php echo $R['format'] ?>"
            data-uid="<?php echo $R['uid'] ?>"
            data-featured="<?php echo getPreviewResize(getUpImageSrc($R),'640x360'); ?>"
            data-provider="<?php echo getFeaturedimgMeta($R,'provider') ?>"
            data-videoid="<?php echo getFeaturedimgMeta($R,'provider')=='YouTube'?getFeaturedimgMeta($R,'name'):'' ?>"
            data-url="/post/<?php echo $R['cid'] ?>?ref=<?php echo $ref ?>">  
          <div class="media-left">
            <div class="embed-responsive embed-responsive-16by9 bg-faded">
              <img class="media-object" src="<?php echo getPreviewResize(getUpImageSrc($R),'320x180'); ?>" alt="" data-role="featured" style="width:160px">
              <time class="badge badge-default bg-black rounded-0 position-absolute f12 p-1" style="right:2px;bottom:2px" data-role="time">13:17</time>
            </div>
          </div>
          <div class="media-body pt-1">
            <h4 class="media-heading f15 line-clamp-3"><?php echo stripslashes($R['subject']) ?></h4>
            <ul class="list-inline f13 text-muted mt-1 mb-0">
              <li class="list-inline-item"><?php echo $M1[$_HS['nametype']] ?></li>
              <li class="list-inline-item">조회수 <?php echo number_format($R['hit'])?>회 </li>
              <li class="list-inline-item">댓글 <?php echo number_format($R['comment'])?> </li>
            </ul>
          </div>
        </li>
      </ul>

      <button type="button" data-href="/" data-text="홈으로 이동" class="btn btn-secondary btn-block">
        홈으로 이동
      </button>
    </div>

  </div>
</div>


<script>

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

$( document ).ready(function() {

  $('[data-role="loader"]').addClass('d-none');
  $('#veiw-<?php echo $R['cid'] ?>').click();

});

</script>
