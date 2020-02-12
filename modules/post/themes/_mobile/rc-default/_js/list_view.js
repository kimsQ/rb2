function getPostListview(settings) {
  var listid = settings.listid;
  var wrapper = settings.wrapper;
  var sort=settings.sort; // sort
  var orderby=settings.orderby; // orderby
  var recnum=settings.recnum; // recnum
  var totalPage = settings.totalPage;
  var totalNUM = settings.totalNUM;
  var markup_file = settings.markup;
  var none = settings.none;
  var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
  var prevNUM = currentPage * recnum;
  var moreNUM = totalNUM - prevNUM ;


  wrapper.loader();

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_listview',{
    listid : listid,
    sort : sort,
    recnum : recnum,
    p : currentPage,
    markup_file : markup_file
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var box=result.box;
        var num=result.num;

        wrapper.loader('hide');
        wrapper.html(box)
        wrapper.find('[data-plugin="timeago"]').timeago();

        //무한 스크롤
        wrapper.closest('.content').infinitescroll({
          dataSource: function(helpers, callback){
            var nextPage = parseInt(currentPage)+1;
            if (totalPage>currentPage) {
              $.post(rooturl+'/?r='+raccount+'&m=post&a=get_listview',{
                  listid : listid,
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
