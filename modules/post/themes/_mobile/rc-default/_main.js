function setPostView(settings) {

  var format=settings.format;
  var uid=settings.uid;
  var list=settings.list;
  var featured=settings.featured;
  var provider = settings.provider;
  var videoId = settings.videoId;
  var url = settings.url;
  var ctheme = '_mobile/rc-default';

  var header_height = $('.bar-nav').outerHeight();
  var embed_height = $('.embed-responsive').outerHeight();
  var height = header_height + embed_height;
  var window_height = $(window).height();
  var content_height = window_height - height;


	if (format=='video') {

    $('.embed-responsive').css('background-image','url('+featured+')')
    $('.content').css('padding-top',height+'px')

		$('.bar-standard').css('height',embed_height+'px')
		$('.bar-standard .embed-responsive').css('height',embed_height+'px')
		$('.modia-loader').loader();

		if (provider=='YouTube') {

			var player;
			player = new YT.Player('player', {
				height: '360',
				width: '640',
				videoId: videoId,
				events: {
					// 'onReady': onPlayerReady
				}
			});

			function onPlayerReady(event) {
				event.target.playVideo();
			}

			setTimeout(function(){
				$('.modia-loader').loader('hide');
			}, 1000);

		}
	} else {
		setTimeout(function(){
			$('[data-role="box"]').loader({ position: 'inside' });
		}, 50);
	}

  $('oembed').attr('url',linkurl);

  if (!dis_comment) {

    // 댓글 출력 함수 정의
    var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
      $('[data-role="comment"]').Rb_comment({
       moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
       parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
       parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
       theme_name : theme, // 댓글 테마
       containerClass :'', // 본 엘리먼트(#commentting-container)에 추가되는 class
       recnum: 5, // 출력갯수
       commentPlaceHolder : '공개 댓글 추가...',
       noMoreCommentMsg : '댓글 없음 ',
       commentLength : 200, // 댓글 입력 글자 수 제한
       toolbar : ['imageUpload'] // 툴바 항목
      });
    }
    // 댓글 출력 함수 실행
    var p_module = 'post';
    var p_table = 'rb_post_data';

    get_Rb_Comment(p_module,p_table,uid,ctheme);

    // 보기 에서 댓글이 등록된 이후에 ..
    $('[data-role="comment"]').on('saved.rb.comment',function(){
      window.history.back(); //댓글작성 sheet 내림
      var list_item = $(document).find('[data-role="item"] [data-uid="'+uid+'"]')
      //var showComment_Ele_1 = page_allcomment.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
      var showComment_Ele_2 = $('[data-role="total_comment"]'); // 댓글 숫자 출력 element
      var showComment_ListEle = list_item.find('[data-role="comment_'+uid+'"]'); // 댓글 숫자 출력 element

      $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postData',{
           uid : uid
        },function(response){
           var result = $.parseJSON(response);
           var total_comment=result.comment;
           //$.notify({message: '댓글이 등록 되었습니다.'},{type: 'default'});
           //showComment_Ele_1.text(total_comment); // 모달 상단 최종 댓글수량 합계 업데이트
           showComment_Ele_2.text(total_comment); // 모달 상단 최종 댓글수량 합계 업데이트
           showComment_ListEle.text(total_comment); // 포스트 목록 해당 항목의 최종 댓글수량 합계 업데이트
      });
    });

    // 포스트 보기 모달에서 한줄의견이 등록된 이후에..
    $('[data-role="comment"]').on('saved.rb.oneline',function(){
      window.history.back(); //댓글작성 sheet 내림
      var uid = $('[name="uid"]').val()
      var list_item = $('[data-role="list"]').find('#item-'+uid)
      //var showComment_Ele_1 = page_allcomment.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
      var showComment_Ele_2 = $('[data-role="total_comment"]'); // 댓글 숫자 출력 element
      var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
      $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postData',{
           uid : uid
        },function(response){
           var result = $.parseJSON(response);
           var total_comment=result.total_comment;
           $.notify({message: '답글이 등록 되었습니다.'},{type: 'default'});
           //showComment_Ele_1.text(total_comment); // 최종 댓글수량 합계 업데이트
           showComment_Ele_2.text(total_comment); // 최종 댓글수량 합계 업데이트
           showComment_ListEle.text(total_comment); // 포스트 목록 해당 항목의 최종 댓글수량 합계 업데이트
      });
    });

    // 댓글이 수정된 후에..
    $('[data-role="comment"]').on('edited.rb.comment',function(){
      setTimeout(function(){
        history.back()
        $.notify({message: '댓글이 수정 되었습니다.'},{type: 'default'});
      }, 300);
    })

    // 한줄의견이 수정 후에
    $('[data-role="comment"]').on('edited.rb.oneline',function(){
      setTimeout(function(){
        history.back()
        $.notify({message: '답글이 수정 되었습니다.'},{type: 'default'});
      }, 300);
    })

  } else {
    $('[data-role="btn_comment"]').hide();  //댓글 바로가기 버튼 숨김
    $('[data-role="comment"]').html('<div class="text-muted pb-3 text-xs-center">댓글이 사용 중지되었습니다.</div>')
  }


};
