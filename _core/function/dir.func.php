<?php
//디렉토리복사
function DirCopy($dir1 , $dir2)
{
	$dirh = opendir($dir1); 
	while(false !== ($filename = readdir($dirh))) 
	{ 
		if($filename != '.' && $filename != '..') 
		{
			if(!is_file($dir1.'/'.$filename)) 
			{
				@mkdir($dir2.'/'.$filename , 0707);
				@chmod($dir2.'/'.$filename , 0707);
				DirCopy($dir1.'/'.$filename , $dir2.'/'.$filename);
			}
			else 
			{ 
				@copy($dir1.'/'.$filename , $dir2.'/'.$filename); 
				@chmod($dir2.'/'.$filename , 0707);
			}
		}
	} 
	closedir($dirh);
}
//디렉토리삭제
function DirDelete($t_dir)
{
	$dirh = opendir($t_dir); 
	while(false !== ($filename = readdir($dirh))) 
	{ 
		if($filename != '.' && $filename != '..') 
		{
			if(!is_file($t_dir.'/'.$filename)) 
			{
				DirDelete($t_dir.'/'.$filename);
			}
			else { 
				@unlink($t_dir.'/'.$filename); 
			}
		}
	} 
	closedir($dirh);
	@rmdir($t_dir);
}
//디렉토리사이즈/파일갯수
function DirSizeNum($t_dir)
{
	$dirh = opendir($t_dir); 
	while(false !== ($filename = readdir($dirh))) 
	{ 
		if($filename != '.' && $filename != '..') 
		{
			if(!is_file($t_dir.'/'.$filename)) {
				$s = DirSizeNum($t_dir.'/'.$filename);
				$d['size'] += $s['size'];
				$d['num'] += $s['num'];
			}
			else { 
				$d['size'] += filesize($t_dir.'/'.$filename); 
				$d['num']++;
			}
		}
	} 
	closedir($dirh);
	return $d;
}
//퍼미션변경
function DirChmod($t_dir,$mode)
{
	$dirh = opendir($t_dir); 
	while(false !== ($filename = readdir($dirh))) 
	{ 
		if($filename != '.' && $filename != '..') 
		{
			if(!is_file($t_dir.'/'.$filename)) 
			{
				@chmod($t_dir.'/'.$filename,$mode); 
				DirChmod($t_dir.'/'.$filename,$mode);
			}
			else { 
				@chmod($t_dir.'/'.$filename,$mode); 
			}
		}
	} 
	closedir($dirh);
	@chmod($t_dir,$mode);
}
//압축
function DirZip($t_dir,$n_dir,$zipfile)
{
	$dirh = opendir($t_dir); 
	while(false !== ($filename = readdir($dirh))) 
	{ 
		if($filename != '.' && $filename != '..') 
		{
			if(!is_file($t_dir.'/'.$filename)) 
			{
				$zipfile -> add_file('',$n_dir.'/'.$filename.'/');
				DirZip($t_dir.'/'.$filename,$n_dir.'/'.$filename,$zipfile);
			}
			else { 
				$zipfile -> add_file($t_dir.'/'.$filename,$n_dir.'/'.$filename);
			}
		}
	} 
	closedir($dirh);
}
//디렉토리생성
function DirMake($dir)
{
	@mkdir($dir,0707);
	@chmod($dir,0707);
}
?>