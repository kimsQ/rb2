<?php
if(!defined('__KIMS__')) exit;

// 넘어온 값 : type & data
//data 배열화 :  data=theme+'^^'+parent+'^^'+sort+'^^'+recnum+'^^'+page+'^^'+'+orderby+'^^'+last_cuid;
$data_arr=explode('^^',$data);
$theme=$data_arr[0];
$parent=$data_arr[1];
$c_sort=$data_arr[2];
$c_recnum=$data_arr[3];
$c_page=$data_arr[4];
$c_orderby=$data_arr[5];
$last_sort=$data_arr[6];
$_where=$c_sort."<>0";
if($type=='more')
{
   if($c_orderby=='asc') $_where .=" and ".$c_sort.">".$last_sort;  
   else $_where .=" and ".$c_sort."<".$last_sort;
}

include $theme.'comment/function.php';
?>
[RESULT:
<?php getCommentList($theme,$m.$parent,$_where,$c_recnum,$c_sort,$orderby1,$c_orderby,$c_page);?>
:RESULT]
<?php
exit;
?>
