

<nav class="nav flex-column nav-pills">
  <a class="nav-link filter-item d-flex justify-content-between align-items-center<?php echo !$module&&!$fromsys?' active':'' ?>"
    href="<?php echo $pageHome ?>">
    전체보기
    <span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_notice'],'mbruid='.$my['uid']))?></span>
  </a>
  <a class="nav-link filter-item d-flex justify-content-between align-items-center<?php echo $fromsys?' active':'' ?>"
    href="<?php echo $pageHome ?>?fromsys=Y">
    시스템 알림
    <span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_notice'],'mbruid='.$my['uid'].' and  frommbr=0'))?></span>
  </a>
</nav>
<hr>
<nav class="nav flex-column nav-pills">
  <?php $_MODULES=getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
  <?php while($_MD=db_fetch_array($_MODULES)):?>
  <a class="nav-link filter-item justify-content-between align-items-center <?php echo $module==$_MD['id']?' active ':'' ?><?php if(strstr($d['ntfc']['cut_modules'],'['.$_MD['id'].']')):?>d-none<?php else: ?>d-flex<?php endif?>"
      href="<?php echo $pageHome ?>?module=<?php echo $_MD['id']?>"  id="module_members_<?php echo $_MD['id']?>">
    <?php echo $_MD['name']?>
    <span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_notice'],'mbruid='.$my['uid'].' and  frommodule="'.$_MD['id'].'"'))?></span>
  </a>
  <?php endwhile?>
</nav>

<hr>

<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=multi_delete_user&amp;deltype=delete_all" class="btn btn-light btn-block" onclick="return hrefCheck(this,true,'정말로 전체 알림 삭제를 하시겠습니까?');">
  <i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>
  알림함 비우기
</a>

<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;mod=settings&amp;page=noti" class="btn btn-light btn-block">
  <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
  알림 설정
</a>
