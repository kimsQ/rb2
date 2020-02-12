<?php
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
?>