function getPostMore(uid) {

  var wrapper = popup_post_postMore;
  wrapper.find('[data-role="list"]').html('<div data-role="loader"><div class="d-flex justify-content-center align-items-center text-muted" style="height:30vh"><div class="spinner-border mr-2" role="status"></div></div></div>');

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postMenu',{
    uid: uid
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var list=result.list;
        var owner=result.owner;
        var likes=result.likes;
        var subject = result.subject.replace(/&quot;/g, '"');
        var featured=result.featured;
        var review=result.review;
        var link=result.link;
        var cid=result.cid;

        wrapper.find('[data-role="list"]').html(list)

        wrapper.find('[data-toggle="kakaoTalkSend"],[data-toggle="linkShare"]').attr('data-subject',subject).attr('data-review',review).attr('data-featured',featured).attr('data-link',link).attr('data-entry',cid);

        if (owner) {
          wrapper.find('[data-role="list"] [data-toggle="saved"]').closest('.table-view-cell').remove();
          wrapper.find('[data-role="list"] [data-toggle="report"]').closest('.table-view-cell').remove();
        }
        if (!likes) {
          wrapper.find('[data-role="list"] [data-toggle="opinionList"]').closest('.table-view-cell').remove();
        }

      } else {
        alert(status);
      }
  });

}

popup_post_postMore.on('click','[data-toggle="listAdd"]',function(){
  var button = $(this);
  var uid = popup_post_postMore.attr('data-uid');
  history.back();
  setTimeout(function(){
    if (memberid) {
      sheet_post_listadd.attr('data-uid',uid).css('top','20vh');
      sheet_post_listadd.sheet();
    } else {
      var title = button.attr('data-title')
      var subtext = button.attr('data-subtext')
      popup_login_guide.find('[data-role="title"]').text(title);
      popup_login_guide.find('[data-role="subtext"]').text(subtext);
      popup_login_guide.popup('show');
    }
  }, 200);
});

popup_post_postMore.on('click','[data-toggle="report"]',function(){
  var button = $(this);
  var uid = popup_post_postMore.attr('data-uid');
  history.back();
  setTimeout(function(){
    if (memberid) {
      popup_post_report.attr('data-uid',uid);
      popup_post_report.popup();
    } else {
      var title = button.attr('data-title')
      var subtext = button.attr('data-subtext')
      popup_login_guide.find('[data-role="title"]').text(title);
      popup_login_guide.find('[data-role="subtext"]').text(subtext);
      popup_login_guide.popup('show');
    }
  }, 200);
});

popup_post_postMore.on('click','[data-toggle="saved"]',function(){
  var button = $(this);
  var uid = popup_post_postMore.attr('data-uid');
  history.back();
  setTimeout(function(){
    if (memberid) {
      setTimeout(function(){
        $.post(rooturl+'/?r='+raccount+'&m=post&a=update_saved',{
          uid : uid
          },function(response,status){
            if(status=='success'){
              $.notify({message: '나중에 볼 동영상에 추가되었습니다.'},{type: 'default'});
            } else {
              alert(status);
            }
        });
      }, 100);
    } else {
      var title = button.attr('data-title')
      var subtext = button.attr('data-subtext')
      popup_login_guide.find('[data-role="title"]').text(title);
      popup_login_guide.find('[data-role="subtext"]').text(subtext);
      popup_login_guide.popup('show');
    }
  }, 200);
});


popup_post_postMore.on('click','[data-toggle="postedit"]',function(){
  var button = $(this);
  var uid = button.attr('data-uid');
  var title = button.attr('data-title');
  var url = button.attr('data-url');
  modal_post_write.attr('data-uid',uid);
  history.back();
  setTimeout(function(){
    modal_post_write.modal({
      title : title,
      url : url
    })
  }, 200);
});

popup_post_postMore.on('click','[data-toggle="analytics"]',function(){
  var button = $(this);
  var uid = button.attr('data-uid');
  modal_post_analytics.attr('data-uid',uid);
  history.back();
  setTimeout(function(){
    modal_post_analytics.modal()
  }, 200);
});

popup_post_postMore.on('click','[data-toggle="opinionList"]',function(){
  var button = $(this);
  var uid = popup_post_postMore.attr('data-uid');
  modal_post_opinion.attr('data-uid',uid);
  history.back();
  setTimeout(function(){
    modal_post_opinion.modal()
  }, 200);
});

popup_post_postMore.on('click','[data-toggle="postdel"]',function(){
  var button = $(this);
  var uid = popup_post_postMore.attr('data-uid');
  var title = button.attr('data-title');
  var type = button.attr('data-type');
  popup_post_delConfirm.attr('data-uid',uid);
  history.back();
  setTimeout(function(){
    popup_post_delConfirm.popup({
      title : title
    })
  }, 200);
});

// 카카오톡 링크 공유
popup_post_postMore.on('click','[data-toggle="kakaoTalkSend"]',function(){
  var button = $(this);
  var subject = button.attr('data-subject');
  var review = button.attr('data-review');
  var featured = button.attr('data-featured');
  var link = button.attr('data-link');

  history.back();

  kakaoTalkSend({
    subject : subject,
    review : review,
    featured : featured,
    link : link
  })

});
