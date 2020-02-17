<?php
$query = 'site='.$s.' and ';
$_WHERE1= $query.'date >= '.date('Ymd', strtotime($wdgvar['term']));
$_WHERE2= 'keyword,sum(hit) as hit';
$RCD	= getDbSelect($table['s_tag'],$_WHERE1.' group by keyword order by hit desc limit 0,10',$_WHERE2);
?>

<section class="widget bg-white border-bottom">
  <header class="border-bottom border-bottom-light">
    <h3><?php echo $wdgvar['title'] ?></h3>
    <small class="ml-2 text-muted f13">
      <?php echo date('m/d', strtotime($wdgvar['term'])).'~'. date('m/d', strtotime('now'))?>
    </small>
  </header>
  <main class="px-2">
    <div class="row">
      <div class="col-xs-6">
        <ul class="list-unstyled ml-1 my-2">
          <?php $j=0;while($G=db_fetch_array($RCD)):$j++?>
          <li>
            <button type="button" class="btn btn-link text-reset btn-block text-left py-2 line-clamp-1"
              data-toggle="page"
              data-target="#page-post-keyword"
              data-start="#page-main"
              data-title="#<?php echo $G['keyword']?> 검색결과"
              data-url="/post/search?keyword=<?php echo $G['keyword']?>"
              data-keyword="<?php echo $G['keyword']?>">
              <strong class="text-primary mx-2"><?php echo $j?></strong>
              <?php echo getStrCut($G['keyword'],10,'..')?>
            </button>
          </li>
          <?php if ($j==5): ?>
          </ul></div><div class="col-xs-6 pl-0"><ul class="list-unstyled my-2">
          <?php endif; ?>
          <?php endwhile?>
        </ul>
      </div>
    </div><!-- /.row -->
  </main>
</section>
