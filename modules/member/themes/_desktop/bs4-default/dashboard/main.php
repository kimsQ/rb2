<div class="p-3">
  <div class="row">
    <div class="col-6">

      <section>
        <?php include $g['dir_module_skin'].'_recentPost.php';?>
      </section>

      <section class="mt-4">
        <?php include $g['dir_module_skin'].'_recentList.php';?>
      </section>

    </div>
    <div class="col-6">

      <section>
        <header class="d-flex justify-content-between align-items-center py-2">
          <strong>포스트 현황</strong>
        </header>

        <ul class="list-group list-group-horizontal text-center text-muted shadow-sm">
          <li class="list-group-item flex-fill">
            <small>포스트</small>
            <a href="<?php echo RW('mod=dashboard&page=post')?>" class="d-block h2 my-2 text-reset text-decoration-none">
              <?php echo number_format($my['num_post']) ?>
            </a>
          </li>
          <li class="list-group-item flex-fill">
            <small>구독자</small>
            <a href="<?php echo RW('mod=dashboard&page=follower')?>" class="d-block h2 my-2 text-reset text-decoration-none">
              <?php echo number_format($my['num_follower']) ?>
            </a>
          </li>
          <li class="list-group-item flex-fill">
            <small>누적 조회수</small>
            <span class="d-block h2 my-2">
              <?php echo number_format($my['hit_post']) ?>
            </span>
          </li>
          <li class="list-group-item flex-fill">
            <small>누적 좋아요</small>
            <span class="d-block h2 my-2">
              <?php echo number_format($my['likes_post']) ?>
            </span>
          </li>
          <li class="list-group-item flex-fill">
            <small>누적 싫어요</small>
            <span class="d-block h2 my-2">
              <?php echo number_format($my['dislikes_post']) ?>
            </span>
          </li>
        </ul>
      </section>

      <section class="mt-3">
        <?php include $g['dir_module_skin'].'_chart.php';?>
      </section>

      <section class="mt-3">
        <?php include $g['dir_module_skin'].'_best.php';?>
      </section>

    </div>
  </div><!-- /.row -->

</div>

<?php include $g['path_module'].'post/mod/_component.desktop.php';?>
