<?php
$LIST=getDbData($table['postlist'],"id='".$wdgvar['id']."'",'*');
?>

<style>
.ad_section {
  padding: 2rem 0;
  border-top: .0625rem solid #e4e6e7;
  border-bottom:.0625rem solid #e4e6e7;
  background-size: cover;
  position: relative;
  color: #fff;
}
.ad_section::before {
  position: absolute;
  content: ' ';
  left:0;
  right:0;
  top:0;
  bottom:0;
  background-color: rgba(0, 0, 0, 0.5);
}
</style>

<div class="ad_section border-top border-bottom bg-faded py-4" style="background-image: url(<?php echo getListImageSrc($LIST['uid']) ?>);">
  <div class="text-xs-center text-white">
    <div class="position-relative">

      <p class="text-white"><?php echo $LIST['review'] ?></p>
      <a  href="#page-post-listview"
        data-start="#page-main"
        data-toggle="page"
        data-title="<?php echo $LIST['name'] ?>"
        data-url="/list/<?php echo $wdgvar['id'] ?>"
        data-id="<?php echo $wdgvar['id'] ?>"
        class="btn btn-outline-secondary">
        자세히 보기
      </a>
    </div>

  </div>
</div>
