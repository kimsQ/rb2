<style media="screen">

.header [data-role="menu"] .nav-item .sub-item {
  display: none;
  position: fixed;
  z-index: 5;
  top: 73px;
  left: 0;
	right: 0;
  width: 100%;
  border-top: 1px solid #d4d4d4;
  border-bottom: 1px solid #d4d4d4;
  background-color: #fff;
  text-align: center;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

body.header-type2 .navbar [data-role="menu"] .nav-item .sub-item  {
  top: 108px
}
body.header-type3 .header [data-role="menu"] .nav-item .sub-item {
  top: 166px;
}

.header .nav .nav-item.hovered .sub-item {
  display: block;
}
.header .nav .nav-item .sub-item .col:hover {
  background-color: #f5f5f5
}
.header .nav .nav-item .sub-item .col:first-child {
  border-left: 1px solid #d4d4d4;
}
.header .nav .nav-item .sub-item .col {
  border-right: 1px solid #d4d4d4;
}
.header .sub-item .col h4 a {
  font-size: 16px;
  letter-spacing: -1px;
}
.header .sub-item .col h4 a.active,
.header .sub-item .col .nav a.active {
  color: #007bff;
}
.header .sub-item .col a {
  font-size: 13px;
  color: #333
}
.header .sub-item .col a:hover {
  color: #007bff;
}

.header .dropdown-menu {
  margin-top: -10px;
}

.header .dropdown-menu::after {
  top: -14px;
  left: 30px;
  right: auto;
}
.header .dropdown-menu-right::after {
  right: 20px;
  left: auto;
}
.header .dropdown-menu::before, .dropdown-menu::after {
  position: absolute;
  display: inline-block;
  content: "";
}
.header .dropdown-menu::after {
  /* border: 7px solid transparent; */
  /* border-bottom-color: #fff; */
}


</style>

<?php
if (!function_exists('getMenuWidgetTree'))
{
	function getMenuWidgetTree($site,$table,$is_child,$parent,$depth,$id,$w,$_C)
	{
		global $_CA,$d;

    $_container = $d['layout']['header_container'];

		if ($depth < $w['limit'])
		{
			$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'hidden=0 and parent='.$parent.' and depth='.($depth+1).($w['mobile']?' and mobile=1':'').' order by gid asc','*');
			echo "\n";
			for ($i=0;$i<$depth;$i++) echo "\t";

			if($is_child) {
				if ($_C['depth']==1) {
					echo "<div class='sub-item'><div class='".$_container."'><div class='row w-100'>\n";
				} else {
					echo "<nav class='nav flex-column'>\n";
				}
			}

			while($C=db_fetch_array($CD))
			{
				$_newTree	= ($id?$id.'/':'').$C['id'];
				$_href		= $w['link']=='bookmark'?' data-scroll href="#'.($C['is_child']&&$w['limit']>1&&!$parent?'':str_replace('/','-',$_newTree)).'"' : ' href="'.RW('c='.$_newTree).'"';
				$_dropdown	= $C['is_child']&&$C['depth']==($w['depth']+1)&&$w['olimit']>1?' class="nav-link"':'';
				$_name		= $C['name'];
				$_target	= $C['target']=='_blank'?' target="_blank"':'';
				$_addattr	= $C['addattr']?' '.$C['addattr']:'';

				for ($i=0;$i<$C['depth'];$i++) echo "\t";

				if ($_C['depth']==1) {
					echo '<div class="col py-4 px-2"><h4 class="mb-0"><a class="nav-link'.(in_array($C['id'],$_CA)?' active':'').'"'.$_addattr.$_href.$_dropdown.$_target.'>'.$_name.'</a></h4>';
				} else if ($_C['depth']==2) {
					echo '<a class="nav-link '.(in_array($C['id'],$_CA)?' active':'').'"'.$_addattr.$_href.$_dropdown.$_target.'>'.$_name.'</a>';
				} else {
					echo '<li class="nav-item'.(in_array($C['id'],$_CA)?' active':'').'"><a class="nav-link"'.$_addattr.$_href.$_dropdown.$_target.'>'.$_name.'</a>';
				}

				if ($C['is_child']){
					getMenuWidgetTree($site,$table,$C['is_child'],$C['uid'],$C['depth'],$_newTree,$w,$C);
				}

				if ($_C['depth']==1) {
					echo "</nav></div>\n";
				} else if ($_C['depth']==2) {
					echo "\n";
				} else {
					echo "</li>\n";
				}
			}
			for ($i=0;$i<$depth;$i++) echo "\t";

			if($is_child) {
				if ($_C['depth']==1) {
					echo "</div></div></div>\n";
				} else if ($_C['depth']==2) {
					echo "\n";
				} else {
					echo "</nav></div>\n";
				}
			}

			for ($i=0;$i<$depth;$i++) echo "\t";
		}
	}
}
$wddvar['limit'] = $wddvar['limit'] < 6 ? $wddvar['limit'] : 5;
if ($wdgvar['smenu'] < 0)
{
	if (strstr($c,'/'))
	{
		$wdgvar['mnarr'] = explode('/',$c);
		$wdgvar['count'] = (- $wdgvar['smenu']) - 1;
		for ($j = 0; $j <= $wdgvar['count']; $j++) $wdgvar['sid'] .= $wdgvar['mnarr'][$j].'/';
		$wdgvar['sid'] = $wdgvar['sid'] ? substr($wdgvar['sid'],0,strlen($wdgvar['sid'])-1): '';
		$wdgvar['path'] = getDbData($table['s_menu'],"id='".$wdgvar['mnarr'][$wdgvar['count']]."'",'uid,depth');
		$wdgvar['smenu'] = $wdgvar['path']['uid'];
		$wdgvar['depth'] = $wdgvar['path']['depth'];
	}
	else {
		$wdgvar['sid'] = $c;
		$wdgvar['smenu'] = $_HM['uid'];
		$wdgvar['depth'] = $_HM['depth'];
	}
}
else if ($wdgvar['smenu'])
{
	$wdgvar['mnarr'] = explode('/',$wdgvar['smenu']);
	$wdgvar['count'] = count($wdgvar['mnarr']);
	for ($j = 0; $j < $wdgvar['count']; $j++)
	{
		$wdgvar['path'] = getDbData($table['s_menu'],'uid='.(int)$wdgvar['mnarr'][$j],'uid,id,depth');
		$wdgvar['sid'] .= $wdgvar['path']['id'].'/';
		$wdgvar['smenu'] = $wdgvar['path']['uid'];
		$wdgvar['depth'] = $wdgvar['path']['depth'];
	}
	$wdgvar['sid'] = $wdgvar['sid'] ? substr($wdgvar['sid'],0,strlen($wdgvar['sid'])-1): '';
}
else {
	$wdgvar['depth'] = 0;
}
$wdgvar['olimit']= $wdgvar['limit'];
$wdgvar['limit'] = $wdgvar['limit'] + $wdgvar['depth'];
getMenuWidgetTree($s,$table['s_menu'],0,$wdgvar['smenu'],$wdgvar['depth'],$wdgvar['sid'],$wdgvar,array());
?>

<script>

  $('[data-role="menu"] .nav-item').hover(
  	function() {
  		$(this).addClass('hovered');
  	},
  	function() {
  		$(this).removeClass('hovered');
  	}
  );
  $(window).on('scroll', function() {
    $('[data-role="menu"] .nav-item').removeClass('hovered');
  });

</script>
