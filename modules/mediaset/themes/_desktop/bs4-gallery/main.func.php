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
function getAttachFileList($parent_data,$mod,$type,$editor)
{
	global $table;

     $upload=$parent_data['upload'];
     $featured_img_uid=$parent_data['featured_img'];// 대표이미지 uid
		 $featured_video_uid=$parent_data['featured_video'];// 대표비디오 uid
		 $featured_audio_uid=$parent_data['featured_audio'];// 대표오디오 uid

     if($type=='file') $sql='type=1';
		 else if($type=='photo') $sql='type=2';
     else if($type=='audio') $sql='type=4';
		 else if($type=='video') $sql='type=5';
		 else if($type=='doc') $sql='type=6';
		 else if($type=='zip') $sql='type=7';
		 else if($type=='pdf') $sql='type=7';
 		 else $sql='type=1';

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
       	$U=getUidData($table['s_upload'],$R['uid']);
				if($type=='file') $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);
				else if($type=='photo') $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);
				else if($type=='audio') $html.=getAttachAudio($U,$mod,$featured_audio_uid,$editor);
				else if($type=='video') $html.=getAttachVideo($U,$mod,$featured_video_uid,$editor);
				else if($type=='doc') $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);
				else if($type=='zip') $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);
				else if($type=='pdf') $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);
				else $html.=getAttachFile($U,$mod,$featured_img_uid,$editor);;
      }


	return $html;
}


// 첨부파일 리스트 추출 함수 (낱개)
function getAttachFile($R,$mod,$featured_img_uid,$editor)
{
	global $g,$r;

      $fileName=explode('.',$R['name']);
      $file_name=$fileName[0]; // 파일명만 분리

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
            $img_origin=$R['url'].$R['folder'].'/'.$R['tmpname'];
						$thumb_list=getPreviewResize($R['src'],'q'); // 미리보기 사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
            $thumb_modal=getPreviewResize($R['src'],'z'); // 정보수정 모달용  사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
            $insert_text='!['.$caption.']('.$g['url_root'].$img_origin.')';
			}else if($type=='file'){
						$caption=$R['caption']?$R['caption']:$R['name'];
						$src=$R['url'].$R['folder'].'/'.$R['name'];
						$insert_text='['.$caption.']('.$g['url_root'].'/?r='.$r.'&m=mediaset&a=download&uid='.$R['uid'].')';
			}
      $html='';
	$html.='
	 <li class="item" data-id="'.$R['uid'].'" style="background-color: transparent">';

	 if($R['type']==2){
	      $html.='
            <div class="">
                <img class="border" src="'.$thumb_list.'" alt="'.$caption.'" style="width: 120px">
                <div class="item-label">';
                    $html.='<span class="badge badge-secondary'.($R['uid']==$featured_img_uid?'':' d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
                    $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
                    $html.='
                    <a class="d-none" href="#" data-role="attachList-list-name-'.$R['uid'].'" data-attach-act="insert" data-type="'.$type.'" data-origin="'.($R['type']==2?$img_origin:$src).'" data-caption="'.$caption.'" data-editor="'.$editor.'">'.$R['name'].'</a>
                    <small class="d-none text-muted">'.getSizeFormat($R['size'],2).'</small>
                </div>
            </div>';
			}else {
            $html.='
						<div class="dd-handle fa fa-arrows" title="순서변경"></div>
						<div class="ml-5 mr-auto">
            <i class="fa fa-floppy-o fa-fw mr-1"></i>';
           $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
           $html.='
            <a href="#" class="list-group-item-text" data-role="attachList-list-name-'.$R['uid'].'" data-attach-act="insert" data-type="'.$type.'" data-origin="'.($R['type']==2?$img_origin:$src).'" data-caption="'.$caption.'" data-editor="'.$editor.'">'.$R['name'].'</a>
            <small class="text-muted">'.getSizeFormat($R['size'],2).'</small>
						</div>';
      }
		 	if($mod=='upload')  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
      $html.='<div class="item-btn"><div class="btn-group btn-group-sm">';
						$html.='
						<button type="button" class="btn btn-light" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="'.$type.'"><i class="fa fa-times" aria-hidden="true"></i></button>';
						if($mod=='upload'){
						$html.='
						<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right">';
							if($R['type']==2){
								$html.='
									<a class="dropdown-item" href="#" data-attach-act="featured-img" data-type="'.$type.'" data-id="'.$R['uid'].'">대표이미지 설정</a>';
							 }
							 $html.='
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-attach-'.($R['type']==2?'photo':'file').'-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="'.$type.'" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</a>
								<a class="dropdown-item" href="#" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
								<a class="dropdown-item" href="#" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="'.$type.'">삭제</a>
						 </div>';
						}
						$html.='
				</div></div>

      </li>';

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

?>
