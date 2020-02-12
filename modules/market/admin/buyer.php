<?php
include $g['path_module'].$module.'/var/var.php';
if($d['market']['url']&&$d['market']['id']&&$d['market']['pw']):
include $g['path_core'].'function/rss.func.php';
$marketData = getUrlData($d['market']['url'].'&iframe=Y&page=client.buyer&_clientu='.$g['s'].'&_clientr='.$r.'&cat='.$cat.'&theme='.$theme.'&sort='.$sort.'&orderby='.$orderby.'&type='.$type.'&ptype='.$ptype.'&p='.$p.'&todayfree='.$todayfree.'&sailing='.$sailing.'&where='.$where.'&keyword='.$keyword.'&brand='.$brand.'&id='.$d['market']['id'].'&pw='.$d['market']['pw'].'&version=2',10);
$marketData = explode('[RESULT:',$marketData);
$marketData = explode(':RESULT]',$marketData[1]);
$marketData = $marketData[0];
echo $marketData;
else:?>
<div id="orderlist">

	<div class="info">

		<div class="article">
			0개(1/1페이지)
		</div>
		<div class="category">



		</div>
		<div class="clear"></div>
	</div>

	<table summary="상품주문 리스트입니다.">
	<caption>상품주문</caption>
	<colgroup>
	<col width="50">
	<col width="200">
	<col width="40">
	<col width="60">
	<col width="70">
	<col width="60">
	<col width="80">
	<col width="70">
	<col width="80">
	<col>
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">상품명</th>
	<th scope="col">버젼</th>
	<th scope="col">결제금액</th>
	<th scope="col">판매자</th>
	<th scope="col">결제방식</th>
	<th scope="col">주문일시</th>
	<th scope="col">입금일시</th>
	<th scope="col">다운/설치</th>
	<th scope="col" class="side2"></th>
	</tr>
	</thead>
	<tbody>
	</tbody>
	</table>
	<div class="sbj1">
	<span>환경설정 페이지에서 킴스큐 회원정보를 등록하지 않으셨습니다.</span>
	</div>

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,1,1,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

</div>

<?php endif?>
