<!-- 동영상,유튜브,오디오 player : http://www.mediaelementjs.com/ -->
<?php getImport('mediaelement','mediaelement-and-player.min','4.2.8','js') ?>
<?php getImport('mediaelement','lang/ko','4.2.8','js') ?>
<?php getImport('mediaelement','mediaelementplayer','4.2.8','css') ?>

<!-- 사진전용모달 : photoswipe http://photoswipe.com/documentation/getting-started.html -->
<?php getImport('photoswipe','photoswipe','4.1.1','css') ?>
<?php getImport('photoswipe','default-skin/default-skin','4.1.1','css') ?>
<?php getImport('photoswipe','photoswipe.min','4.1.1','js') ?>
<?php getImport('photoswipe','photoswipe-ui-default.min','4.1.1','js') ?>

<?php
	 $img_files = array();
	 $audio_files = array();
	 $video_files = array();
	 $youtube_files = array();
	 $down_files = array();
	 foreach($d['upload']['data'] as $_u){
			if($_u['type']==2 and $_u['hidden']==0) array_push($img_files,$_u);
			else if($_u['type']==4 and $_u['hidden']==0) array_push($audio_files,$_u);
			else if($_u['type']==5 and $_u['hidden']==0) array_push($video_files,$_u);
			else if($_u['type']==1 || $_u['type']==6 || $_u['type']==7 and $_u['hidden']==0) array_push($down_files,$_u);
	 }
	 $attach_photo_num = count ($img_files);
	 $attach_video_num = count ($video_files);
	 $attach_audio_num = count ($audio_files);
	 $attach_down_num = count ($down_files);
?>

<?php if ($attach_photo_num==0): ?>

<div class="p-5 text-muted text-center border">
	표시할 사진이 없습니다.<br>
	이미지 숨김 처리여부를 확인해 주세요.
</div>

<?php endif; ?>

<?php if($attach_photo_num>0):?>
<h5>사진 <span class="text-danger"><?php echo $attach_photo_num?></span></h5>
<div class="list-inline mb-3 post-gallery" itemscope itemtype="http://schema.org/ImageGallery">
	<?php foreach($img_files as $_u):?>

	<?php
		$thumb_list=getPreviewResize($_u['src'],$d['theme']['view_thumb']); // 미리보기 사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
		$thumb_modal=getPreviewResize($_u['src'],$_u['width'].'x'.$_u['height']); // 정보수정 모달용  사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
	?>
		<figure class="list-inline-item">
			<a href="<?php echo $thumb_modal ?>"
				data-size="<?php echo $_u['width']?>x<?php echo $_u['height']?>"
				title="<?php echo $_u['name']?>">
        <img src="<?php echo $thumb_list ?>" alt="" class="border img-fluid">
      </a>
      <figcaption itemprop="caption description" hidden><?php echo $_u['caption']?></figcaption>
		</figure>
	<?php endforeach?>
</div>
<?php endif?>

<?php if($attach_down_num>0):?>
<div class="card">
	<div class="card-header">
		파일 (<span class="text-danger"><?php echo $attach_down_num ?></span>)
	</div>
	<ul class="list-group list-group-flush mb-0">
		<?php foreach($down_files as $_u):?>
			<?php
				 $ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
				 $ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
			 ?>
			 <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="">
            <i class="fa fa-file<?php echo $ext_icon?>-o fa-lg fa-fw"></i>
            <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=mediaset&amp;a=download&amp;uid=<?php echo $_u['uid']?>" title="<?php echo $_u['caption']?>">
                <?php echo $_u['name']?>
            </a>
            <small class="text-muted">(<?php echo getSizeFormat($_u['size'],1)?>)</small>
            <span title="다운로드 수" data-toggle="tooltip" class="badge badge-light"><?php echo number_format($_u['down'])?></span>
          </div>
			 </li>
		<?php endforeach?>
	</ul>
</div><!-- /.card -->
<?php endif?>



<?php if($attach_video_num>0):?>
  <h5 class="mt-5">비디오 <span class="text-danger"><?php echo $attach_video_num?></span></h5>
  <?php foreach($video_files as $_u):?>
  <?php
     $ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
     $ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
   ?>
  <div class="card">
    <video width="320" height="240" controls class="card-img-top mejs-player">
      <source src="<?php echo $_u['url']?><?php echo $_u['folder']?>/<?php echo $_u['tmpname']?>" type="video/<?php echo $_u['ext']?>">
    </video>
    <div class="card-body">
      <h6 class="card-title"><?php echo $_u['name']?></h6>
      <p class="card-text"><small class="text-muted">(<?php echo getSizeFormat($_u['size'],1)?>)</small></p>
    </div><!-- /.card-block -->
  </div><!-- /.card -->
  <?php endforeach?>
<?php endif?>


<?php if($attach_audio_num>0):?>
  <h5 class="mt-5">오디오 <span class="text-danger"><?php echo $attach_audio_num?></span></h5>
  <?php foreach($audio_files as $_u):?>
  <?php
    $ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
    $ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
   ?>
  <div class="card">
    <audio controls class="card-img-top mejs-player w-100">
      <source src="<?php echo $_u['url']?><?php echo $_u['folder']?>/<?php echo $_u['tmpname']?>" type="audio/<?php echo $_u['ext']?>">
    </audio>
    <div class="card-body">
      <h6 class="card-title"><?php echo $_u['name']?></h6>
      <p class="card-text"><small class="text-muted">(<?php echo getSizeFormat($_u['size'],1)?>)</small></p>
    </div><!-- /.card-block -->
  </div><!-- /.card -->
  <?php endforeach?>

<?php endif?>

<!-- 일반 포토모달 -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

  <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
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

        <div class="pswp__counter"></div>

        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

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


<script>
var initPhotoSwipeFromDOM = function(gallerySelector) {

	var subject= '<?php echo $R['subject']?>'
	var orgin_title = document.title
	var modal = $('.pswp')

  // parse slide data (url, title, size ...) from DOM elements
  // (children of gallerySelector)
  var parseThumbnailElements = function(el) {
    var thumbElements = el.childNodes,
      numNodes = thumbElements.length,
      items = [],
      figureEl,
      linkEl,
      size,
      item;

    for (var i = 0; i < numNodes; i++) {

      figureEl = thumbElements[i]; // <figure> element

      // include only element nodes
      if (figureEl.nodeType !== 1) {
        continue;
      }

      linkEl = figureEl.children[0]; // <a> element

      size = linkEl.getAttribute('data-size').split('x');

      // create slide object
      item = {
        src: linkEl.getAttribute('href'),
        w: parseInt(size[0], 10),
        h: parseInt(size[1], 10)
      };



      if (figureEl.children.length > 1) {
        // <figcaption> content
        item.title = figureEl.children[1].innerHTML;
      }

      if (linkEl.children.length > 0) {
        // <img> thumbnail element, retrieving thumbnail url
        item.msrc = linkEl.children[0].getAttribute('src');
      }

      item.el = figureEl; // save link to element for getThumbBoundsFn
      items.push(item);
    }

    return items;
  };

  // find nearest parent element
  var closest = function closest(el, fn) {
    return el && (fn(el) ? el : closest(el.parentNode, fn));
  };

  // triggers when user clicks on thumbnail
  var onThumbnailsClick = function(e) {
    e = e || window.event;
    e.preventDefault ? e.preventDefault() : e.returnValue = false;

    var eTarget = e.target || e.srcElement;

    // find root element of slide
    var clickedListItem = closest(eTarget, function(el) {
      return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
    });

    if (!clickedListItem) {
      return;
    }

    // find index of clicked item by looping through all child nodes
    // alternatively, you may define index via data- attribute
    var clickedGallery = clickedListItem.parentNode,
      childNodes = clickedListItem.parentNode.childNodes,
      numChildNodes = childNodes.length,
      nodeIndex = 0,
      index;

    for (var i = 0; i < numChildNodes; i++) {
      if (childNodes[i].nodeType !== 1) {
        continue;
      }

      if (childNodes[i] === clickedListItem) {
        index = nodeIndex;
        break;
      }
      nodeIndex++;
    }



    if (index >= 0) {
      // open PhotoSwipe if valid index found
      openPhotoSwipe(index, clickedGallery);
    }
    return false;
  };

  // parse picture index and gallery index from URL (#&pid=1&gid=2)
  var photoswipeParseHash = function() {
    var hash = window.location.hash.substring(1),
      params = {};

    if (hash.length < 5) {
      return params;
    }

    var vars = hash.split('&');
    for (var i = 0; i < vars.length; i++) {
      if (!vars[i]) {
        continue;
      }
      var pair = vars[i].split('=');
      if (pair.length < 2) {
        continue;
      }
      params[pair[0]] = pair[1];
    }

    if (params.gid) {
      params.gid = parseInt(params.gid, 10);
    }

    return params;
  };

  var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
    var pswpElement = document.querySelectorAll('.pswp')[0],
      gallery,
      options,
      items;

    items = parseThumbnailElements(galleryElement);

    // define options (if needed)
    options = {

      history: true,
      focus: false,
      closeOnScroll: false,
      closeOnVerticalDrag: false,
      showAnimationDuration: 0,
      hideAnimationDuration: 0,
      timeToIdle: 4000,

      // define gallery index (for URL)
      galleryUID: galleryElement.getAttribute('data-pswp-uid'),

      getThumbBoundsFn: function(index) {
        // See Options -> getThumbBoundsFn section of documentation for more info
        var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
          pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
          rect = thumbnail.getBoundingClientRect();

        return {
          x: rect.left,
          y: rect.top + pageYScroll,
          w: rect.width
        };
      }

    };

    // PhotoSwipe opened from URL
    if (fromURL) {
      if (options.galleryPIDs) {
        // parse real index when custom PIDs are used
        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
        for (var j = 0; j < items.length; j++) {
          if (items[j].pid == index) {
            options.index = j;
            break;
          }
        }
      } else {
        // in URL indexes start from 1
        options.index = parseInt(index, 10) - 1;
      }
    } else {
      options.index = parseInt(index, 10);
    }

    // exit if index not found
    if (isNaN(options.index)) {
      return;
    }

    if (disableAnimation) {
      options.showAnimationDuration = 0;
    }

    // Pass data to PhotoSwipe and initialize it
    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();

		//갤러리가 실행된 후에
		gallery.listen('imageLoadComplete', function(index, item) {
			var counter =  '('+modal.find('.pswp__counter').text().replace(/ /g, '')+') ';
			document.title = counter+subject+'-'+orgin_title  // 브라우저 타이틀 재설정
			$('body').addClass('modal-open')  // 페이지 스크롤바 원상복귀를 위해
		});

		//슬라이드 갱신 후에
		gallery.listen('afterChange', function() {
			var counter =  '('+modal.find('.pswp__counter').text().replace(/ /g, '')+') ';
			document.title = counter+subject+'-'+orgin_title  // 브라우저 타이틀 재설정
		});

		// 갤러리가 닫힐때
		gallery.listen('close', function() {
			$('body').removeClass('modal-open')  // 페이지 스크롤바 원상복귀를 위해
		});


  };

  // loop through all gallery elements and bind events
  var galleryElements = document.querySelectorAll(gallerySelector);

  for (var i = 0, l = galleryElements.length; i < l; i++) {
    galleryElements[i].setAttribute('data-pswp-uid', i + 1);
    galleryElements[i].onclick = onThumbnailsClick;
  }

  // Parse URL and open gallery if it contains #&pid=3&gid=1
  var hashData = photoswipeParseHash();
  if (hashData.pid && hashData.gid) {
    openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
  }


};


$(function () {

	// execute above function
	initPhotoSwipeFromDOM('.post-gallery');


  $('.mejs-player').mediaelementplayer(); // 동영상, 오디오 플레이어 초기화 http://www.mediaelementjs.com/

	$('.post-gallery figure a').click(function(){
		$(this).closest('figure').attr('tabindex','-1').focus();
	});

})
</script>
