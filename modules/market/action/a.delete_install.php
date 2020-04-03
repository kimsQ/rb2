<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();
$result['error']=false;

if(!$uid) {
	$result['error']='잘못된 접근 입니다.';
	echo json_encode($result);
	exit;
}

include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

if ($d['market']['url']) {
	include $g['path_core'].'function/rss.func.php';

	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=client.delete_install&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);

	$pathData = explode('[PATH:',$returnData);
	$pathData = explode(':PATH]',$pathData[1]);
	$path = $pathData[0];

	$path_arr = explode('/',$path);
	$ext = $path_arr[0];
	$folder = $path_arr[1];

	$returnData = explode('[RESULT:',$returnData);
	$returnData = explode(':RESULT]',$returnData[1]);
	$return = $returnData[0];

} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
	echo json_encode($result);
	exit;
}

if ($return != 'OK') {
	$result['error']=' 다시 시도해주세요.'.$return;
} else {

	// 모듈일 경우 DB 테이블 삭제
	if ($ext=='modules') {
		$moduleid = $folder;
		$R = getDbData($table['s_module'],"id='".$moduleid."'",'*');
		getDbDelete($table['s_module'],"id='".$moduleid."'");

		$table_db  = $g['path_module'].$moduleid.'/_setting/db.table.php.done';
		$_tmptfile = $g['path_var'].'table.info.php';

		if(is_file($table_db)) {

			$module= $moduleid;
			$_table= $table;
			$table = array();
			include_once $table_db;

			$fp = fopen($_tmptfile,'w');
			fwrite($fp, "<?php\n");
			foreach($_table as $key => $val)
			{
				if (!$table[$key])
				{
					fwrite($fp, "\$table['$key'] = \"$val\";\n");
				}
			}
			fwrite($fp, "?>");
			fclose($fp);
			@chmod($_tmptfile,0707);

			foreach($table as $key => $val) {
				db_query('drop table '.$val,$DB_CONNECT);
			}
		}

		setrawcookie('market_action_result', rawurlencode('모듈이 삭제 되었습니다.'));

	}

	// 폴더삭제
	$command_delete	= 'rm -rf '.$path;
	shell_exec($command_delete);

}

$result['ext']=$ext;
echo json_encode($result);
exit;

?>
