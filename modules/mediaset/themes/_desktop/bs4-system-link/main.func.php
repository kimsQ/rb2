<?php
function getAttachPlatformList($parent_data,$mod,$wysiwyg) {
  global $table;

      $upload=$parent_data['upload'];
      $featured_img_uid=$parent_data['featured_img'];// 대표이미지 uid

      $sql='fserver=3';
      $attach = getArrayString($upload);

      $uid_q='(';
      foreach($attach['data'] as $uid)
     {
         $uid_q.='uid='.$uid.' or ';
     }

     $uid_q=substr($uid_q,0,-4).')';
       $sql=$sql.' and '.$uid_q;
       $RCD=getDbArray($table['s_upload'],$sql,'*','gid','desc','',1);
       $html='';
       while($R=db_fetch_array($RCD)){
         $U=getUidData($table['s_upload'],$R['uid']);
         $html.=getAttachPlatform($U,$mod,$featured_img_uid,$wysiwyg);
       }
  return $html;

}

// 추출 함수 (낱개)
function getAttachPlatform($R,$mod,$featured_img_uid,$wysiwyg) {
      global $g,$r;

      $md_title=str_replace('|','-',$R['title']);
      $thumbnail_url_parse = parse_url($R['src']);
      $thumbnail_url_arr = explode('//',$R['src']);

      if ($R['provider']=='Google Maps') $thumbnail = $R['src'];
      else $thumbnail = '/thumb'.($thumbnail_url_parse['scheme']=='https'?'-ssl':'').'/50x50/u/'.$thumbnail_url_arr[1];

      $insert_text='<figure class="media"><oembed url="'.$R['linkurl'].'"></oembed></figure>';
      $html='';
      $html.='
      <li class="list-group-item dd-item" data-id="'.$R['uid'].'">
        <div class="d-flex justify-content-between">';
      $html.='
					<div class="dd-handle fa fa-arrows" title="순서변경"></div>
          <div class="media ml-3">
              <a data-link-act="'.($wysiwyg?'insert':'').'"  data-provider="'.$R['provider'].'"  data-url="'.$R['linkurl'].'"  data-id="'.$R['uid'].'"  data-role="attachList-menu-edit-'.$R['uid'].'" href="" class="mr-3 position-relative"><img class="border" src="'.$thumbnail.'" alt="" style="width:50px;height:50px"><span class="position-absolute'.($R['duration']?'':' d-none').'" style="bottom:5px;right:5px;"><i class="fa fa-play-circle text-white" style="font-size:20px;text-shadow: 2px 2px 2px gray;" aria-hidden="true"></i></span></a>
              <div class="media-body">';
                  $html.='<span class="badge badge-pill badge-warning '.($R['uid']==$featured_img_uid?'':'d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
                  $html.='<span class="badge badge-pill badge-secondary '.(!$R['hidden']?'d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
                  $html.='
                   <a href="'.$R['linkurl'].'" target="_blank" class="title d-inline text-reset" data-role="attachList-list-name-'.$R['uid'].'" >'.($R['caption']?$R['caption']:$R['description']).'</a>
                   <div class="meta"><span class="badge badge-pill badge-light">'.$R['provider'].'</span> <span class="badge badge-pill badge-light" data-role="attachList-list-time-'.$R['uid'].'">'.$R['time'].'</span></div>';

          $html.='
                </div>
            </div>';

            $html.='
              <div style="margin-top:-5px;margin-right: -21px;">';
                  $html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
                  $html.='
                  <div class="btn-group"><button type="button" class="btn btn-link text-reset dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a class="dropdown-item" href="#" data-link-act="featured-img" data-id="'.$R['uid'].'">대표이미지 설정</a>
                    <a class="dropdown-item" href="#" data-link-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</a>
                    <a class="dropdown-item" href="#" data-link-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'">삭제</a>
                   </div>
              </div></div>';

          $html.='</div>';

          if (!$wysiwyg) $html.='<div class="input-group ml-3 mt-2"><textarea class="form-control f13" id="clipboard-'.$R['uid'].'">'.$insert_text.'</textarea><div class="input-group-append"><button class="btn btn-light" data-attach-act="clipboard" data-clipboard-target="#clipboard-'.$R['uid'].'" type="button">복사</button></div></div>';
					$html.='</li>';

  return $html;
}
?>
