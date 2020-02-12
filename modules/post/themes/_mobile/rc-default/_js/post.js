function getPostAll(settings) {
  var start = settings.start;
  var wrapper = settings.wrapper;
  var page = wrapper.closest('.page');
  var sort=settings.sort; // sort
  var orderby=settings.orderby; // orderby
  var recnum=settings.recnum; // recnum
  var markup_file = settings.markup;
  var none = settings.none;
  var paging = settings.paging; //페이징 타입
  var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가

  wrapper.removeClass('animated fadeIn');
  wrapper.loader();

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postAll',{
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
        if (list) wrapper.html(list).addClass('animated fadeIn');
        else wrapper.html(none)

        wrapper.find('[data-plugin="timeago"]').timeago();

        overScrollEffect(page);

        if (paging=='infinit') {

          pullToRefresh_post($(start));

          //무한 스크롤
          wrapper.closest('.content').infinitescroll({
            dataSource: function(helpers, callback){
              var nextPage = parseInt(currentPage)+1;
              if (totalPage>currentPage) {
                $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postAll',{
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
            percentage : 85,  // 95% 아래로 스크롤할때 다움페이지 호출
            hybrid : false  // true: 버튼형, false: 자동
          });

        } else {

          //수동 페이징
          if (totalPage>currentPage) {

            $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postAll',{
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
                wrapper.append(list);
                wrapper.append('<button type="button" class="btn btn-white btn-block">불러오기</button>');
            });


          } else {
            console.log('더이상 불러올 페이지가 없습니다.')
          }

        }

      } else {
        alert(status);
      }
  });

}
