<?php
$vtype	= $vtype ? $vtype : 'point';
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 10;

$sqlque = 'my_mbruid='.$my['uid'];
if ($type == '1') $sqlque .= ' and price > 0';
if ($type == '2') $sqlque .= ' and price < 0';
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_'.$vtype],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_'.$vtype],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$PageLink = './point?';
if ($type) $PageLink .= 'type='.$type.'&amp;';

?>


<header class="bar bar-nav bar-dark bg-primary px-0">
	<a class="icon icon-left-nav pull-left p-x-1" role="button" href="<?php echo RW('mod=settings') ?>"></a>
	<h1 class="title" data-location="reload">
		<i class="fa fa-envelope-o mr-1 fa-fw text-muted" aria-hidden="true"></i> 이메일 관리
	</h1>
</header>

<?php if ($TPG > 1): ?>
<footer class="bar bar-standard bar-footer bar-light bg-white p-x-0">
	<div class="">
		<?php echo getPageLink($d['theme']['pagenum'],$p,$TPG,'')?>
	</div>
</footer>
<?php endif; ?>

<main class="content bg-faded animated fadeIn delay-1">

	<ul class="table-view bg-white" style="margin-top: -.0625rem">
		<?php while($R=db_fetch_array($RCD)):?>
	  <li class="table-view-cell">
	    <?php echo $R['content']?>
			<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">new</small><?php endif?>
			<p><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></p>
	    <span class="badge badge-primary badge-outline"><?php echo ($R['price']>0?'+':'').number_format($R['price'])?></span>
	  </li>
		<?php endwhile?>

		<?php if(!$NUM):?>
			<li class="table-view-cell text-xs-center p-5 text-muted d-flex align-items-center justify-content-center bg-faded" style="height: calc(100vh - 10.5rem);">
				내역이 없습니다.
		  </li>
		<?php endif?>
	</ul>

</main>


<script>

$(function() {

});

</script>
