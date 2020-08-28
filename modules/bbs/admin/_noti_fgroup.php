<div class="form-group row">
   <label class="col-lg-2 col-form-label text-lg-right">게시물 등록</label>
   <div class="col-lg-10 col-xl-9 pt-1">
     <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="noti_newpost" name="noti_newpost" value="1" <?php if($d['bbs']['noti_newpost']):?> checked<?php endif?>>
      <label class="custom-control-label small text-muted" for="noti_newpost">신규 게시물 등록시, 게시판 관리자에게 알림발송</label>
    </div>
   </div>
 </div>

 <div class="form-group row">
   <label class="col-lg-2 col-form-label text-lg-right">좋아요 등록</label>
   <div class="col-lg-10 col-xl-9 pt-1">
     <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="noti_opinion" name="noti_opinion" value="1" <?php if($d['bbs']['noti_opinion']):?> checked<?php endif?>>
      <label class="custom-control-label small text-muted" for="noti_opinion">게시물에 좋아요(싫어요) 등록(취소)시, 게시물 등록회원에게 알림발송</label>
    </div>
   </div>
 </div>

 <div class="form-group row">
   <label class="col-lg-2 col-form-label text-lg-right">게시물 신고</label>
   <div class="col-lg-10 col-xl-9 pt-2">
     <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="noti_report" name="noti_report" value="1" <?php if($d['bbs']['noti_report']):?> checked<?php endif?>>
      <label class="custom-control-label small text-muted" for="noti_report">게시물 신고시, 게시판 관리자에게 알림발송</label>
    </div>
   </div>
 </div>

 <div class="form-group row d-none">
   <label class="col-lg-2 col-form-label text-lg-right">회원 언급</label>
   <div class="col-lg-10 col-xl-9 pt-1">
     <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="noti_mention" name="noti_mention" value="1" <?php if($d['bbs']['noti_mention']):?> checked<?php endif?>>
      <label class="custom-control-label small text-muted" for="noti_mention">게시물에 언급시, 언급된 회원(들)에게 알림발송</label>
    </div>
   </div>
 </div>
