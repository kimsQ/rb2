<ul class="rb-site-list list-inline">
<?php $_SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1)?>
<?php while($_R = db_fetch_array($_SITES)):?>

<li>
	<div class="rb-box">
		<a href="<?php echo $g['s']?>/?r=<?php echo $_R['id']?>" target="_blank">
			<i class="rb-icon <?php echo $_R['icon']?$_R['icon']:'fa fa-home'?>"></i><br>
			<i class="rb-name"><?php echo ucfirst($_R['id'])?></i>
		</a>
	</div>
</li>
<?php endwhile?>
</ul>
