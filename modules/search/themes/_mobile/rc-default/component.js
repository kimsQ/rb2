var modal_search = $('#modal-search');
var modal_search_none = '<div class="p-5 text-xs-center text-muted" data-role="none">검색된 자료가 없습니다.</div>';

function getSearchResult(settings) {
  var wrapper = settings.wrapper;
  var start = settings.start;
  var keyword = settings.keyword;
  var sort = settings.sort;
  var recnum = settings.recnum;
  var markup_file = settings.markup_file;
  var none = settings.none;

  var totalPage = settings.totalPage;
  var totalNUM = settings.totalNUM;
  var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
  var prevNUM = currentPage * recnum;
  var moreNUM = totalNUM - prevNUM ;

  wrapper.find('[data-role="list-post"]').loader({ position: 'inside' });

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postSearch',{
    start: start,
    keyword : keyword,
    sort : sort,
    recnum : recnum,
    p : currentPage,
    markup_file : markup_file
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var list=result.list;
        var num=result.num;

        if (list) wrapper.find('[data-role="list-post"]').html(list)
        else wrapper.find('[data-role="list-post"]').html(none)

        wrapper.find('[data-role="keyword-reset"]').removeClass("hidden");
        wrapper.find('[data-plugin="timeago"]').timeago();

        //무한 스크롤
        wrapper.closest('.content').infinitescroll({
          dataSource: function(helpers, callback){
            var nextPage = parseInt(currentPage)+1;
            if (totalPage>currentPage) {
              $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postSearch',{
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


      } else {
        alert(status);
      }
  });


} // getSearchResult

//검색 모달이 열렸을때
modal_search.on('shown.rc.modal', function () {
  var modal = $(this);
  setTimeout(function() {
    modal_search.find('#search-input').val('').focus();
  }, 100);

  $('#modal-post-view').find('[data-act="pauseVideo"]').click();  //유튜브 미니플레이어 재생정지

  modal_search.find('#search-input').autocomplete({
    lookup: function (query, done) {

       $.getJSON(rooturl+"/?m=tag&a=searchtag", {q: query}, function(res){
           var sg_tag = [];
           var data_arr = res.taglist.split(',');//console.log(data.usernames);
           $.each(data_arr,function(key,tag){
               var tagData = tag.split('|');
               var keyword = tagData[0];
               var hit = tagData[1];
               sg_tag.push({"value":keyword,"data":hit});
           });
           var result = {
               suggestions: sg_tag
           };
            done(result);
       });
   },
      onSelect: function (suggestion) {
        if (modal_search.find('#search-input').val().length >= 1) {
          modal_search.find('form').submit();
        }
      }
  });
})

//검색실행
modal_search.find('form').submit( function(e){
  var modal = modal_search;
  var keyword = modal_search.find('[name="keyword"]').val();
  e.preventDefault();
  e.stopPropagation();

  getSearchResult({
    wrapper : modal,
    keyword : keyword,
    totalNUM  : '',
    totalPage : '',
    recnum    : '5',
    totalPage : '',
    sort      : 'gid',
    markup_file : 'search-row',
    none : modal_search_none
  });

});

// 검색버튼과 검색어 초기화 버튼 동적 출력
modal_search.find('#search-input').on('keyup', function(event) {
  var modal = modal_search
  modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김
  modal.find("#drawer-search-footer").addClass('hidden') //검색풋터(검색버튼 포함) 숨김
  modal.find('[data-role="none"]').addClass('d-none');
  if ($(this).val().length >= 2) {
    modal.find('[data-role="keyword-reset"]').removeClass("hidden");
  }
});

// 검색어 입력필드 초기화
$(document).on('tap click','[data-act="keyword-reset"]',function(){
  var modal = modal_search
  modal.find("#search-input").val('').autocomplete('clear'); // 입력필드 초기화
  setTimeout(function(){
    modal.find("#search-input").focus(); // 입력필드 포커싱
    modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김
    modal.find('[data-role="none"]').addClass('d-none');
  }, 10);
});

// 검색모달이 닫혔을때
modal_search.on('hidden.rc.modal', function () {
  var modal = $(this)
  modal.find('#search-input').autocomplete('clear');
  $('.autocomplete-suggestions').remove();
  modal.find("#search-input").val('');
  modal.find('[data-role="list-post"]').html('');
  modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김'
})
