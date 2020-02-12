<div class="text-center">
  <img src="<?php echo getAvatarSrc($_MP['uid'],'230') ?>" width="230" height="230" alt="" class="rounded img-fluid">
</div>

<div class="vcard-names-container pt-3">
  <h1 class="vcard-names">
    <span class="p-name vcard-fullname d-block" itemprop="name">
      <?php echo $_MP['nic'] ?>
      <?php if($my['uid']==$_MP['uid']):?>
        <small class="text-muted">(나)</small>
      <?php endif; ?>
    </span>
    <span class="p-nickname vcard-username d-block">@<?php echo $mbrid ?></span>
  </h1>
</div>

<p class="mb-3 text-gray">
  <?php if ($_MP['bio']): ?>
  <?php echo $_MP['bio']?>
  <?php else: ?>
  <a href="<?php echo RW('mod=settings')?>?focus_bio=1">소개말 추가</a>
  <?php endif; ?>
</p>

<?php if($my['uid']):?>

  <?php if($my['uid']!=$_MP['uid']):?>
  <?php $_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$_MP['uid']); ?>
    <button class="btn btn-block btn-light<?php echo $_isFollowing ?' active':'' ?>"
      data-act="actionIframe"
      data-url="<?php echo $g['url_action']?>profile_follow&amp;mbruid=<?php echo $_MP['uid']?>"
      data-toggle="button">
      팔로우
    </button>
  <?php endif?>

<?php endif?>

<ul class="vcard-details border-top border-gray-light mt-3 pt-2 list-unstyled">

  <li aria-label="Email" class="vcard-detail pt-1 text-truncate">
    <?php if ($my['uid']): ?>
      <?php if ($_MP['email_profile']): ?>
        <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
        <a href="mailto:<?php echo $_MP['email_profile'] ?>" class="muted-link"><?php echo $_MP['email_profile'] ?></a>
      <?php endif; ?>
    <?php else: ?>
      <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> <a href="/login">로그인후 확인가능</a>
    <?php endif; ?>
  </li>

  <?php if ($_MP['home']): ?>
  <li aria-label="Blog or website" class="vcard-detail pt-1 text-truncate">
    <i class="fa fa-link fa-fw" aria-hidden="true"></i>
    <a href="<?php echo $_MP['home'] ?>" target="_blank" class="muted-link"><?php echo $_MP['home'] ?></a>
  </li>
  <?php endif; ?>
  <?php if ($_MP['company']): ?>
  <li aria-label="Blog or website" class="vcard-detail pt-1 text-truncate">
    <i class="fa fa-building-o fa-fw" aria-hidden="true"></i> <?php echo $_MP['company'] ?>
  </li>
  <?php endif; ?>
</ul>

<?php if ($my['uid']): ?>
<ul class="vcard-details  border-gray-light py-2 list-unstyled mb-0">
  <li class="pt-1 text-truncate">
    ㆍ나이/성별 : <?php if($_MP['birth1']):?><?php echo getAge($_MP['birth1'])?>세<?php else:?><span>미등록</span><?php endif?> (<?php if($_MP['sex']):?><?php echo $_MP['sex']==1?'남성':'여성'?><?php else:?><span>미등록</span><?php endif?>)
  </li>
  <li  class="pt-1 text-truncate">
    ㆍ분야 : <?php if($_MP['job']):?><?php echo $_MP['job']?><?php if($g['profile'][1]):?> <?php echo getAge($g['profile'][1])?>년차<?php endif?><?php else:?><span>미등록</span><?php endif?>
  </li>
  <li class="pt-1 text-truncate">
    ㆍ가입일자 : <?php echo getDateFormat($_MP['d_regis'],'Y.m.d')?>
  </li>
  <li class="pt-1 text-truncate">
    ㆍ<span class="cx">포인트</span> : <?php echo number_format($_MP['point'])?> P
  </li>
  <li class="pt-1 text-truncate">
    ㆍ<span class="cx">회원등급</span> : <?php echo $g['grade']['m'.$_MP['level']]?> <?php echo $_MP['level']?>
  </li>
</ul>
<?php endif; ?>
