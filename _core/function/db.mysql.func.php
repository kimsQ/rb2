<?php
function isConnectedToDB($db)
{
	return mysqli_connect($db['host'],$db['user'],$db['pass'],$db['name']);
}
function db_query($sql,$con)
{
	mysqli_query($con,'set names utf8mb4');
	mysqli_query($con,'set sql_mode=\'\'');
	return mysqli_query($con,$sql);
}
function db_fetch_array($que)
{
	return @mysqli_fetch_array($que);
}
function db_fetch_assoc($que)
{
	return mysqli_fetch_assoc($que);
}
function db_num_rows($que)
{
	return mysqli_num_rows($que);
}
function db_info()
{
	global $DB_CONNECT;
	return mysqli_get_server_info($DB_CONNECT);
}
function db_error()
{
	return mysqli_error();
}
function db_close($conn)
{
	return mysqli_close($conn);
}
function db_insert_id($conn)
{
	return mysqli_insert_id($conn);
}
//DB-UID데이터
function getUidData($table,$uid)
{
	return getDbData($table,'uid='.(int)$uid,'*');
}
//DB데이터 1ROW
function getDbData($table,$where,$data)
{
	$row = db_fetch_array(getDbSelect($table,getSqlFilter($where),$data));
	return $row;
}
//DB데이터 ARRAY
function getDbArray($table,$where,$data,$sort,$orderby,$recnum,$p)
{
	global $DB_CONNECT;
	$rcd = db_query('select '.$data.' from '.$table.($where?' where '.getSqlFilter($where):'').' order by '.$sort.' '.$orderby.($recnum?' limit '.(($p-1)*$recnum).', '.$recnum:''),$DB_CONNECT);
	return $rcd;
}
//DB데이터 NUM
function getDbRows($table,$where)
{
	global $DB_CONNECT;
	$rows = db_fetch_array(db_query('select count(*) from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT));
	return $rows[0] ? $rows[0] : 0;
}
//DB데이터 MAX
function getDbCnt($table,$type,$where)
{
	global $DB_CONNECT;
	$cnts = db_fetch_array(db_query('select '.$type.' from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT));
	return $cnts[0] ? $cnts[0] : 0;
}
//DB셀렉트
function getDbSelect($table,$where,$data)
{
	global $DB_CONNECT;
	$r = db_query('select '.$data.' from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
	return $r;
}
//DB삽입
function getDbInsert($table,$key,$val)
{
	global $DB_CONNECT;
	db_query("insert into ".$table." (".$key.")values(".$val.")",$DB_CONNECT);
}
//DB업데이트
function getDbUpdate($table,$set,$where)
{
	global $DB_CONNECT;
	db_query("update ".$table." set ".$set.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
}
//DB삭제
function getDbDelete($table,$where)
{
	global $DB_CONNECT;
	db_query("delete from ".$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
}

//SQL필터링
function getSqlFilter($sql)
{
	return preg_replace("( union| update| insert| delete| drop|\/\*|\*\/|\\\|\;)",'',$sql);
}
?>
