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
$sqlque .= getSearchSql('name|alt|caption',$q,'','or'); // 파일명과 캡션 검색

if($_iscallpage):
$RCD = getDbArray($table['s_upload'],$sqlque,'*','uid',$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);
?>


<div class="" itemscope itemtype="http://schema.org/ImageGallery"  id="rb-search-photo">
	<?php while($_R=db_fetch_array($RCD)):?>

	<figure class="mr-3" data-plugin="photoswipe" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
		<a href="<?php echo $_R['src'] ?>" itemprop="contentUrl" data-size="<?php echo $_R['width'] ? $_R['width'] : 200; ?>x<?php echo $_R['height'] ? $_R['height'] : 200; ?>" data-author="뉴스">
			<img src="<?php echo getPreviewResize($_R['src'],'150x100')?>" alt="<?php echo $_R['caption'] ?>" itemprop="thumbnail">
		</a>
		<figcaption itemprop="caption description" class="mt-2 d-none"><?php echo $_R['caption'] ?></figcaption>
	</figure>
	<?php endwhile?>
</div>


<?php
endif;
$_ResultArray['num'][$_key] = getDbRows($table['s_upload'],$sqlque);
?>
