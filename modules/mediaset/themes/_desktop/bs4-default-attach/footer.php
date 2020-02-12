<?php include $g['dir_attach_theme'].'/modals.php'; // 모달 페이지 인클루드 ?>

<?php getImport('jquery-form','jquery.form.min','4.2.2','js'); ?>

<script>
var inputId='attach-file-input'; // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
var attach_file_saveDir = '<?php echo $g['path_file'].$parent_module?>/';// 파일 업로드 폴더
var attach_module_theme = '<?php echo $attach_module_theme?>';// attach 모듈 테마
var editor_type = '<?php echo $editor_type ?>'; // 에디터 타입 : html, markdown
var uploadElement = $('#attach-files');

$(document).ready(function() {

 var uploadObj = uploadElement.RbUploadFile({
   <?php if ($d['theme']['allowedTypes']): ?>
   allowedTypes:"<?php echo $d['theme']['allowedTypes'] ?>",// 업로드 가능한 파일 확장자. 여기에 명시하지 않으면 파일 확장자 필터링하지 않음.
   <?php endif; ?>
    fileName: "files", // <input type="file" name=""> 의 name 값 --> php 에서 파일처리할 때 사용됨.
    multiple: <?php echo $d['theme']['multiple']?'true':'false' ?>, // 멀티업로드를 할 경우 true 로 해준다.
    dragDrop:true,
    uploadStr:"<i class='fa fa-folder-o fa-fw'></i> 파일찾기", // 파일첨부 버튼
    maxFileCount: <?php echo $d['mediaset']['maxnum_file'] ?>, // 1회 첨부파일 갯수
    maxFileSize: <?php echo $d['mediaset']['maxsize_file'] ?>, // 1회 첨부파일 용량
    inputId:inputId, // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
    formData: {"saveDir":attach_file_saveDir,"theme":attach_module_theme,"editor":editor_type}, // 추가 데이타 세팅

    onSubmit:function(files){
      console.log('모든 파일이 업로드가 시작되었습니다.')
      uploadElement.isLoading({
        text: "<i class='fa fa-spinner fa-spin'></i> 업로드중...",
        position: 'overlay'
      });
    },
    onSuccess:function(files,data,xhr,pd){
      console.log('파일이 업로드 되었습니다.');
      uploadElement.isLoading("hide");

      // 포스트 글쓰기 페이지 저장버튼 출력
      $('[data-role="postsubmit"]').removeClass('d-none');
      $('[data-role="library"]').addClass('d-none');
		},
    afterUploadAll:function(obj) {
      console.log('전체 업로드 완료')
      uploadElement.isLoading("hide");
    }
 });

  // main.js 기본값 세팅
  var attach_settings={
    module : 'mediaset',
    theme : attach_module_theme,
    handler_photo : '<?php echo $attach_handler_photo?>',
    handler_file : '<?php echo $attach_handler_file?>',
    handler_getModalList : '<?php echo $attach_handler_getModalList?>',
    listModal : '#modal-attach'
  }
  uploadElement.RbAttachTheme(attach_settings);

});

$('[data-attach-act="insert"]').tooltip({
  trigger: 'hover',
  title : '본문삽입'
});

$('body').on('click','[data-attach-act="insert"]',function(){
   $(this).attr('data-original-title', '본문삽입 되었습니다.')
   $(this).tooltip('show');
   $(this).attr('data-original-title', '본문삽입')
});

$('#modal-attach-file-meta').on('shown.bs.modal', function (event) {
  var modal = $(this)
  modal.find('[data-role="filename"]').focus()
})


$('#modal-attach-photo-tag').on('show.bs.modal', function (event) {
  var modal = $(this)
  var src = modal.find('[data-role="image-marker-area"] img').attr('src');
  var point = {};
  var parnet_uid = $('[name="uid"]').val();

  modal.find('[data-role="test"]').text('');

  //이미지가 로드 되었을때,
  modal.find('[data-role="image-marker-area"] img').one('load',function() {
    $.getJSON(rooturl+'/?r='+raccount+'&m=mediaset&a=get_attachTag&src='+src,{
      format: "json"
     },function(data){
       var tag = data.tag;
       if (tag) {
         var point = JSON.parse(tag);
       } else {
         var point = {};
       }

       if (point) {
         for(var i in point){ //포인터 출력
           var goods_uid = point[i].g;
           modal.find('[data-role="image-marker-area"]').append('<a href="#" data-toggle="tooltip" tabindex="0" class="fa fa-plus" id="' + i + '" style="left:' + point[i].x + '%;top:' +  point[i].y + '%" data-goods='+point[i].g+'></a>');

           $.getJSON(rooturl+'/?r='+raccount+'&m=shop&a=get_goodsData&uid='+goods_uid+'&featured_size=140x140', {
               format: "json"
           },
           function(data) {
             var uid = data.uid;
             var name = data.name;
             var price=data.price;
             var featured_img=data.featured_img;
             modal.find('a[data-goods="'+uid+'"]').attr('data-original-title',name).attr('data-name',name).attr('data-price',price).attr('data-price',price);
             modal.find('[data-toggle="tooltip"]').tooltip();
           });

         }
       }

       modal.find('[data-role="image-marker-area"]').off().on('click', 'a', function(e) {
         e.preventDefault();
         var id = $(this).attr('id');
         var goods_uid = $(this).attr('data-goods');
         var name = $(this).attr('data-name');
         var price = $(this).attr('data-price');

         modal.find('[data-role="image-marker-area"] a').removeClass('active');
         $(this).addClass('active');
         modal.find('[name="goods"]').val(goods_uid)
         modal.find('[data-role="comment"] textarea').val(name).attr('data-id', id);
         modal.find('[data-role="comment"]').show();
         modal.find('[data-role="test"]').text(JSON.stringify(point));
         modal.find('[data-toggle="tooltip"]').tooltip('hide');
       });


       modal.find('[data-role="image-marker-area"] img').on('click', function(e) {
         var position = getPosition(e, 1);
         var x = position.x;
         var y = position.y;
         var id = randomId();
         modal.find('[data-role="image-marker-area"] a').removeClass('active');
         modal.find('[data-role="image-marker-area"]').append('<a href="#" tabindex="0" data-toggle="tooltip" title="" class="fa fa-plus active" id="' + id + '" style="left:' + x + '%;top:' + y + '%"></a>');
         point[id] = {
           'x': x,
           'y': y,
           'g': ''
         };
         // $(this).removeClass('edit');
         modal.find('[data-role="comment"]').show();
         modal.find('[name="goods"]').val('').focus();
         modal.find('[data-role="comment"] textarea').val('').attr('data-id', id);
         modal.find('[data-role="test"]').text(JSON.stringify(point));
       });



       // $('[data-role="image-marker-area"]').on('click', 'a', function(e) {
       //   e.preventDefault();
       //   $('[data-toggle="popover"]').popover('hide');
       //   $(this).popover('show');
       // });

       modal.find('#imagetag-cancel').off().on('click', function(e) {
         modal.find('[data-role="comment"]').hide();
         var i = modal.find('[data-role="comment"] textarea').data('id');
         if (point[i].t == 'none')
           $('#' + i).remove();
         modal.find('[data-role="image-marker-area"] a').removeClass('active');
         modal.find('[data-role="test"]').text(JSON.stringify(point));
       });

       modal.find('[data-attach-act="saveTag"]').on('click', function(e) {
         $('[data-role="image-marker-area"] a').removeClass('active');
         var uid =  $(this).attr('data-id');
         var i = modal.find('[data-role="comment"] textarea').data('id');
         var goods_uid = modal.find('[name="goods"]').val();
         point[i].g = goods_uid;
         $('#' + i).attr('data-goods',goods_uid);
         modal.find('[data-role="comment"]').hide();
         modal.find('[data-role="image-marker-area"] a').removeClass('active');
         modal.find('[data-role="tag"]').val(JSON.stringify(point));
         modal.find('[data-role="test"]').text(JSON.stringify(point));

         //DB저장하기
         $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=edit',{
           uid : uid,
           act : 'editTag',
           tag : JSON.stringify(point)
          },function(response,status){
             if(status=='success'){
               var result = $.parseJSON(response);
             } else {

             }
           });

       });

       modal.find('#imagetag-delete').off().on('click', function(e) {
         modal.find('[data-role="comment"]').hide();
         var i = modal.find('[data-role="comment"] textarea').attr('data-id');
         modal.find('#' + i).remove();
         modal.find('[data-role="comment"] textarea').attr('data-id','');
         delete point[i];
         modal.find('[data-role="test"]').text(JSON.stringify(point));
       });









    });
  });

  //연결된 상품 불러기
  $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_postAttachGoods',{
    markup_file: 'attach_goods_dropdown_item',
    uid : parnet_uid,
    featured_size : '70x52'
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var list=result.list;
        $('[data-role="attach-goods"]').html(list);
      } else {
        alert(status);
      }
  });


})

$('#modal-attach-photo-tag').on('hidden.bs.modal', function (event) {
  var modal = $(this)
  modal.find('[data-role="image"] img').attr('src','');
  modal.find('[data-role="image-marker-area"] a').remove()
})


</script>
