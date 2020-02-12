<?php
$sqlque	= 'memberuid';
$sqlque .= getSearchSql('nic|name',$keyword,'','or'); // 닉네임 및 이름 검색
$orderby = 'desc';

if($_iscallpage):
$RCD = getDbArray($table['s_mbrdata'],$sqlque,'*','memberuid',$orderby,$d['search']['num'.($type=='all'?1:2)],$p);
?>
<div id="people">
	<ol class="mb-0">
		<?php while($_R=db_fetch_array($RCD)):?>
		<?php $_MH = getDbData($table['s_mbrid'],"uid='".$_R['memberuid']."'",'*'); ?>
		<li><a href="/<?php echo $_MH['id'] ?>"><?php echo $_R['nic']?>/<?php echo $_MH['id']?></a></li>
		<?php endwhile?>
	</ol>
</div>

<?php
endif;
$_ResultArray['num'][$_key] = getDbRows($table['s_mbrdata'],$sqlque);
?>
