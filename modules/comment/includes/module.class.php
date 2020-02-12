<?php

class Comment extends Comment_base{
    public $parent;
    public $parent_table;
    public $theme_name;
    public $recnum; // 출력 기본 값
    public $sort;
    public $orderby;
    public $oneline_recnum = 5;

    // 테마 패스 추출함수
    public function getThemePath($type){
        global $g;

        if($type=='relative') $result = $g['path_module'].$this->module.'/themes/'.$this->theme_name;
        else if($type=='absolute') $result = $g['url_root'].'/modules/'.$this->module.'/themes/'.$this->theme_name;

        return $result;
    }
    // get html & replace-parse
    public function getHtml($fileName) {
        global $g,$TMPL;
        $theme_path = $this->getThemePath('relative');
        $file = sprintf($theme_path.'/html/%s.html', $fileName);
        $fh_skin = fopen($file, 'r');
        $skin = @fread($fh_skin, filesize($file));
        fclose($fh_skin);
        //return $skin;
        return $this->getParseHtml($skin);
    }

    public function getParseHtml($skin) {
        global $TMPL;
        // $skin = preg_replace_callback('/{\$lng->(.+?)}/i', create_function('$matches', 'global $LNG; return $LNG[$matches[1]];'), $skin);
        $skin = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/', create_function('$matches', 'global $TMPL; return (isset($TMPL[$matches[1]])?$TMPL[$matches[1]]:"");'), $skin);

        return $skin;
    }

    // 이모티콘 리스트 추출 함수
    public function getEmoticonList($parent){
        global $g;
        $m = $this->module;
        $theme_path = $this->getThemePath('absolute');
        $emo_array=array("sunglass","smile","sleep","shock","love","laugh","joke","cry");
        $emo_folder = $theme_path.'/images/emoticon';
        $emo_list ='<ul>';
        foreach ($emo_array as $emo) {
            $emo_list .='<li data-role="insert-emoticon" data-emotion="'.$emo.'" data-parent="'.$parent.'"><img src="'.$emo_folder.'/emo_'.$emo.'.png" /></li>';
        }
        $emo_list .='</ul>';

        return $emo_list;
    }


    // 전체 페이지 값 추출
    public function getTotalData($parent,$recnum,$type,$data,$notice){
        global $s,$table;
        if($type=='comment'){
           $_wh = $this->getCommentWhere($parent,$notice);
           $query = sprintf("SELECT uid FROM `%s` WHERE %s", $this->commentTable,$_wh);
        }
        else if($type=='oneline'){
           $_wh = $this->getOnelineWhere($parent);
           $query = sprintf("SELECT uid FROM `%s` WHERE %s", $this->onelineTable,$_wh);
        }

        $result=array();
        $total_row = $this->getRows($query);
        $result['row'] =  $total_row;// 전체 row 합계
        $result['page'] = ceil($total_row/$recnum); // 전체 페이지

        return $result[$data];
    }

    // chat 쿼리 추출
    public function getCommentWhere($parent,$notice){
        global $s;
        $_parent = str_replace('-','',$parent);
        $where = "site='".$s."' and notice=".$notice." and parent='".$_parent."'";
        return $where;
    }

    // 챗팅 history 추출 함수
    public function getCommentLog($parent,$sort,$orderby,$recnum,$page,$notice){
        global $table,$s;
        $parent = $this->db->real_escape_string($parent);
        $page = $page?$page:1;
        $sort = $sort?$sort:$this->sort;
        $orderby = $orderby?$orderby:$this->orderby;
        $recnum = $recnum?$recnum:$this->recnum;
        $_wh = $this->getCommentWhere($parent,$notice);
        $limit=(($page-1)*$recnum).','.$recnum;
        $query = sprintf("SELECT * FROM `%s` WHERE %s ORDER BY `%s` %s LIMIT %s", $this->commentTable,$_wh,$sort,$orderby,$limit);
        $rows = $this->getAssoc($query);
        $commentLog ='';
        foreach($rows as $row) {
           $commentLog .= $this->getCommentRow($row,$page,$notice);
        }
        return $commentLog;

    }

    // 채팅 history row 추출 함수
    public function getCommentRow($row,$page,$notice){

        global $TMPL,$my,$g,$d,$_HS;
        include_once $g['path_module'].$this->module.'/var/var.php';

        $sync_arr = explode('|',$row['sync']); // parent_table|parent|parentmbr
        $TMPL['grant_uid'] = $sync_arr[2]; // 댓글 부모 PK
        $TMPL['comment_content'] = getContents($row['content'],'HTML');
        $TMPL['comment_user_name'] = $row[$_HS['nametype']]?$row[$_HS['nametype']]:'손님';
        $TMPL['comment_user_pic'] = $this->getUserAvatar($row['mbruid'],'src');
        $TMPL['comment_user_uid'] = $row['mbruid'];
        $TMPL['comment_user_nic'] = getProfileInfo($row['mbruid'],'nic');
        $TMPL['comment_user_url'] = getProfileLink($row['mbruid']);
        $TMPL['comment_like_total'] = ($row['likes']==0)?'':$row['likes'];
        $TMPL['comment_uid'] = $row['uid'];
        $TMPL['comment_regis_time'] = getDateFormat($row['d_modify']?$row['d_modify']:$row['d_regis'],'Y.m.d H:i');
        $TMPL['comment_regis_ago'] = getDateFormat($row['d_modify']?$row['d_modify']:$row['d_regis'],'c');
        $TMPL['comment_getNew'] = $this->getNew($row['d_modify']?$row['d_modify']:$row['d_regis'],$d['comment']['newtime']);
        $TMPL['comment_getNoitce'] = $row['notice']?'true':'false';
        $TMPL['comment_getIsNoitce'] = $row['notice']?'':'d-none';
        $TMPL['comment_getHidden'] = $row['hidden']?'true':'false';
        $TMPL['comment_getIsLiked'] = $this->getIsLiked('comment',$row['uid'],'like');
        $TMPL['comment_getIsDisliked'] = $this->getIsLiked('comment',$row['uid'],'dislike');
        $TMPL['comment_page'] = $page;
        $TMPL['oneline_rows'] = $this->getOnelineLog($row['uid'],1,$this->oneline_recnum);
        $TMPL['uid'] = $row['uid'];
        $TMPL['entry_type'] = 'comment';
        $TMPL['entry_parent'] = $sync_arr[1].$sync_arr[2];
        $TMPL['comment_parent'] =$this->parent;
        $TMPL['total_page'] = $this->getTotalData($sync_arr[1].$sync_arr[2],$this->recnum,'comment','page',$notice);

        $TMPL['oneline_num'] = $row['oneline'];
        $TMPL['oneline_button'] = $row['oneline']?$this->getHtml('oneline_button'):'';

        $my_menu = $this->getHtml('my_menu');
        $btn_showHideMenu = $this->getHtml('btn_showHideMenu');

        // 타인 채팅 삭제 메뉴 노출 여부값
        if($my['uid'] == $row['mbruid']||$my['admin']){
            $TMPL['btn_showHideMenu'] = $btn_showHideMenu;
            $TMPL['my_menu'] = $my_menu;
        }
        else{
           $TMPL['btn_showHideMenu'] = '';
           $TMPL['my_menu'] = '';
        }

         // 수정모드 버튼
        $TMPL['btn_editMod'] = $this->getHtml('btn_editMod');

        $commentRow = $this->getHtml('comment_row');

        if ($row['hidden']) {
          if ($my['uid'] != $row['mbruid'] && !$my['admin']) {
            $commentRow = $this->getHtml('comment_row_hidden');
          }
        }

        return $commentRow;
    }

     // chat 쿼리 추출
    public function getOnelineWhere($parent){
        global $s;
        $where = "site='".$s."' and parent='".$parent."'";
        return $where;
    }

    // 챗팅 history 추출 함수
    public function getOnelineLog($parent,$page,$recnum){
        global $table,$s;
        $parent = $this->db->real_escape_string($parent);
        $page = $page?$page:1;
        $recnum = $recnum?$recnum:$this->oneline_recnum;
        $_wh = $this->getOnelineWhere($parent);
        $limit=(($page-1)*$recnum).','.$recnum;
        $query = sprintf("SELECT * FROM `%s` WHERE %s ORDER BY `uid` DESC LIMIT %s", $this->onelineTable,$_wh,$limit);
        $rows = $this->getAssoc($query);
        $onelineLog ='';
        foreach($rows as $row) {
           $onelineLog .= $this->getOnelineRow($row,$page);
        }
        return $onelineLog;

    }
    // 채팅 history row 추출 함수
    public function getOnelineRow($row,$page){
        global $TMPL,$my,$g,$d,$_HS;
        include_once $g['path_module'].$this->module.'/var/var.php';

        $TMPL['oneline_content'] = $this->getPrintContent($row);
        $TMPL['oneline_user_name'] = $row[$_HS['nametype']]?$row[$_HS['nametype']]:'손님';
        $TMPL['oneline_user_pic'] = $this->getUserAvatar($row['mbruid'],'src');
        $TMPL['oneline_like_total'] = $row['likes']?$row['likes']:0;
        $TMPL['oneline_uid'] = $row['uid'];
        $TMPL['oneline_regis_time'] = getDateFormat($row['d_modify']?$row['d_modify']:$row['d_regis'],'Y.m.d H:i');
        $TMPL['oneline_regis_ago'] = getDateFormat($row['d_modify']?$row['d_modify']:$row['d_regis'],'c');
        $TMPL['oneline_getNew'] = $this->getNew($row['d_modify']?$row['d_modify']:$row['d_regis'],$d['comment']['newtime']);
        $TMPL['oneline_getHidden'] = $row['hidden']?'true':'false';
        $TMPL['oneline_page'] = $page;
        $TMPL['oneline_rows'] = $this->getOnelineLog($row['uid'],1,$this->oneline_recnum);
        $TMPL['uid'] = $row['uid'];
        $TMPL['entry_type'] = 'oneline';
        $TMPL['entry_parent'] = $row['parent'];
        $TMPL['parent'] = $row['parent'];

        $my_menu = $this->getHtml('my_menu');
        $btn_showHideMenu = $this->getHtml('btn_showHideMenu');

        // 타인 채팅 삭제 메뉴 노출 여부값
        if($my['uid'] == $row['mbruid']||$my['admin']){
            $TMPL['btn_showHideMenu'] = $btn_showHideMenu;
            $TMPL['my_menu'] = $my_menu;
        }
        else{
           $TMPL['btn_showHideMenu'] = '';
           $TMPL['my_menu'] = '';
        }

        // 수정모드 버튼
        $TMPL['btn_editMod'] = $this->getHtml('btn_editMod');
        $onelineRow = $this->getHtml('oneline_row');

        if ($row['hidden']) {
          if ($my['uid'] != $row['mbruid'] && !$my['admin']) {
            $onelineRow = $this->getHtml('oneline_row_hidden');
          }
        }

        return $onelineRow;
    }

    // User 아바타 src 추출
    public function getUserAvatar($mbruid,$type){
        global $g,$table;

        $M = getDbData($table['s_mbrdata'],'memberuid='.$mbruid,'photo');
        if($M['photo']) {

          $_array=explode('.',$M['photo']);
          $name=$_array[0];
          $ext=$_array[1];
          $size='150x150';
          $user_avatar_src=$g['s'].'/avatar/'.$name.'_'.$size.'.'.$ext;
        }
        else $user_avatar_src = $g['s'].'/files/avatar/0.svg';

        $result['src']=$user_avatar_src;

        return $result[$type];
    }

    // content 출력함수
    function getPrintContent($R){
        $content = str_replace("\"","'",$R['content']);
        return getContents($content,$R['html']);
    }

    // 지난 시간 얻기 함수
    function getJNTime($d_regis)
    {
      $dnowdate=date("Y-m-j G:i:s");// 오늘 날짜
      $ddate=getDateFormat($d_regis,'Y-m-j G:i:s');//Last-ay
      $timediffer=strtotime($dnowdate) - strtotime("$ddate GMT"); // 기준일과 오늘의 시간(초) 차이
      $dval=$timediffer+32400;
      if((60>$dval && $dval>0)||!$dval){
           $JN_time=date('s초 전',$timediffer);
      }elseif(3600>$dval&& $dval>60){
           $JN_time=date('i분 전',$timediffer);
      }elseif(86400>$dval && $dval>3600){
           $JN_time=date('G시간 전',$timediffer);
      }elseif(2592000>$dval && $dval>86400){
                     $JN_time=date('j일 전',$timediffer);
      }elseif(31104000>$dval && $dval>2592000){
           $JN_time=date('n개월 전',$timediffer);
      }else{
          $JN_time='-';
      }
      return $JN_time;
    }

    //시간비교
    function getNew($time,$term)
    {
    	if(!$time) return false;
    	$dtime = date('YmdHis',mktime(substr($time,8,2)+$term,substr($time,10,2),substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4)));
    	if ($dtime > $GLOBALS['date']['totime']) return 'rb-new';
    	else return '';
    }

    // 로그인한 사용자가 좋아요/싫어요를 했는지 여부 체크
    function getIsLiked($type,$entry,$opinion)
    {
      global $my,$table;
      $check_qry = "mbruid='".$my['uid']."' and module='".$type."' and entry='".$entry."' and opinion='".$opinion."'";
      $is_liked = getDbRows($table['s_opinion'],$check_qry);
      if ($is_liked) return 'active';
    	else return '';
    }


    // 댓글삭제 함수
    public function deleteComment($uid){
        global $table,$d,$g,$date;
        include_once $g['path_module'].$this->module.'/var/var.php';
        $R = getUidData($this->commentTable,$uid);
        $sync_arr = explode('|',$R['sync']); // parent_table|parent|parentmbr
        $parent_table = $sync_arr[0]; // 댓글 부모 테이블
        $parent_module = $sync_arr[1];
        $parent_uid = $sync_arr[2]; // 댓글 부모 PK

        $result='';

        if($R['oneline']&&$d['comment']['commentdel']){
            $result = '한줄의견이 있는 댓글은 삭제할 수 없습니다.';
        }else{
            // 부모 테이블에 업데이트
            getDbUpdate($parent_table,'comment=comment-1','uid='.$parent_uid);

            // 한줄의견 삭제
            $OCD = getDbSelect($this->onelineTable,'parent='.$uid,'uid');
            while($O=db_fetch_array($OCD)){
                getDbDelete($this->onelineTable,'uid='.$O['uid']); // 한줄의견 삭제
                getDbUpdate($parent_table,'oneline=oneline-1','uid='.$parent_uid); // 댓글의 부모 테이블 업데이트
            }

            // 평가 삭제
            if ($R['likes'] || $R['dislikes']) getDbDelete($table['s_opinion'],'entry='.$uid);

            // 자신(댓글) 삭제
            getDbDelete($this->commentTable,'uid='.$R['uid']);

            getDbUpdate($table['s_numinfo'],'comment=comment-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site']);

            if ($R['point']&&$R['mbruid'])
            {
            	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point']."','댓글삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
            	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point'],'memberuid='.$R['mbruid']);
            }

            //  연동모듈 댓글통계 반영
            getDbUpdate($table['s_mbrmonth'],'post_comment=post_comment-1',"date='".substr($R['d_regis'],0,6)."' and site=".$R['site'].' and mbruid='.$R['parentmbr']); //부모글 등록자 월별 조회수 갱신
            getDbUpdate($table['s_mbrday'],'post_comment=post_comment-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site'].' and mbruid='.$R['parentmbr']); //부모글 등록자 일별조회수 갱신
            getDbUpdate($table[$parent_module.'month'],'comment=comment-1',"date='".substr($R['d_regis'],0,6)."' and site=".$R['site'].' and data='.$parent_uid); //연동모듈 월별 조회수 갱신
            getDbUpdate($table[$parent_module.'day'],'comment=comment-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site'].' and data='.$parent_uid);  //연동모듈 일별 조회수 갱신

            $result='OK';
        }

        return $result;
    }

    // 한줄의견 삭제 함수
    public function deleteOneline($parent_uid,$uid){
        global $table,$date;
        $C = getDbData($this->commentTable,'uid='.$parent_uid,'sync');
        $sync_arr = explode('|',$C['sync']);
        $grant_table = $sync_arr[0];
        $grant_uid = $sync_arr[2];

        $R = getDbData($this->onelineTable,'uid='.$uid,'*');
        getDbDelete($this->onelineTable,'uid='.$R['uid']); // 한줄의견 삭제
        getDbUpdate($this->commentTable,'oneline=oneline-1','uid='.$parent_uid); // 댓글 테이블 업데이트
        getDbUpdate($grant_table,'oneline=oneline-1','uid='.$grant_uid); // 댓글의 부모 테이블 업데이트

        getDbUpdate($table['s_numinfo'],'oneline=oneline-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site']);

        // 평가 삭제
        if ($R['likes'] || $R['dislikes']) getDbDelete($table['s_opinion'],'entry='.$uid);

        if ($R['point']&&$R['mbruid'])
        {
        	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point']."','한줄의견삭제(".getStrCut(str_replace('&amp;',' ',strip_tags($R['content'])),15,'').")환원','".$date['totime']."'");
        	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point'],'memberuid='.$R['mbruid']);
        }

        $result = 'OK';

        return $result;

    }

    // 포스트 파일 삭제 함수
    public function deletePostUpload($upload){

        global $table;

        $UPFILES = getArrayString($upload);

        foreach($UPFILES['data'] as $_val)
        {
            $U = getUidData($this->uploadTable,$_val);
            if ($U['uid']) $this->deleteFile($U);
        }
    }

    // 파일 삭제 함수
    public function deleteFile($row){
        global $table;

        if($row['type']==2){
            unlink('.'.$row['folder'].'/'.$row['tmpname']);
            unlink('.'.$row['folder'].'/'.$row['thumbname']);
        }else if($row['type']==5){
            unlink('.'.$row['folder'].'/'.$row['name']);
        }
        // DB 삭제
        getDbDelete($this->uploadTable,'uid='.$row['uid']);
    }

    // 신고 함수   : type - comment, oneline
    public function regisReport($R,$type){
        global $table,$date,$my;
        $is_reported_qry = "type='".$type."' and by_mbruid='".$my['uid']."' and entry='".$R['uid']."'";
        $is_reported = getDbRows($this->reportTable,$is_reported_qry,'uid');
        if($is_reported) return '해당 글은 이미 신고 처리되었습니다. ';
        else{
            $QKEY = "bbs,by_mbruid,type,entry,message,d_regis";
            $QVAL = "'".$R['bbs']."','".$my['uid']."','post','".$R['uid']."','$message','".$date['totime']."'";
            getDbInsert($this->reportTable,$QKEY,$QVAL);
            return '해당 글이 신고처리되었습니다. ';
        }

    }

}

?>
