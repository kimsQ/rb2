<?php
function getAttachPlatformList($parent_data,$mod,$type) {
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
       $RCD=getDbArray($table['s_upload'],$sql,'*','gid','asc','',1);
       $html='';
       while($R=db_fetch_array($RCD)){
         $U=getUidData($table['s_upload'],$R['uid']);
         $html.=getAttachPlatform($U,$mod,$featured_img_uid);
       }
  return $html;

}

// 추출 함수 (낱개)
function getAttachPlatform($R,$mod,$featured_img_uid) {
      global $g,$r;

      $md_title=str_replace('|','-',$R['title']);
      $thumbnail_url_parse = parse_url($R['src']);
      $thumbnail_url_arr = explode('//',$R['src']);

      if ($R['provider']=='Google Maps') {
        $thumbnail = $R['src'];
      } else if (strpos($R['src'], '?') !== false) {
        $thumbnail = '/_core/opensrc/timthumb/thumb.php?src='.$R['src'].'&w=50&h=50&s=1';
      } else {
        $thumbnail = '/thumb'.($thumbnail_url_parse['scheme']=='https'?'-ssl':'').'/50x50/u/'.$thumbnail_url_arr[1];
      }

      $insert_text='<video class=mejs-player img-responsive img-fluid  style=max-width:100% preload=none><source src=https://www.youtube.com/embed/'.$R['src'].' type=video/youtube></video>';
      $html='';
      $html.='
      <li class="list-group-item d-flex dd-item" data-id="'.$R['uid'].'" style="background-color: transparent">';

      $html.='
					<div class="dd-handle fa fa-arrows" title="순서변경"></div>
          <div class="media ml-3 mr-auto align-items-center">
              <a href="'.$R['linkurl'].'" target="_blank" class="d-flex align-self-center mr-3 position-relative"><img class="border" src="'.$thumbnail.'" alt="" style="width:50px;height:50px"><span class="position-absolute'.($R['duration']?'':' d-none').'" style="bottom:5px;right:5px;"><i class="fa fa-play-circle text-white" style="font-size:20px;text-shadow: 2px 2px 2px gray;" aria-hidden="true"></i></span></a>
              <div class="media-body">';
                  $html.='<span class="badge badge-pill badge-warning '.($R['uid']==$featured_img_uid?'':'d-none').'" data-role="attachList-label-featured" data-id="'.$R['uid'].'">대표</span> ';
                  $html.='<span class="badge badge-pill badge-secondary '.(!$R['hidden']?'d-none':'').'" data-role="attachList-label-hidden-'.$R['uid'].'">숨김</span>';
                  $html.='
                   <a href="'.$R['linkurl'].'" target="_blank" class="title d-inline" data-role="attachList-list-name-'.$R['uid'].'" >'.($R['caption']?getStrCut($R['caption'],45,'..'):getStrCut($R['description'],45,'..')).'</a>
                   <div class="meta"><span class="badge badge-pill badge-light">'.$R['provider'].'</span> <span class="badge badge-pill badge-light" data-role="attachList-list-time-'.$R['uid'].'">'.$R['time'].'</span></div>';

                   $html.='
       						<span class="d-block mt-2">
       							<div class="btn-group btn-group-sm">';
       									$html.='<input type="hidden" name="attachfiles[]" value="['.$R['uid'].']"/>';
       									 $html.='
                          <button type="button" class="btn btn-light" data-act="linkInsert" data-provider="'.$R['provider'].'"  data-url="'.$R['linkurl'].'" data-title="'.$R['caption'].'" data-id="'.$R['uid'].'"  data-role="attachList-menu-edit-'.$R['uid'].'" role="button">삽입</button>
       			 						 <button type="button" class="btn btn-light" data-link-act="delete" data-id="'.$R['uid'].'" data-role="attachList-menu-delete-'.$R['uid'].'" data-featured="" data-type="'.($R['type']==8?'youtube':'file').'" role="button">삭제</button>';
       									$html.='
       									<div class="btn-group"><button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" role="button"></button>
       									<div class="dropdown-menu dropdown-menu-right" role="menu">
       										<button type="button" class="dropdown-item" data-link-act="featured-img" data-type="'.$type.'" data-id="'.$R['uid'].'">대표이미지 설정</button>
       										<button type="button" class="dropdown-item" data-link-act="showhide" data-role="attachList-menu-showhide-'.$R['uid'].'" data-id="'.$R['uid'].'" data-content="'.($R['hidden']?'show':'hide').'" >'.($R['hidden']?'보이기':'숨기기').'</button>
       									 </div>
     									 </div>

       							</div>
       						</span>';

          $html.='
                </div>
            </div>';


					$html.='
  				</li>';

  return $html;
}
?>
