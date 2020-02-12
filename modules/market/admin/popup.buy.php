<?php 
include $g['path_module'].$module.'/var/var.php';
if($d['market']['url']&&$d['market']['id']&&$d['market']['pw']):
include $g['path_core'].'function/rss.func.php';
$marketData = getUrlData($d['market']['url'].'&iframe=Y&page=client.buy&_clientu='.$g['s'].'&_clientr='.$r.'&uid='.$uid.'&iframe=Y&id='.$d['market']['id'].'&pw='.$d['market']['pw'],10);
$marketData = explode('[RESULT:',$marketData);
$marketData = explode(':RESULT]',$marketData[1]);
$marketData = $marketData[0];
?>

<?php if($marketData == 'NOMEMBER'):?>
<script type="text/javascript">
//<![CDATA[
alert('환경설정 페이지에 등록한 킴스큐 회원정보가 정확하지 않습니다.');
window.close();
//]]>
</script>
<?php exit;endif?>
<?php if($marketData == 'NOPRODUCT'):?>
<script type="text/javascript">
//<![CDATA[
alert('존재하지 않는 상품입니다.');
window.close();
//]]>
</script>
<?php exit;endif?>

<?php echo $marketData?>

<?php else:?>
<script type="text/javascript">
//<![CDATA[
alert('환경설정 페이지에서 마켓 접속주소와\n킴스큐 아이디/패스워드를 등록해 주세요.');
window.close();
//]]>
</script>
<?php endif?>

<script type="text/javascript">
//<![CDATA[
document.title = '큐마켓-구매하기';
//]]>
</script>