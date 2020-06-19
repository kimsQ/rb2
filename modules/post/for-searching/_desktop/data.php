<?php
/**************************************************************
아래의 변수를 이용합니다.
$_iscallpage			통합검색 이거나 더보기일경우 true 아니면 false
$where					검색위치
$q				검색키워드
$orderby				(desc 최신순 / asc 오래된순)
$d['search']['num1']	전체검색 출력수
$d['search']['num2']	전용검색 한 페이당 출력수
$d['search']['term']	검색기간(월단위)

검색결과 DIV id 정의방법 : <div id="rb-search-모듈id-검색파일명"> ... </div>
***************************************************************
검색결과 추출 예제 ::

$sqlque	= ''; // 검색용 SQL 초기화
if ($q)
{
	$sqlque .= getSearchSql('검색필드',$q,'','or');	 //검색필드 설정방법 : 1개의 필드 -> 필드명 , 복수의 필드 -> 필드명을 |(파이프) 로 구분
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
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
$sqlque .= getSearchSql('subject|review|tag',$q,'','or'); // 게시물 제목과 내용 검색
$orderby = $orderby?$orderby:'desc';

if ($my['uid']) $sqlque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $sqlque .= ' and display = 5'; // 전체공개 포스트만 출력

if($_iscallpage):
$RCD = getDbArray($table['postdata'],$sqlque,'*','uid',$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);

include_once $g['path_module'].'post/var/var.php';

$g['url_module_skin'] = $g['s'].'/modules/post/themes/'.$d['post']['skin_main'];
$g['dir_module_skin'] = $g['path_module'].'post/themes/'.$d['post']['skin_main'].'/';
include_once $g['dir_module_skin'].'_widget.php';

?>
<article>
	<ul class="list-unstyled" data-role="post-list">
		<?php while($_R=db_fetch_array($RCD)):?>
		<li class="media my-3">

			<?php if ($_R['featured_img']): ?>
			<a href="<?php echo getPostLink($_R,0) ?>" class="position-relative mr-3" target="_blank">
				<img src="<?php echo checkPostPerm($_R) ?getPreviewResize(getUpImageSrc($_R),'140x78'):getPreviewResize('/files/noimage.png','140x78') ?>" alt="">
				<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($_R)?getUpImageTime($_R):'' ?></time>
			</a>
			<?php endif; ?>

			<div class="media-body">
				<h5>
					<a class="link_title" href="<?php echo getPostLink($_R,0) ?>" target="_blank">
						<?php echo getStrCut(stripslashes($_R['subject']),40,'..')?>
					</a>
					<time data-plugin="timeago" class="ml-2" datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>"></time>
				</h5>


				<p class="text-muted my-2"><?php echo $_R['review']?></p>
				<div class="mb-1">
					<span class="text-muted">
						<!-- 태그 -->
						<?php $_tags=explode(',',$_R['tag'])?>
						<?php $_tagn=count($_tags)?>
						<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
						<?php $_tagk=trim($_tags[$i])?>
						<a class="badge badge-light" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>"><?php echo $_tagk?></a>
						<?php endfor?>
					</span>
					<span class="badge badge-light"><?php echo checkPostOwner($_R) && $_R['display']!=5?$g['displaySet']['label'][$_R['display']]:'' ?></span>
				</div>
			</div>

		</li>
		<?php endwhile?>
	</ul>
</article>

<?php
endif;
$_ResultArray['num'][$_key] = getDbRows($table['postdata'],$sqlque);
?>
