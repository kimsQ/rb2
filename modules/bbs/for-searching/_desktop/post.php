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
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
$sqlque .= getSearchSql('subject|tag',$q,'','or'); // 게시물 제목과 태그 검색
$orderby = 'desc';

if($_iscallpage):
$RCD = getDbArray($table['bbsdata'],$sqlque,'*','uid',$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);

include_once $g['path_module'].'bbs/var/var.php';

$g['url_module_skin'] = $g['s'].'/modules/bbs/themes/'.$d['bbs']['skin_main'];
$g['dir_module_skin'] = $g['path_module'].'bbs/themes/'.$d['bbs']['skin_main'].'/';
include_once $g['dir_module_skin'].'_widget.php';

?>
<article>
	<ul class="list-group list-group-flush mb-0" data-role="bbs-list">
		<?php while($_R=db_fetch_array($RCD)):?>
		<?php $B = getUidData($table['bbslist'],$_R['bbs']); ?>
		<li class="list-group-item d-flex justify-content-between align-items-center" id="item-<?php echo $_R['uid'] ?>">

			<div class="media">
				<?php if (getUpImageSrc($_R)): ?>
				<a class="mr-3" href="<?php echo getBbsPostLink($_R)?>" >
					<img class="border" src="<?php echo getPreviewResize(getUpImageSrc($_R),'s') ?>" alt=""  width="64" height="64">
				</a>
				<?php endif; ?>
			  <div class="media-body">
			    <strong class="d-block mb-1">

						<?php if($_R['category']):?>
            <span class="badge badge-light"><?php echo $_R['category']?></span>
            <?php endif?>

						<a class="muted-link" href="<?php echo getBbsPostLink($_R)?>">
							<?php echo $_R['subject']?>
							<?php if($_R['upload']):?>
							<span class="badge badge-light" title="첨부파일">
								<i class="fa fa-paperclip fa-lg"></i>
							</span>
							<?php endif?>
							<?php if(getNew($_R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>
						</a>
					</strong>
					<p class="small text-muted mb-2">
						<?php echo getStrCut(str_replace('&nbsp;',' ',strip_tags($_R['content'])),60,'..')?>
					</p>
					<ul class="list-inline text-muted mb-0 small">
						<li class="list-inline-item">
							<span class="badge badge-pill badge-light"><?php echo $B['name'] ?></span>
						</li>
						<li class="list-inline-item">
							<time class="text-muted small" data-plugin="timeago" datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>">
								<?php echo getDateFormat($_R['d_regis'],'Y.m.d')?>
							</time>
						</li>
						<li class="list-inline-item">
							<i class="fa fa-heart-o" aria-hidden="true"></i>
							 <?php echo $_R['likes']?>
						</li>
						<li class="list-inline-item">
              <i class="fa fa-eye" aria-hidden="true"></i>
              <?php echo $_R['hit']?>
            </li>
						<li class="list-inline-item">
							<i class="fa fa-comment-o" aria-hidden="true"></i>
							<?php echo $_R['comment']?>
						</li>
						<li class="list-inline-item">
							<?php echo $_R[$_HS['nametype']]?>
						</li>
						<li class="list-inline-item">
							<i class="fa fa-tag" aria-hidden="true"></i>
							<?php echo $_R['tag']?>
						</li>
					</ul>

			  </div>
			</div>

			</li>
		<?php endwhile?>
	</ul>
</article>

<?php
endif;
$_ResultArray['num'][$_key] = getDbRows($table['bbsdata'],$sqlque);
?>
