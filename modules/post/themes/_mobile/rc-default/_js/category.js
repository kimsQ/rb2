function getPostCategory(settings) {

  var wrapper = settings.wrapper;
  var category=settings.category; // category
  var sort=settings.sort; // sort
  var orderby=settings.orderby; // orderby
  var recnum=settings.recnum; // recnum
  var totalPage = settings.totalPage;
  var totalNUM = settings.totalNUM;
  var markup_file = settings.markup;
  var start = settings.start;
  var none = settings.none;
  var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
  var prevNUM = currentPage * recnum;
  var moreNUM = totalNUM - prevNUM ;

  wrapper.loader();

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postCategory',{
    sort : sort,
    cat : category,
    recnum : recnum,
    p : currentPage,
    markup_file : markup_file,
    orderby :orderby,
    start : start
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var list=result.list;
        var num=result.num;

        wrapper.loader('hide');
        if (num) wrapper.html(list)
        else wrapper.html(none)

        wrapper.find('[data-plugin="timeago"]').timeago();

        //무한 스크롤
        wrapper.closest('.content').infinitescroll({
          dataSource: function(helpers, callback){
            var nextPage = parseInt(currentPage)+1;
            if (totalPage>currentPage) {
              $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postKeyword',{
                  sort: sort,
                  keyword : keyword,
                  recnum : recnum,
                  markup_file : markup_file,
                  p : nextPage,
                  start : start
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


      } else {
        alert(status);
      }
  });

}
