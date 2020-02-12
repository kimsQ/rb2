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
function getAttachFileList($parent_data,$mod,$type,$wysiwyg)
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
				if($type=='file') $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);
				else if($type=='photo') $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);
				else if($type=='audio') $html.=getAttachAudio($U,$mod,$featured_audio_uid,$wysiwyg);
				else if($type=='video') $html.=getAttachVideo($U,$mod,$featured_video_uid,$wysiwyg);
				else if($type=='doc') $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);
				else if($type=='zip') $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);
				else if($type=='pdf') $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);
				else $html.=getAttachFile($U,$mod,$featured_img_uid,$wysiwyg);;
      }


	return $html;
}


// 첨부파일 리스트 추출 함수 (낱개)
function getAttachFile($R,$mod,$featured_img_uid,$wysiwyg)
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
            $img_origin=$R['host'].'/'.$R['folder'].'/'.$R['tmpname'];
            $thumb_list=getPreviewResize($R['src'],'s'); // 미리보기 사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
            $thumb_modal=getPreviewResize($R['src'],'n'); // 정보수정 모달용  사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
            $insert_text='<figure class="media"><img src="'.$R['src'].'"><figcaption>'.$caption.'</figcaption></figure>';
			}else if($type=='file'){
						$caption=$R['caption']?$R['caption']:$R['name'];
						$src=$R['url'].$R['folder'].'/'.$R['name'];
						$insert_text='['.$caption.']('.$g['url_root'].'/?r='.$r.'&m=mediaset&a=download&uid='.$R['uid'].')';
			}


      $html='';
	$html.='
	 <li class="list-group-item dd-item" data-id="'.$R['uid'].'" style="background-color: transparent">
	 	<div class="d-flex justify-content-between">';
	 if($R['type']==2){
	      $html.='
						<div class="dd-handle fa fa-arrows" title="순서변경"></div>
            <div class="media ml-3 mr-auto align-items-center text-truncate">
                <a href="#" class="d-flex align-self-center mr-3 " data-attach-act="'.($wysiwyg?'insert':'').'" data-type="'.$type.'" data-origin="'.($R['type']==2?$img_origin:$src).'" data-caption="'.$caption.'" data-editor="'.$wysiwyg.'"><img class="border" src="'.$thumb_list.'" alt="'.$caption.'" style="width: 50px"></a>
                <div class="media-body">';
                    $html.='<span class="badge badge-warning'.($R['uid']==$featured_img_uid?'':' d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
                    $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
                    $html.='
                    <a href="#" class="text-reset" data-role="attachList-list-name-'.$R['uid'].'" data-attach-act="insert" data-type="'.$type.'" data-origin="'.($R['type']==2?$img_origin:$src).'" data-caption="'.$caption.'" data-editor="'.$wysiwyg.'">'.$R['name'].'</a>
                    <small class="text-muted">'.getSizeFormat($R['size'],2).'</small>
                </div>
            </div>';
			}else {
            $html.='
						<div class="dd-handle fa fa-arrows" title="순서변경"></div>
						<div class="ml-3 mr-auto align-self-center">
            <i class="fa fa-floppy-o fa-fw mr-1"></i>';
           $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
           $html.='
            <a href="#" class="list-group-item-text text-truncate text-reset" data-role="attachList-list-name-'.$R['uid'].'" data-attach-act="insert" data-type="'.$type.'" data-origin="'.($R['type']==2?$img_origin:$src).'" data-caption="'.$caption.'" data-editor="'.$wysiwyg.'">'.$R['name'].'</a>
            <small class="text-muted">'.getSizeFormat($R['size'],2).'</small>
						</div>';
      }
		 	if($mod=='upload')  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';

      $html.='<div style="margin-top:-5px;margin-right: -17px;"><div class="btn-group btn-group-sm">';

						if($mod=='upload'){
						$html.='
						<button type="button" class="btn btn-link text-reset dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-right">';
							if($R['type']==2){
								$html.='
									<a class="dropdown-item" href="#" data-attach-act="featured-img" data-type="'.$type.'" data-id="'.$R['uid'].'">대표이미지 설정</a>';
							 }
							 $html.='
								<a class="dropdown-item" href="#" data-toggle="modal" data-backdrop="false" data-target="#modal-attach-'.($R['type']==2?'photo':'file').'-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="'.$type.'" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</a>
								<a class="dropdown-item" href="#" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
								<a class="dropdown-item" href="#" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="'.$type.'">삭제</a>
						 </div>';
						}
						$html.='</div></div></div>';
      $html.='</li>';

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
		<li class="list-group-item d-flex justify-content-between align-items-center dd-item animated fadeInDown" data-id="'.$R['uid'].'" style="background-color: transparent">
			<div class="dd-handle fa fa-arrows" title="순서변경"></div>';

		$html.='<div class="ml-3 mr-auto w-100"><span class="badge badge-secondary'.($R['uid']==$featured_audio_uid?'':' d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
	  $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
		$html.='
		<audio controls class="align-middle mr-4"><source src="'.$R['url'].$R['folder'].'/'.$R['tmpname'].'" type="audio/mpeg"></audio>';
		$html.='<span data-role="attachList-list-name-'.$R['uid'].'" >'.$R['name'].'</span>';
		$html.='
		<span class="badge badge-secondary">'.getSizeFormat($R['size'],2).'</span></div>';
		$html.='
		<span class="align-self-center">
		  <div class="btn-group btn-group-sm">';
		  if($mod=='upload')  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
		  $html.='
		  <button type="button" class="btn btn-light" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="audio">삭제</button>';
		  if($mod=='upload'){
		  $html.='
		  <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
		    <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <div class="dropdown-menu dropdown-menu-right">';
		            $html.='
		              <a class="dropdown-item" href="#" data-attach-act="featured-audio" data-type="'.$type.'" data-id="'.$R['uid'].'">대표오디오 설정</a>';

		             $html.='
		      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-attach-file-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="audio" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</a>
		      <a class="dropdown-item" href="#" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
		      <a class="dropdown-item" href="#" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="audio">삭제</a>
		   </div>';
		  }
		  $html.='
		</div>
		</span>

		</li>';
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
		<li class="list-group-item d-flex justify-content-between align-items-center dd-item animated fadeInDown" data-id="'.$R['uid'].'" style="background-color: transparent">
			<div class="dd-handle fa fa-arrows" title="순서변경"></div>
			<div class="ml-3 mr-auto w-100">';

		$html.='<span class="badge badge-secondary'.($R['uid']==$featured_video_uid?'':' d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
	  $html.='<span class="badge badge-secondary'.(!$R['hidden']?' d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
		$html.='
		<video width="320" height="240" controls class="align-middle mr-3"><source src="'.$R['url'].$R['folder'].'/'.$R['tmpname'].'" type="video/'.$R['ext'].'"></video>';
		$html.='<span data-role="attachList-list-name-'.$R['uid'].'" >'.$R['name'].'</span>';
		$html.='
		<span class="badge badge-secondary">'.getSizeFormat($R['size'],2).'</span></div>';
		$html.='<div class="align-self-center">
		  <div class="btn-group btn-group-sm">';
		  if($mod=='upload')  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
		  $html.='
		  <button type="button" class="btn btn-light" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="video">삭제</button>';
		  if($mod=='upload'){
		  $html.='
		  <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
		      <span class="caret"></span>
		      <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <div class="dropdown-menu dropdown-menu-right">';
		            $html.='
		              <a class="dropdown-item" href="#" data-attach-act="featured-video" data-type="'.$type.'" data-id="'.$R['uid'].'">대표 비디오 설정</a>';

		             $html.='
		      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-attach-file-meta" data-filename="'.$file_name.'"  data-fileext="'.$R['ext'].'" data-caption="'.$caption.'" data-src="'.$thumb_modal.'" data-origin="'.$img_origin.'" data-attach-act="edit" data-id="'.$R['uid'].'" data-type="video" data-role="attachList-menu-edit-'.$R['uid'].'">정보수정</a>
		      <a class="dropdown-item" href="#" data-attach-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
		      <a class="dropdown-item" href="#" data-attach-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="video	">삭제</a>
		   </div>';
		  }
		  $html.='
		</div>
		</div>

		</li>';
		return $html;
}



// 삽입 이미지 uid 얻기 함수
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
