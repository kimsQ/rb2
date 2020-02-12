<div class="container-fluid">
	<div id="bookmark" class="row">

		<div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar">

			<div class="card">
				<div class="card-header rb-icon">
					<i class="fa fa-star-o fa-lg fa-fw"></i> 북마크 관리
				</div>
				<div class="card-body p-2">
					<form action="<?php echo $g['s']?>/" method="post" class="rb-form">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="">
						<div class="dd" id="nestable-menu">
					        <ol class="dd-list">
								<?php $ADMPAGE = getDbArray($table['s_admpage'],'memberuid='.$my['uid'],'*','gid','asc',0,1)?>
								<?php $_i=1;while($R=db_fetch_array($ADMPAGE)):?>
					            <li class="dd-item dd3-item" data-id="<?php echo $_i?>">
					                <div class="dd-handle dd3-handle"></div>
					                <div class="dd3-content"><a href="<?php echo $R['url']?>"><?php echo $R['name']?></a></div>
					                <div class="dd-checkbox">
										<input type="checkbox" class="d-none" name="bookmark_pages_order[]" value="<?php echo $R['uid']?>" checked>
										<input type="checkbox" name="bookmark_pages[]" value="<?php echo $R['uid']?>"><i></i>
									</div>
					            </li>
								<?php $_i++;endwhile?>
								<?php if(!db_num_rows($ADMPAGE)):?>
								<li class="rb-none">
									등록된 북마크가 없습니다.
								</li>
								<?php endif?>
					        </ol>
						</div>
			        </form>
				</div>
				<div class="card-footer">

					<button type="button" class="btn btn-light"<?php if($_i==1):?> disabled<?php endif?> onclick="checkboxChoice('bookmark_pages[]',true);">
						전체선택
					</button>
					<button type="button" class="btn btn-light"<?php if($_i==1):?> disabled<?php endif?> onclick="checkboxChoice('bookmark_pages[]',false);">
						전체취소
					</button>

					<button type="button" class="btn btn-danger"<?php if($_i==1):?> disabled<?php endif?> onclick="actQue('bookmark_delete');">
						삭제
					</button>

				</div>
			</div>
		</div>

		<div class="col-sm-8 col-md-8 ml-sm-auto col-xl-9 pt-3">
			<h4>도움말</h4>
			<p class="text-">
				즐겨찾는 페이지를 상하로 드래그하면 실시간으로 순서가 변경됩니다.<br>
				삭제하려면 체크 후 삭제버튼을 클릭해 주세요.<br>
			</p>
		</div>
	</div>

</div>





<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js') ?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	var f = document.forms[0];
	getIframeForAction(f);
	f.a.value = 'bookmark_order';
	f.submit();
});
</script>


<!-- basic -->
<script>
function actQue(act)
{
	var f  = document.forms[0];
    var l = document.getElementsByName('bookmark_pages[]');
    var n = l.length;
    var i;
	var j=0;

	for (i=0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
		}
	}

	if (act == 'bookmark_delete')
	{
		if (j == 0)
		{
			alert('삭제할 북마크를 선택해 주세요.   ');
		}
		else
		{
			if (confirm('정말로 북마크에서 제외하시겠습니까?   '))
			{
				getIframeForAction(f);
				f.a.value = act;
				f.submit();
			}
		}
	}
}
</script>
