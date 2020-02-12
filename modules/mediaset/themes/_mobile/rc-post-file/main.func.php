<?php
// 첨부파일 리스트 갯수 추출 함수
function getAttachNum($upload,$mod)
{
	global $table;

	$attach = getArrayString($upload);
	$attach_file_num=0;// 첨부파일 수량
	$hidden_file_num=0; // 숨김파일(다운로드 방지) 수량
	foreach($attach['data'] as $val)
	{
		$U = getUidData($table['s_upload'],$val);
		if($U['fileonly']==1) $attach_file_num++; // 전체 첨부파일 수량 증가
		if($U['hidden']==1) $hidden_file_num++; // 숨김파일 수량 증가
	}
  $down_file_num=$attach_file_num-$hidden_file_num; // 다운로드 가능한 첨부파일
  $result=array();
  $result['modify']=$attach_file_num;
  $result['view']=$down_file_num;

  return $result[$mod];
}

// 첨부파일 리스트 추출 함수 (전체)
/*
   $parent_data : 해당 포스트의 row 배열
   $mod : upload or modal  ==> 실제 업로드 모드 와 모달을 띄워서 본문에 삽입용도로 쓰거나
*/
function getAttachFileList($parent_data,$mod,$type,$p_module) {
	global $table;

   $upload=$parent_data['upload'];
   $featured_img_uid=$parent_data['featured_img'];// 대표이미지 uid
	 $featured_video_uid=$parent_data['featured_video'];// 대표비디오 uid
	 $featured_audio_uid=$parent_data['featured_audio'];// 대표오디오 uid

	 if($type=='photo') $sql='type=2';
   else if($type=='audio') $sql='type=4';
	 else if($type=='video') $sql='type=5';
	 else $sql='(type=1 or type=6 or type=7)';

	 if ($mod=='view') $sql.=' and hidden=0';

   $attach = getArrayString($upload);
   $uid_q='(';
   foreach($attach['data'] as $uid) {
		$uid_q.='uid='.$uid.' or ';
	 }

	$uid_q=substr($uid_q,0,-4).')';
  $sql=$sql.' and '.$uid_q;
  $RCD=getDbArray($table['s_upload'],$sql,'*','gid','asc','',1);
  $html='';
  while($R=db_fetch_array($RCD)){
	 	$U=getUidData($table['s_upload'],$R['uid']);

		if($type=='file') $html.=getAttachFile($U,$mod,$featured_img_uid,$p_module);
		else if($type=='photo') $html.=getAttachFile($U,$mod,$featured_img_uid,$p_module);
		else if($type=='audio') $html.=getAttachAudio($U,$mod,$featured_audio_uid,$p_module);
		else if($type=='video') $html.=getAttachVideo($U,$mod,$featured_video_uid,$p_module);
		else $html.=getAttachFile($U,$mod,$featured_img_uid,$p_module);
  }

	return $html;
}

// 첨부파일 리스트 추출 함수 (낱개)
function getAttachFile($R,$mod,$featured_img_uid,$p_module) {

	global $g,$r,$TMPL	;

	include_once $GLOBALS['g']['path_core'].'function/sys.class.php';

  $fileName=explode('.',$R['name']);
  $file_name=$fileName[0]; // 파일명만 분리

	$sync_array = getArrayString($R['sync']);
	$m = $sync_array['data'][0];

	if ($R['type']==2) {
		$type='photo';
	} elseif($R['type']==4) {
		$type='audio';
	} elseif($R['type']==5) {
		$type='video';
	} else {
		$type='file';
	}

  if($type=='photo'){
    $caption=$R['caption']?$R['caption']:$file_name;
    $img_origin=$R['host'].'/'.$R['folder'].'/'.$R['tmpname'];
		$thumb_list=getPreviewResize($R['src'],'q'); // 미리보기 사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
    $thumb_modal=getPreviewResize($R['src'],'n'); // 정보수정 모달용  사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
		$thumb_view=getPreviewResize($R['src'],'600x600'); // 보기 페이지 출력용
    $insert_text='!['.$caption.']('.$g['url_root'].$img_origin.')';
	}else if($type=='file'){
		$caption=$R['caption']?$R['caption']:$R['name'];
		$src=$R['host'].$R['folder'].'/'.$R['name'];
		$down_url=$g['s'].'/?r='.$r.'&m=mediaset&a=download&uid='.$R['uid'];
	}

  $html='';

	$TMPL['m']=$p_module;
	$TMPL['is_featured']=$R['uid']==$featured_img_uid?'':' hidden';
	$TMPL['is_hidden']=!$R['hidden']?' hidden':'';
	$TMPL['hidden_code']=$R['hidden']?'show':'hide';
	$TMPL['hidden_str']=$R['hidden']?'보이기':'숨기기';
	$TMPL['img_origin']=$img_origin;
	$TMPL['uid']=$R['uid'];
	$TMPL['img_origin_width']=$R['width'];
	$TMPL['img_origin_height']=$R['height'];
	$TMPL['type']=$type;
	$TMPL['type_modal']=$R['type']==2?'photo':'file';
	$TMPL['file_name']=$file_name;
	$TMPL['fileext']=$R['ext'];
	$TMPL['caption']=$caption;
	$TMPL['showhide']=!$R['hidden']?'hide':'show';
	$TMPL['insert_text']=$insert_text;
	$TMPL['thumb_modal']=$thumb_modal;
	$TMPL['thumb_list']=$thumb_list;
	$TMPL['thumb_view']=$thumb_view;
	$TMPL['name']=$R['name'];
	$TMPL['_name']=getStrCut($R['name'],25,'..');
	$TMPL['size']=getSizeFormat($R['size'],2);
	$TMPL['uid']=$R['uid'];
	$TMPL['down_url']=$down_url;

	if ($mod=='upload') {
		if ($R['type']==2) $markup_file = 'edit_photo_row';
		else $markup_file = 'edit_file_row';
	} else {
		if ($R['type']==2) $markup_file = 'view_photo_row';
		else $markup_file = 'view_file_row';
	}

	$skin=new skin($markup_file);
	$html.=$skin->make();

	return $html;
}

// 오디오파일 리스트 추출 함수 (낱개)
function getAttachAudio($R,$mod,$featured_audio_uid)
{
		global $g,$r;

		$fileName=explode('.',$R['name']);
		$file_name=$fileName[0]; // 파일명만 분리
		$caption=$R['caption']?$R['caption']:$file_name;

		$html='';
	  $html.='
		<div class="card bg-white" data-id="'.$R['uid'].'" data-role="attach-item">
				<audio controls class="card-img-top w-100"><source src="'.$R['host'].'/'.$R['folder'].'/'.$R['tmpname'].'" type="audio/mp3"></audio>
				<div class="card-block">';
				if($mod=='upload')  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
				$html.='
				<button type="button" class="btn btn-secondary btn-block mb-2" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="audio">삭제</button>';
				if($mod=='upload'){
									$html.='
										<a class="btn btn-secondary" href="#" data-attach-act="featured-audio" data-type="'.$type.'" data-id="'.$R['uid'].'">대표오디오 설정</a></li>';

									 $html.='
						<a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#modal-attach-file-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="audio" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</a>
						<a class="btn btn-secondary" href="#" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
				 ';
				}
		$html.='<h6 class="card-title mt-4"><span data-role="attachList-list-name-'.$R['uid'].'" >'.$R['name'].'</span>';
		$html.='<span class="badge badge-default'.($R['uid']==$featured_audio_uid?'':' hidden-xs-up').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
	  $html.='<span class="badge badge-default'.(!$R['hidden']?' hidden-xs-up':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
		$html.='
		<span class="badge badge-default">'.getSizeFormat($R['size'],2).'</span></h6><p></p></div></div>';
		return $html;
}


// 비디오파일 리스트 추출 함수 (낱개)
function getAttachVideo($R,$mod,$featured_video_uid)
{
		global $g,$r;

		$fileName=explode('.',$R['name']);
		$file_name=$fileName[0]; // 파일명만 분리
		$caption=$R['caption']?$R['caption']:$file_name;

		$html='';
	  $html.='
		<div class="card bg-white" data-id="'.$R['uid'].'" data-role="attach-item">';

		$html.='
		<div class="card-img-top embed-responsive embed-responsive-4by3"><video controls class="embed-responsive-item" controls preload="none"><source src="'.$R['host'].'/'.$R['folder'].'/'.$R['tmpname'].'" type="video/'.$R['ext'].'"></video></div>';
		$html.='<div class="card-block"><h5 class="card-title" data-role="attachList-list-name-'.$R['uid'].'" >'.$R['name'];

		$html.='<span class="badge badge-default'.($R['uid']==$featured_video_uid?'':' hidden-xs-up').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
	  $html.='<span class="badge badge-default'.(!$R['hidden']?' hidden-xs-up':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span></h5	>';

		$html.='
		<p class="card-text text-muted">'.getSizeFormat($R['size'],2).'</p>';

		if($mod=='upload'){ $html.=' <input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>
		<button type="button" class="btn btn-secondary btn-block btn-sm" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="video">삭제</button></li>
		<div class="btn-group btn-group-sm hidden" role="group">
			<button type="button" class="btn btn-secondary" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="video">삭제</button></li>
			<button type="button" class="btn btn-secondary" data-attach-act="featured-video" data-type="'.$type.'" data-id="'.$R['uid'].'">대표 비디오 설정</button></li>
			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-attach-file-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="video" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</button>
			<button type="button" class="btn btn-secondary" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</button>
		</div>
 </div>
';}

 $html.='</div>';

		return $html;
}



// 본문삽입 이미지 uid 얻기 함수
function getInsertImgUid($upload)
{
    global $table;

    $u_arr = getArrayString($upload);
    $Insert_arr=array();
    $i=0;
    foreach ($u_arr['data'] as $val) {
       $U=getUidData($table['s_upload'],$val);
       if(!$U['fileonly']) $Insert_arr[$i]=$val;
       $i++;
    }
    $upfiles='';
    // 중괄로로 재조립
    foreach ($Insert_arr as $uid) {
        $upfiles.='['.$uid.']';
    }

    return $upfiles;
}

function getAttachPhotoSwipeFull($parent_data){
  global $table;

     $upload=$parent_data['upload'];
     $sql='type=2 and hidden=0';

     $attach = getArrayString($upload);
     $uid_q='(';
     foreach($attach['data'] as $uid)
      {
        $uid_q.='uid='.$uid.' or ';
      }
      $uid_q=substr($uid_q,0,-4).')';
      $sql=$sql.' and '.$uid_q;
      $RCD=getDbArray($table['s_upload'],$sql,'*','gid','asc','',1);
      $html='';
      while($R=db_fetch_array($RCD)){

        $img_origin=$R['src'];

         $html.='<div class="swiper-slide" style="height:78vh;" data-uid="'.$R['uid'].'">
           <div class="swiper-zoom-container">
             <img src="'.$img_origin.'">
           </div>
         </div>';
       }
  return $html;
}

?>
