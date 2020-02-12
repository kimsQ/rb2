<?php 
include_once $g['dir_module_skin'].'_menu.php';
$levelnum = getDbData($table['s_mbrlevel'],'gid=1','*');
$levelname= getDbData($table['s_mbrlevel'],'uid='.$M['level'],'*');
$sosokname= getDbData($table['s_mbrgroup'],'uid='.$M['sosok'],'*');
$joinsite = getDbData($table['s_site'],'uid='.$M['site'],'*');
$M1 = getUidData($table['s_mbrid'],$M['memberuid']);
$lastlogdate = -getRemainDate($M['last_log']);
?>


<div id="mypage_main">
	<div class="photo"><?php if($M['photo']):?><img src="<?php echo $g['url_root']?>/_var/simbol/<?php echo $M['photo']?>" alt="<?php echo $M['photo']?>" /><?php endif?></div>

	<table summary="<?php echo $M[$_HS['nametype']]?>님의 회원 요약정보입니다.">
	<caption>회원요약정보</caption> 
	<colgroup> 
	<col width="120"> 
	<col> 
	<col width="120"> 
	<col>
	</colgroup> 
	<thead>
	<tr>
	<th scope="col"></th>
	<th scope="col"></th>
	<th scope="col"></th>
	<th scope="col"></th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td class="key">이름</td>
	<td><?php echo $M['name']?></td>
	<td class="key">닉네임</td>
	<td><?php echo $M['nic']?></td>
	</tr>
	<tr>
	<td class="key">아이디</td>
	<td><?php echo $M1['id']?></td>
	<td class="key">가입일</td>
	<td><?php echo getDateFormat($M['d_regis'],'Y/m/d H:i')?></td>
	</tr>
	<tr>
	<td class="key">최근접속</td>
	<td><?php echo getDateFormat($M['last_log'],'Y/m/d H:i')?> (<?php echo $lastlogdate?$lastlogdate.'일전':'오늘'?>)</td>
	<td class="key">연락처</td>
	<td><?php echo $M['tel2']?$M['tel2']:$M['tel1']?></td>
	</tr>
	<tr>
	<td class="key">이메일</td>
	<td><?php echo $M['email']?></td>
	<td class="key">지역</td>
	<td><?php echo $M['addr0']=='해외'?$M['addr0']:$M['addr1']?></td>
	</tr>
	<tr>
	<td class="key">나이/성별</td>
	<td><?php if($M['birth1']):?><?php echo getAge($M['birth1'])?>세<?php endif?><?php if($M['birth1']&&$M['sex']):?> / <?php endif?><?php if($M['sex']):?><?php echo getSex($M['sex'])?>성<?php endif?></td>
	<td class="key">생년월일</td>
	<td><?php if($M['birth1']):?><?php echo $M['birth1']?>/<?php echo substr($M['birth2'],0,2)?>/<?php echo substr($M['birth2'],2,2)?><?php endif?></td>
	</tr>
	<tr>
	<td class="key">회원그룹</td>
	<td><?php echo $sosokname['name']?></td>
	<td class="key">회원등급</td>
	<td><?php echo $levelname['name']?> (<?php echo $M['level']?> / <?php echo $levelnum['uid']?>)</td>
	</tr>
	<tr>
	<td class="key">가입사이트</td>
	<td><?php echo $joinsite['name']?></td>
	<td class="key">포인트</td>
	<td>
		<?php echo number_format($M['point'])?> (사용 : <?php echo number_format($M['usepoint'])?>)
		(적립 : <?php echo number_format($M['cash'])?>)
		(예치 : <?php echo number_format($M['money'])?>)
	</td>
	</tr>
	<tr>
	<td class="key">SNS정보</td>
	<td colspan="3">
	
		<?php $SNS=explode('|',$M['sns'])?>
		<?php $SNSSET=array('트위터','페이스북','미투데이','요즘')?>
		<?php $SNSURL=array('twitter.com','facebook.com','me2day.net','yozm.daum.net')?>
		<?php for($i = 0; $i < 4; $i++):?>
		<?php $_snsuse=explode(',',$SNS)?>
		<?php if(!$_snsuse[1])continue?>
		<a href="<?php echo $_snsuse[1]?>" target="_blank">[<?php echo $SNSSET[$i]?>]</a>&nbsp;
		<?php endfor?>

	</td>
	</tr>
	</table>

	<div class="post">
	<h5>최근 게시물</h5>
	<ul>
	<?php $_POST = getDbArray($table['bbsdata'],'mbruid='.$M['memberuid'],'*','gid','asc',10,1)?>
	<?php while($_R=db_fetch_array($_POST)):?>
	<?php $_R['mobile']=isMobileConnect($_R['agent'])?>
	<li>
	ㆍ<a href="<?php echo getPostLink($_R)?>" target="_blank"><?php echo $_R['subject']?></a>
	<?php if($_R['mobile']):?><img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" class="imgpos1" alt="모바일" title="모바일(<?php echo $_R['mobile']?>)로 등록되었습니다." /><?php endif?>
	<?php if(strstr($_R['content'],'.jpg')):?><img src="<?php echo $g['img_core']?>/_public/ico_pic.gif" class="imgpos" alt="사진" title="사진" /><?php endif?>
	<?php if($_R['upload']):?><img src="<?php echo $g['img_core']?>/_public/ico_file.gif" class="imgpos" alt="첨부파일" title="첨부파일" /><?php endif?>
	<?php if($_R['hidden']):?><img src="<?php echo $g['img_core']?>/_public/ico_hidden.gif" class="imgpos" alt="비밀글" title="비밀글" /><?php endif?>
	<?php if($_R['comment']):?><span class="comment">[<?php echo $_R['comment']?><?php if($_R['oneline']):?>+<?php echo $_R['oneline']?><?php endif?>]</span><?php endif?>
	<?php if($_R['trackback']):?><span class="trackback">[<?php echo $_R['trackback']?>]</span><?php endif?>
	<?php if(getNew($_R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</li>
	<?php endwhile?>
	<?php if(!db_num_rows($_POST)):?>
	<li class="none">등록된 게시물이 없습니다.</li>
	<?php endif?>
	</ul>

	<h5>최근 댓글</h5>
	<ul>
	<?php $_POST = getDbArray($table['s_comment'],'mbruid='.$M['memberuid'],'*','uid','asc',10,1)?>
	<?php while($_R=db_fetch_array($_POST)):?>
	<?php $_R['mobile']=isMobileConnect($_R['agent'])?>
	<li>
	ㆍ<a href="<?php echo getCyncUrl($_R['cync'].',CMT:'.$_R['uid'].',s:'.$_R['site'])?>#CMT" target="_blank"><?php echo $_R['subject']?></a>
	<?php if($_R['mobile']):?><img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" class="imgpos1" alt="모바일" title="모바일(<?php echo $_R['mobile']?>)로 등록되었습니다." /><?php endif?>
	<?php if(strstr($_R['content'],'.jpg')):?><img src="<?php echo $g['img_core']?>/_public/ico_pic.gif" class="imgpos" alt="사진" title="사진" /><?php endif?>
	<?php if($_R['upload']):?><img src="<?php echo $g['img_core']?>/_public/ico_file.gif" class="imgpos" alt="첨부파일" title="첨부파일" /><?php endif?>
	<?php if($_R['hidden']):?><img src="<?php echo $g['img_core']?>/_public/ico_hidden.gif" class="imgpos" alt="비밀글" title="비밀글" /><?php endif?>
	<?php if($_R['oneline']):?><span class="comment">[<?php echo $_R['oneline']?>]</span><?php endif?>
	<?php if(getNew($_R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</li>
	<?php endwhile?>
	<?php if(!db_num_rows($_POST)):?>
	<li class="none">등록된 댓글이 없습니다.</li>
	<?php endif?>
	</ul>

	</div>

</div>



<script type="text/javascript">
//<![CDATA[

document.title = "<?php echo $M[$_HS['nametype']]?>님의 회원정보";
self.resizeTo(800,750);

//]]>
</script>

