<?php
/**************************************************************
아래의 변수를 이용합니다.
$_iscallpage			통합검색 이거나 더보기일경우 true 아니면 false
$where					검색위치
$keyword				검색키워드
$orderby				(desc 최신순 / asc 오래된순)
$d['search']['num1']	전체검색 출력수
$d['search']['num2']	전용검색 한 페이당 출력수
$d['search']['term']	검색기간(월단위)

검색결과 DIV id 정의방법 : <div id="rb-search-모듈id-검색파일명"> ... </div>
***************************************************************
검색결과 추출 예제 ::

$sqlque	= ''; // 검색용 SQL 초기화
if ($keyword)
{
	$sqlque .= getSearchSql('검색필드',$keyword,'','or');	 //검색필드 설정방법 : 1개의 필드 -> 필드명 , 복수의 필드 -> 필드명을 |(파이프) 로 구분
}

// 더보기 검색일 경우에만 실행함
if ($swhere == $_key)
{
	$sort = 'uid'; // 기본 정렬필드
	$RCD = getDbArray($table['테이블명'],$sqlque,'*',$sort,$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);
	while($_R = db_fetch_array($RCD))
	{
		echo $_R['필드네임'];
	}
}
$_ResultArray['num'][$_key] = getDbRows($table['테이블명'],$sqlque); // 검색어에 해당되는 결과갯수 <- 무조건 실행해야 됨
**************************************************************
아래의 예제는 실제로 페이지를 검색하는 샘플입니다.
페이징,더보기,검색결과 없을경우 안내등은 모두 자동으로 처리되니 결과 리스트만 출력해 주시면 됩니다.
최초 설치시 "이용약관" 이나 "개인정보" 로 검색하시면 결과값을 얻으실 수 있습니다.
**************************************************************/
?>

<?php
$sqlque	= 'uid';
$sqlque .= getSearchSql('subject|content|tag',$keyword,'','or'); // 게시물 제목과 내용 검색
$orderby = 'desc';

if($_iscallpage):
$RCD = getDbArray($table['bbsdata'],$sqlque,'*','uid',$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);

include_once $g['path_module'].'bbs/var/var.php';
$g['url_module_skin'] = $g['s'].'/modules/bbs/themes/'.$d['bbs']['skin_mobile'];
$g['dir_module_skin'] = $g['path_module'].'bbs/themes/'.$d['bbs']['skin_mobile'].'/';
include_once $g['dir_module_skin'].'_widget.php';
?>


<ul class="table-view table-view-full mb-0 bg-white" data-role="bbs-list">
	<?php while($_R=db_fetch_array($RCD)):?>
	<?php $B = getUidData($table['bbslist'],$_R['bbs']); ?>
		<li class="table-view-cell media" id="item-<?php echo $_R['uid'] ?>">
	    <a class=""
				href="#modal-bbs-view" data-toggle="modal"
				data-bid="<?php echo $B['id'] ?>"
	      data-uid="<?php echo $_R['uid'] ?>"
	      data-url="<?php echo getBbsPostLink($_R)?>"
	      data-cat="<?php echo $_R['category'] ?>"
	      data-title="<?php echo $B['name'] ?>"
	      data-subject="<?php echo $_R['subject'] ?>">

				<?php if (getUpImageSrc($_R)): ?>
	      <img class="media-object pull-left border" src="<?php echo getPreviewResize(getUpImageSrc($_R),'q') ?>" width="64" height="64">
				<?php endif; ?>

	      <div class="media-body">
					<div class="">
						<span class="badge badge-pill badge-light"><?php echo $B['name'] ?></span>
						<time class="text-muted small ml-2" data-plugin="timeago" datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>">
							<?php echo getDateFormat($_R['d_regis'],'Y.m.d')?>
						</time>
						<?php if(getNew($_R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>
					</div>
	        <?php echo $_R['subject']?>
	        <p class="small">


						<span class="badge badge-default badge-inverted">
							<i class="fa fa-heart-o mr-1" aria-hidden="true"></i>
							<?php echo $_R['likes']?>
						</span>

						<span class="badge badge-default badge-inverted ml-1">
							<i class="fa fa-eye mr-1" aria-hidden="true"></i>
							<?php echo $_R['hit']?>
						</span>

						 <span class="badge badge-default badge-inverted ml-1">
							 <i class="fa fa-comment-o mr-1" aria-hidden="true"></i>
							 <?php echo $_R['comment']?>
						 </span>

							<span class="badge badge-default badge-inverted ml-1">
								<?php echo $_R[$_HS['nametype']]?>
							</span>

							<span class="badge badge-default badge-inverted ml-1">
								<i class="fa fa-tag" aria-hidden="true"></i>
								<?php echo $_R['tag']?>
							</span>

					</p>
	      </div>
	    </a>
	  </li>

	<?php endwhile?>
</ul>


<?php
endif;
$_ResultArray['num'][$_key] = getDbRows($table['bbsdata'],$sqlque);
?>
