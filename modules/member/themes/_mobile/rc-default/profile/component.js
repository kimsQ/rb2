var sheet_member_profile = $('#sheet-member-profile');

sheet_member_profile.on('show.rc.sheet', function (event) {
  var button = $(event.relatedTarget);
  var sheet =  $(this);
  var nic = button.attr('data-nic');
  var mbruid = button.attr('data-mbruid');
  var avatar = button.attr('data-avatar');
  sheet.find('[data-role="avatar"]').attr('src',avatar);
  sheet.find('[data-toggle="follow"]').attr('data-mbruid',mbruid);
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileDataSimple',{
         mbruid : mbruid
    },function(response){
      var result = $.parseJSON(response);
      var id=result.id;
      var nic=result.nic;
      var bio=result.bio;
      var num_follower=result.num_follower;
      var num_post=result.num_post;
      var num_list=result.num_list;
      var _avatar=result.avatar;
      var isFollowing=result.isFollowing;
      sheet.find('[data-role="bio"]').text(bio);
      sheet.find('[data-role="num_follower"]').text(num_follower);
      sheet.find('[data-role="num_post"]').text(num_post);
      sheet.find('[data-role="num_list"]').text(num_list);
      if (!avatar) sheet.find('[data-role="avatar"]').attr('src',_avatar);
      sheet.find('[data-toggle="profile"]').attr('data-url','/@'+id).attr('data-mbruid',mbruid).attr('data-nic',nic);

      if (memberid==id) {
        sheet.find('[data-role="follower"]').addClass('d-none');
        sheet.find('[data-role="ismy"]').text('(나)');
      } else {
        sheet.find('[data-role="follower"]').removeClass('d-none');
        sheet.find('[data-role="ismy"]').text('');
      }

      if (isFollowing) {
        sheet.find('[data-role="isfollowing"]').removeClass('d-none');
        sheet.find('[data-toggle="follow"]').addClass('d-none');
      } else {
        sheet.find('[data-role="isfollowing"]').addClass('d-none');
        sheet.find('[data-toggle="follow"]').removeClass('d-none');
      }

    });
  }, 100);

})

sheet_member_profile.on('hidden.rc.sheet', function (event) {
  var sheet =  $(this);
  sheet.find('[data-role="nic"]').text('');
  sheet.find('[data-role="avatar"]').removeAttr('src');
  sheet.find('[data-role="bio"]').text('');
  sheet.find('[data-toggle="profile"]').removeAttr('data-url').removeAttr('data-mbruid').removeAttr('data-nic');
})


$(document).on('click','[data-toggle="profile"]',function(){
  var button = $(this);
  var mbruid = button.attr('data-mbruid');
  var target = button.attr('data-target');
  var url = button.attr('data-url');
  var nic = button.attr('data-nic');
  var modal_id = 'modal-member-profile-'+mbruid;
  var modal = $('#'+modal_id);
  var zindex = button.attr('data-zindex');
  var delay = 10;

  if (!modal.length) {
    var _modal = $(target).clone().appendTo('[data-role="profile-wapper"]');
    _modal.attr('id',modal_id);
    modal = _modal;
  }
  if (button.attr('data-change')){
    history.back();
    delay = 250;
  }

  modal.css('z-index','');
  if (zindex) modal.css('z-index',zindex);

  setTimeout(function(){
    modal.attr('data-mbruid',mbruid);
    modal.find('.bar-header-secondary .nav-inline').empty();
    modal.find('.bar').css('background-color','');
    modal.modal({
      title: nic,
      url : url
    });
    modal.find('.content').loader({ position: 'inside' });
    getPofileView(modal,mbruid)
  }, delay);
});

$(document).on('click','[data-toggle="follow"]',function(){
  var button = $(this);
  var mbruid = button.attr('data-mbruid');
  var url = '/?r='+raccount+'&m=member&a=profile_follow&mbruid='+mbruid;
  if (memberid) {
    button.toggleClass('active');
    getIframeForAction('');
    frames.__iframe_for_action__.location.href = url;
  } else {
    var title = button.attr('data-title')
    var subtext = button.attr('data-subtext')
    popup_login_guide.find('[data-role="title"]').text(title);
    popup_login_guide.find('[data-role="subtext"]').text(subtext);
    popup_login_guide.popup('show');
  }
});

$(document).on('shown.rc.modal', '[id*="modal-member-profile"]', function (event) {
  $('.modal.miniplayer').addClass('no-bartab');
});
$(document).on('hidden.rc.modal', '[id*="modal-member-profile"]', function (event) {
  $('.modal.miniplayer').removeClass('no-bartab');
});
