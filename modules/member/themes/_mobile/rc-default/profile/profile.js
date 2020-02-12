// RGB 코드 헥사코드 변환
function RGBToHex(rgb) {
  let sep = rgb.indexOf(",") > -1 ? "," : " ";
  rgb = rgb.substr(4).split(")")[0].split(sep);
  let r = (+rgb[0]).toString(16),
      g = (+rgb[1]).toString(16),
      b = (+rgb[2]).toString(16);
  if (r.length == 1)
    r = "0" + r;
  if (g.length == 1)
    g = "0" + g;
  if (b.length == 1)
    b = "0" + b;
  return "#" + r + g + b;
}

// 배경밝기에 따라 반전된 폰트 칼라 적용
function convertColor(hex) {
	hex = hex.replace('#', '');
	r = parseInt(hex.substring(0, 2), 16);
	g = parseInt(hex.substring(2, 4), 16);
	b = parseInt(hex.substring(4, 6), 16);
	var o = Math.round(((parseInt(r) * 299) + (parseInt(g) * 587) + (parseInt(b) * 114)) / 1000);
	if (o > 125) {
		result = true;
	} else {
		result = false;
	}
	return result;
}

function getPofileView(modal,mbruid) {
  $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileData',{
     mbruid : mbruid,
     type : 'modal'
  },function(response){
   var result = $.parseJSON(response);
   var profile=result.profile;
   var nic=result.nic;
   modal.find('[data-role="title"]').text(nic);
   modal.find('.content').html(profile);

   modal.find('[data-role="cover"]').load(function(){
     var colorThief = new ColorThief();
     var coverImage = modal.find('[data-role="cover"]')[0];
     var cover_rgb =  colorThief.getColor(coverImage);
     modal.find('.bar').css('background-color', 'rgb(' + cover_rgb + ')');
     var _cover_rgb = modal.find('.bar').css('background-color');
     var cover_hex = RGBToHex(_cover_rgb)

     if (convertColor(cover_hex)) {
       modal.find('.bar').removeClass('bar-dark').addClass('bar-light');
     } else {
       modal.find('.bar').removeClass('bar-light').addClass('bar-dark');
     }

   });

   modal.find('.content [data-plugin="timeago"]').timeago();
   var nav_control = modal.find('.profile-nav-control')
   var swiper_member_profile = new Swiper('#modal-member-profile-'+mbruid+' .swiper-container', {
     autoHeight: true,
     pagination: {
       el: '#modal-member-profile-'+mbruid+' .bar-header-secondary .nav-inline',
       clickable: true,
       autoHeight: true,
       effect : 'fade',
       spaceBetween: 30,
       slideActiveClass :'active',
       bulletClass : 'nav-link',
       bulletActiveClass : 'active' ,
       autoHeight : true,
       renderBullet: function (index, className) {
         var title;
         if (index === 0) title = '홈';
         if (index === 1) title = '동영상'
         if (index === 2) title = '재생목록'
         if (index === 3) title = '커뮤니티'
         if (index === 4) title = '채널'
         if (index === 5) title = '정보'
         return '<a class="' + className + '">'+title+'</a>';
       },
     },
     on: {
       init: function () {
         console.log('swiper 초기화');
       },
     }
   });

   swiper_member_profile.on('slideChange', function () {
     var index = swiper_member_profile.activeIndex
     nav_control.find('.nav-link').removeClass('active')
     nav_control.find('[data-index="'+index+'"]').addClass('active')
     setTimeout(function(){
       modal.find('.content').animate({scrollTop:0}, '400');
     }, 600);

     var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
     var recnum = 10;

     //무한 스크롤 환경 초기화
     modal.find('.infinitescroll-end').remove();
     modal.find('.content .content-padded [data-role="list"]').empty();
     // var content_markup = modal.find('.content').clone().wrapAll("<div/>").parent().html();
     // modal.find('.content').infinitescroll('destroy');
     // modal.append(content_markup);

     if (index==0) { // 프로필 홈

     }

     if (index==1) { // 동영상
       modal.find('[data-role="postList"] [data-role="list"]').loader({ position: 'inside' });
       $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profilePost',{
          mbruid : mbruid,
          format : 2, //video
          type : 'modal',
          recnum : recnum
       },function(response){
        var result = $.parseJSON(response);
        var postlist=result.list;
        var postnum=result.num;
        var totalPage=result.tpg;
        modal.find('[data-role="postList"] [data-role="list"]').html(postlist);

        if (postnum) {
          modal.find('[data-role="postList"] .btn').show();

          if (postnum>recnum) {
            //무한 스크롤
            modal.find('.content').infinitescroll({
              dataSource: function(helpers, callback){
                var nextPage = parseInt(currentPage)+1;
                if (totalPage>currentPage) {
                  $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profilePost',{
                      mbruid : mbruid,
                      format : 2, //video
                      type : 'modal',
                      recnum : recnum,
                      p : nextPage
                  },function(response) {
                      var result = $.parseJSON(response);
                      var error = result.error;
                      var list=result.list;
                      if(error) alert(result.error);
                      callback({ content: list });

                      currentPage++; // 현재 페이지 +1
                      console.log(currentPage+'페이지 불러옴')
                      wrapper.find('[data-plugin="timeago"]').timeago();
                      //wrapper.find('[data-plugin="markjs"]').mark(keyword); // marks.js
                      swiper_member_profile.updateAutoHeight(100);
                  });
                } else {
                  callback({ end: true });
                  console.log('더이상 불러올 페이지가 없습니다.')
                }
              },
              appendToEle : modal.find('[data-role="postList"] .content-padded'),
              percentage : 85,  // 95% 아래로 스크롤할때 다움페이지 호출
              hybrid : false  // true: 버튼형, false: 자동
            });
          }

        } else {
          modal.find('[data-role="postList"] .btn').hide();
        }

        swiper_member_profile.updateAutoHeight(100);
        modal.find('[data-role="postList"] [data-role="list"] [data-plugin="timeago"]').timeago();
      });
     }

     if (index==2) { // 리스트
       modal.find('[data-role="listList"] [data-role="list"]').loader({ position: 'inside' });
       $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileList',{
          mbruid : mbruid,
          type : 'modal'
       },function(response){
        var result = $.parseJSON(response);
        var listlist=result.list;
        var listnum=result.num;
        modal.find('[data-role="listList"] [data-role="list"]').html(listlist);
        if (listnum) modal.find('[data-role="listList"] .btn').show();
        else modal.find('[data-role="listList"] .btn').hide();
        swiper_member_profile.updateAutoHeight(100);
        modal.find('[data-role="listList"] [data-role="list"] [data-plugin="timeago"]').timeago();
      });
     }

     if (index==3) { // 커뮤니티
       modal.find('[data-role="commList"] [data-role="list"]').loader({ position: 'inside' });
       $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileComm',{
          mbruid : mbruid,
          type : 'modal'
       },function(response){
        var result = $.parseJSON(response);
        var commlist=result.list;
        var commnum=result.num;
        modal.find('[data-role="commList"] [data-role="list"]').html(commlist);
        swiper_member_profile.updateAutoHeight(100);
        modal.find('[data-role="commList"] [data-role="list"] [data-plugin="timeago"]').timeago();
      });
     }

     if (index==4) {  // 채널
       modal.find('[data-role="followList"] [data-role="list"]').loader({ position: 'inside' });
       $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileFollow',{
          mbruid : mbruid,
          type : 'modal'
       },function(response){
        var result = $.parseJSON(response);
        var followlist=result.list;
        var follownum=result.num;
        modal.find('[data-role="followList"] [data-role="list"]').html(followlist);
        swiper_member_profile.updateAutoHeight(100);
        modal.find('[data-role="followList"] [data-role="list"] [data-plugin="timeago"]').timeago();
      });
     }

   });

   nav_control.find('.nav-link').click(function(){
     var index =  $(this).data('index')
     swiper_member_profile.slideTo(index);
   });
  });

  // edgeEffect
  var wrapper_startY = 0;
  modal.find('.content').on('touchstart',function(event){
    wrapper_startY = event.originalEvent.changedTouches[0].pageY;
  });
  modal.find('.content').on('touchmove',function(event){
    var wrapper_moveY = event.originalEvent.changedTouches[0].pageY;
    var wrapper_contentY = $(this).scrollTop();
    if (wrapper_contentY === 0 && wrapper_moveY > wrapper_startY) {
      if (wrapper_moveY-wrapper_startY>80) {
        edgeEffect(modal,'top','show');
      }
    }
    if( (wrapper_moveY < wrapper_startY) && ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)) {
      if (wrapper_startY-wrapper_moveY>80) {
        edgeEffect(modal,'bottom','show');
      }
    }
  });

} // getPofileView
