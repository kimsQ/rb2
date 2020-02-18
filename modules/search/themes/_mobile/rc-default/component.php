<!-- 통합검색 -->
<div id="modal-search" class="modal fast" data-role="search">
	<header class="bar bar-nav px-0 bg-white">
    <a class="icon material-icons pull-left pl-3 pr-2 text-muted" role="button" data-history="back">arrow_back</a>
	  <form class="input-group">
	    <input type="search" name="keyword" class="form-control bg-faded" placeholder="검색어 입력" required autocomplete="off">
			<span class="input-group-btn hidden" data-role="keyword-reset" >
	      <button class="btn btn-link btn-nav" type="button" data-act="keyword-reset" tabindex="-1">
	        <i class="icon material-icons" aria-hidden="true">close</i>
	      </button>
	    </span>
	  </form>
	</header>
	<main class="content bg-white">

		<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list-list"></ul>

		<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list-post"></ul>

	</main>
</div><!-- /.modal -->

<script src="/modules/search/themes/_mobile/rc-default/component.js<?php echo $g['wcache']?>" ></script>
