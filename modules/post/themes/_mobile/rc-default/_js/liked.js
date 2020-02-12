function getPostLiked(settings) {
  var start = settings.start;
  var wrapper = settings.wrapper;
  var sort=settings.sort; // sort
  var orderby=settings.orderby; // orderby
  var recnum=settings.recnum; // recnum
  var markup_file = settings.markup;
  var none = settings.none;
  var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가

  wrapper.removeClass('animated fadeIn');
  wrapper.loader();

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postLiked',{
    start: start,
    sort : sort,
    recnum : recnum,
    p : currentPage,
    markup_file : markup_file
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var list=result.list;
        var num=result.num;
        var totalPage=result.tpg;

        wrapper.loader('hide');
        if (num) wrapper.html(list).addClass('animated fadeIn');
        else wrapper.html(none);

        wrapper.find('[data-plugin="timeago"]').timeago();

        //무한 스크롤
        wrapper.closest('.content').infinitescroll({
          dataSource: function(helpers, callback){
            var nextPage = parseInt(currentPage)+1;
            if (totalPage>currentPage) {
              $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postLiked',{
                  start: start,
                  sort: sort,
                  recnum : recnum,
                  markup_file : markup_file,
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
              });
            } else {
              callback({ end: true });
              console.log('더이상 불러올 페이지가 없습니다.')
            }
          },
          appendToEle : wrapper,
          percentage : 95,  // 95% 아래로 스크롤할때 다움페이지 호출
          hybrid : false  // true: 버튼형, false: 자동
        });

        // edgeEffect
        var wrapper_startY = 0;
        wrapper.closest('.content').on('touchstart',function(event){
          wrapper_startY = event.originalEvent.changedTouches[0].pageY;
        });
        wrapper.closest('.content').on('touchmove',function(event){
          var wrapper_moveY = event.originalEvent.changedTouches[0].pageY;
          var wrapper_contentY = $(this).scrollTop();
          if (wrapper_contentY === 0 && wrapper_moveY > wrapper_startY) {
            if (wrapper_moveY-wrapper_startY>50) {
              edgeEffect(wrapper.closest('.page'),'top','show'); // 스크롤 상단 끝
            }
          }
          if( (wrapper_moveY < wrapper_startY) && ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)) {
            if (wrapper_startY-wrapper_moveY>50) {
              edgeEffect(wrapper.closest('.page'),'bottom','show');
            }
          }
        });

      } else {
        alert(status);
      }
  });

}
