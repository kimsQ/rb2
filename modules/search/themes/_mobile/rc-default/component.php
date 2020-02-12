<!-- 통합검색 -->
<div id="modal-search" class="modal fast" data-role="search">
	<header class="bar bar-nav py-1 px-0 bg-white shadow-sm">
    <a class="icon material-icons pull-left px-3 text-muted" role="button" data-history="back">arrow_back</a>
	  <form class="input-group input-group-lg bg-white">
	    <input type="search" name="keyword" class="form-control pl-0" placeholder="검색어 입력" id="search-input" required autocomplete="off">
			<span class="input-group-btn hidden" data-role="keyword-reset" >
	      <button class="btn btn-link pr-3" type="button" data-act="keyword-reset" tabindex="-1">
	        <i class="fa fa-times-circle" aria-hidden="true"></i>
	      </button>
	    </span>
	  </form>
	</header>
	<main class="content bg-faded">

		<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list-list"></ul>

		<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list-post"></ul>

	</main>
</div><!-- /.modal -->

<script src="/modules/search/themes/_mobile/rc-default/component.js<?php echo $g['wcache']?>" ></script>
