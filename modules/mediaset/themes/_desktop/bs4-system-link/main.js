// 업로드 리스트 showhide 값 reset 함수
var updateShowHide=function(uid,showhide){
      if(showhide=='show'){
            $('[data-role="attachList-menu-showhide-'+uid+'"]').attr('data-content','hide'); // data-content 값 수정
            $('[data-role="attachList-menu-showhide-'+uid+'"]').text('숨기기'); // 메뉴명 변경
            $('[data-role="attachList-label-hidden-'+uid+'"]').addClass('d-none'); // 숨김 라벨 숨기기
            console.log($('[data-role="attachList-label-hidden-'+uid+'"]'));
      }else{
            $('[data-role="attachList-menu-showhide-'+uid+'"]').attr('data-content','show'); // data-content 값 수정
            $('[data-role="attachList-menu-showhide-'+uid+'"]').text('보이기'); // 메뉴명 변경
            $('[data-role="attachList-label-hidden-'+uid+'"]').removeClass('d-none'); // 숨김 라벨 노출
      }
}

$('body').on('click','[data-link-act]',function(e){
      e.preventDefault();
      var act=$(this).attr('data-link-act');
      var uid=$(this).attr('data-id');
      var type=$(this).data('type'); // file or photo
      var module =  'mediaset';
      if(act=='edit'){
        // data 값 세팅
        var modal=$(this).data('target');
        var filename=$(this).attr('data-filename'); // data-로 하면 변경된 값 적용 안됨
        var fileext=$(this).data('fileext');
        var caption=$(this).attr('data-caption'); // data- 로 하면 변경된 값 적용 안됨
        var img_thumb=$(this).data('src');// 미리보기 이미지
        var img_origin=$(this).data('origin');// 원본 이미지

        // data 값 모달에 적용
        $(modal).find('[data-role="filename"]').val(filename);
        $(modal).find('[data-role="fileext"]').text(fileext);
        $(modal).find('[data-role="filecaption"]').val(caption);
        $(modal).find('[data-role="eventHandler"]').attr('data-id',uid); // save, cancel 엘리먼트 data-id="" 값에 uid 값 적용
        $(modal).find('[data-role="eventHandler"]').attr('data-type',type); // save, cancel 엘리먼트 data-type="" 값에 type 값 적용
        if(type=='photo'){
           $(modal).find('[data-role="img-preview"]').attr('src',img_thumb); // 미리보기 이미지 src 적용
           $(modal).find('[data-role="img-preview"]').attr('data-origin',img_origin); // 원본 이미지 src 적용
         } else if(type=='video'){
           $(modal).find('[data-role="img-preview"]').html('<i class="fa fa-file-video-o fa-4x"></i>'); // 타입별 아이콘 적용
         } else if(type=='audio'){
           $(modal).find('[data-role="img-preview"]').html('<i class="fa fa-file-audio-o fa-4x"></i>'); // 타입별 아이콘 적용
         } else {
           $(modal).find('[data-role="img-preview"]').html('<i class="fa fa-floppy-o fa-4x"></i>'); // 타입별 아이콘 적용
         }

      }

      //액션 실행
      if(act=='delete'){
           // 삭제하는 리스트가 대표 이미지인 경우 write.php input 값에 적용
           var is_featured=$(this).attr('data-featured');
           if(is_featured=='1' && type=='photo'){
                  if(confirm('대표이미지를 삭제하시겠습니까? ')){
                        $('input[name="featured_img"]').val('');
                  }else{
                       return false;
                  }
           }
           $.post(rooturl+'/?r='+raccount+'&m='+module+'&a=delete',{
              uid : uid
            },function(response){
                 var previewUl_default=$('[data-role="attach-preview-link"]'); // 파일 리스트 엘리먼트 class
                 var previewUl_modal=$('[data-role="modal-attach-preview-link"]'); // 파일 리스트 엘리먼트 class
                 var delEl_default=$(previewUl_default).find('[data-id="'+uid+'"]'); // 삭제 이벤트 진행된 엘리먼트
                 var delEl_modal=$(previewUl_modal).find('[data-id="'+uid+'"]'); // 삭제 이벤트 진행된 엘리먼트
                 delEl_default.remove();// 삭제 이벤트 진행시 해당 li 엘리먼트 remove
                 delEl_modal.remove();// 삭제 이벤트 진행시 해당 li 엘리먼트 remove
           });
      }else if(act=='showhide'){
           var showhide=$(this).attr('data-content'); // data('content') 로 할 경우, ajax 로 변경된 값이 인식되지 않는다.
           $.post(rooturl+'/?r='+raccount+'&m='+module+'&a=edit',{
              act : act,
              uid : uid,
              showhide : showhide
            },function(response){
                 var result=$.parseJSON(response);
                 if(!result.error){
                       updateShowHide(uid,showhide);
                 }
           });
      }else if(act=='save'){ // 정보수정 저장
            var modal=$(this).data('target');
            var filename=$(modal).find('[data-role="filename"]').val(); // 입력된 파일명
            var filetype=$(modal).find('[data-role="eventHandler"]').attr('data-type'); // photo or file
            var fileext=$(modal).find('[data-role="fileext"]').text(); // 입력된 파일 확장자명
            var filecaption=$(modal).find('[data-role="filecaption"]').val(); // 입력된 캡션명
            var filesrc=$(modal).find('[data-role="img-preview"]').attr('data-origin'); // 원본 이미지 소스

            $.post(rooturl+'/?r='+raccount+'&m='+module+'&a=edit',{
              act : act,
              uid : uid,
              filename : filename,
              filetype : filetype,
              fileext : fileext,
              filecaption : filecaption,
              filesrc : filesrc
            },function(response){
                 var result=$.parseJSON(response);
                 if(!result.error){
                       var new_filename=result.filename;
                       var new_filecaption=result.filecaption;
                       var new_fileext=result.fileext;
                       var new_filetype=result.filetype;
                       var new_filesrc=result.filesrc;

                       // 리스트 값 수정
                       $('[data-role="attachList-menu-edit-'+uid+'"]').attr('data-filename',new_filename); // 파일명 수정
                       $('[data-role="attachList-menu-edit-'+uid+'"]').attr('data-caption',new_filecaption); // 'edit' 메뉴 캡션 업데이트
                       $('[data-role="attachList-menu-insert-'+uid+'"]').attr('data-caption',new_filecaption); // 'insert' 메뉴 캡션내용 수정
                       $('[data-role="attachList-list-name-'+uid+'"]').text(new_filename+'.'+new_fileext); // 리스트 name 수정
                       $('[data-role="attachList-list-name-'+uid+'"]').attr('data-caption',new_filecaption); // 리스트에도 캡션 업데이트

                       // 모달 닫기
                       $(modal).modal('hide');
                       $(modal).find('[data-role="filename"]').val(''); // 입력된 파일명 초기화
                       $(modal).find('[data-role="fileext"]').text(''); // 입력된 파일 확장자명 초기화
                       $(modal).find('[data-role="filecaption"]').val(''); // 입력된 캡션명 초기화
                 }
           });
       }else if(act=='featured-img'){ // 대표이미지 설정
            // write.php 페이지 <input name="featured_img" value > 값에 적용
            $('input[name="featured_img"]').val(uid);



            // 대표 이미지 라벨 업데이트
            $('[data-role="attachList-label-featured"]').each(function(){
                $(this).addClass('d-none');
                // 삭제 메뉴에 대표이미지 표시 지우기
                $('[data-link-act="delete"]').attr('data-featured','');
                if($(this).data('id')==uid){
                    $(this).removeClass('d-none');
                    // 삭제 메뉴에 대표이미지 표시
                    $('[data-role="attachList-menu-delete-'+uid+'"]').attr('data-featured',1);
                }
            });
       }else if(act=='insert'){
          
              var src=$(this).data('origin');
              var type=$(this).attr('data-type');
              var caption=$(this).attr('data-caption');
              var dn_url = rooturl+'/'+raccount+'/download/'+uid;
              var url = $(this).attr('data-url')
              var html = '<figure class="media"><oembed url="'+url+'"></oembed></figure>'
              InserHTMLtoEditor(html)

              var showhide= 'hide'; // 숨김처리
              $.post(rooturl+'/?r='+raccount+'&m='+module+'&a=edit',{
                 act : act,
                 uid : uid,
                 showhide : showhide
               },function(response){
                    var result=$.parseJSON(response);
                    if(!result.error){
                          updateShowHide(uid,showhide);
                    }
              });

       }
});
