
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
            if ( jQuery === undefined ) {
                // require('jQuery') returns a factory that requires window to
                // build a jQuery instance, we normalize how we use modules
                // that require this pattern but the window provided is a noop
                // if it's defined (how jquery works)
                if ( typeof window !== 'undefined' ) {
                    jQuery = require('jquery');
                }
                else {
                    jQuery = require('jquery')(root);
                }
            }
            factory(jQuery);
            return jQuery;
        };
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function($) {

    var Comments = {

        // Instance variables
        // ==================

        $el: null,
        $el_id: null,
        module: null,
        parent : null,
        parent_table : null,
        theme_name: null,
        userLevel: 0,
        userGroup: 0,
        currentPage: 1,
        totalPage: null,
        totalRow: null,
        orderby: null,
        recnum: null,
        sort: null,
        loader: null,
        role_commentContainer: null,
        role_commentInput: null,
        perm_write: null, // 작성 권한
        is_admin: is_admin==1?true:false,
        uploadInputEle : null,
        emoticonPath : null,
        options: {},
        events: {
            'keyup [data-role="comment-input"]' : 'commentInputKeyUp',
            'click [data-role="showHide-menu"]' : 'showHideMenu', // row 메뉴 보이기/숨김 이벤트(desktop)
            'click [data-kcact]' : 'doUserAct', // 사용자 액션
            'tap [data-kcact]' : 'doUserAct', // 사용자 액션
            'scroll [data-role="comment-items-wrapper"]' : 'checkScrollTop', // 스크롤 이벤트 (댓글내역 더 가져오기)
            'change [data-role="upload-inputFile"]' : 'fileInputChanged', // 파일업로드 input change
            'click [data-role="open-emoticon"]' : 'showEmoticonBox', // 이모티콘 박스 보여주기
            'click [data-role="insert-emoticon"]' : 'insertEmoticon', // 이모티콘 입력
            'click [data-role="toggle-oneline-input"]' : 'showHideOnelineInput',// 한줄의견 입력창 노출/숨김 toggel
            'tab [data-role="toggle-oneline-input"]' : 'showHideOnelineInput',// 한줄의견 입력창 노출/숨김 toggel
            'click [data-role="trigger-edit"]' : 'createEditMod',// 수정 모드 시작
            'tab [data-role="trigger-edit"]' : 'createEditMod',// 수정 모드 시작
            'click [data-role="cancel-edit"]' : 'cancelEditMod',// 수정 취소
            'tab [data-role="cancel-edit"]' : 'cancelEditMod',// 수정 취소
            'click [data-role="trigger-getMoreComment"]' : 'getMoreComment',
        },

        // Default options
        getDefaultOptions: function() {
            return {
                role_commentInput : '[data-role="comment-input"]',
                role_commentContainer: '[data-role="comment-container"]',
                role_commentWriteContainer : '[data-role="commentWrite-container"]',
                role_commentItem: '[data-role="comment-item"]',
                role_commentRowTotal: '[data-role="comment-itemTotal"]',
                role_commentLikeTotal: '[data-role="comment-likeTotal"]',
                role_onelineInput : '[data-role="oneline-input"]',
                role_onelineContainer: '[data-role="oneline-container"]',
                role_onelineItem: '[data-role="oneline-item"]',
                role_onelineRowTotal: '[data-role="oneline-rowTotal"]',
                role_onelineLikeTotal: '[data-role="oneline-likeTotal"]',
                role_showInputLength : '[data-role="show-inputLength"]',
                role_showTextLimit : '[data-role="show-textLimit"]',
                role_btnMoreContainer : '[data-role="btnMore-container"]',
                menuEle : '[data-role="comment-menuEle"]',
                uploadBtnWrapper : '[data-role="uploadBtn-wrapper"]',
                enableAttachments: true, // 업로드 가능 여부
                uploadInputDataRoleName : 'upload-inputFile',
                emoticonBox: '[data-role="emoticon-box"]',
                blockListWrapper: '[data-role="blockList-wrapper"]',
                showTotalRowEle : '[data-role="show-totalRow"]',
                noMoreCommentMsg: '더 이상 댓글이 존재하지 않습니다.',
                commentMainEle: '[data-role="comment-main"]',
                commentNoneEle: '[data-role="comment-none"]',
                orderby: 'asc',
                sort: 'uid',
                recnum: 5,
                useLoader: true,
            }
        },

        // Initialization
        init: function(options, el) {
            var self = this;
            this.$el = $(el);
            this.$el_id = '#'+this.$el.attr('id');

            // Detect mobile devices
            (function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

            if($.browser.mobile) this.$el.addClass('mobile');

            // Init options
            this.options = $.extend(true, {}, this.getDefaultOptions(), options);
            this.$el.addClass(this.options.containerClass); // 댓글박스 출력 container 에 class 추가
            this.module = this.options.moduleName; // module name 값 세팅
            this.parent = this.options.parent; // 위젯에서 세팅
            this.role_commentContainer = this.options.role_commentContainer;
            this.role_commentInput = this.options.role_commentInput;
            this.parent_table = this.options.parent_table; // 위젯에서 세팅
            this.theme_name = this.options.theme_name; // 위젯에서 세팅
            this.orderby = this.options.orderby;
            this.sort = this.options.sort;
            this.recnum = this.options.recnum;
            this.loader = this.getLoader();

            this.initCommentBox(); // load 챗박스
        },

        // comments box 로딩 및 접속자 권한/관련 데이타 세팅
        initCommentBox : function(){
            var self = this;
            var container = this.$el;
            $.post(
                rooturl+'/?r='+raccount+'&m='+this.module+'&a=get_Comment_Box',
                {
                    parent : this.parent,
                    parent_table : this.parent_table,
                    theme_name : this.theme_name,
                    sort: this.sort,
                    orderby: this.orderby,
                    recnum: this.recnum
                },
                function(response){
                    var result = $.parseJSON(response);
                    self.totalPage = result.totalPage; // 전체 페이지 값
                    self.totalRow = result.totalRow; // 전체 row 갯수 값 (대화 내력받기 시 체크)
                    self.userLevel = result.userLevel; // 접속자 level
                    self.userGroup = result.userGroup; // 접속자 group
                    self.perm_write = result.perm_write; // 글쓰기 권한
                    self.emoticonPath = result.theme_path+'/images/emoticon/';
                    $(container).append(result.comment_box);
                    self.AfterInitCommentBox();
                }
            );
        },

        // CommentBox 로딩 후 초기화 함수들 호출
        AfterInitCommentBox : function(){
           this.undelegateEvents(); // comment box 엘리먼트들 이벤트 바인딩 off
           this.delegateEvents(); // comment box 엘리먼트들 이벤트 바인딩 on
           this.initUploadInput(); // 업로드 input 세팅
           this.initWritePerm(); // 글쓰기 권한 체크 적용
           this.initBtnMore(); // 더보기 버튼 세팅
           this.initDataNone(); // 자료없은 표시 세팅
           var e = $.Event('shown.rb.comment', { relatedTarget: this.$el_id });
           this.$el.trigger(e);
        },


        // 메제시 템플릿 초기화 함수 (type : me,other,notice)
        initMsgTpl : function(){
            var self = this;
            var chat_id = this.room;
            var themeName = this.themeName;
            var tmp_obj = {};
            $.get(
                rooturl+'/?r='+raccount+'&m='+this.module+'&a=get_Msg_Tpl',
                {chat_id: chat_id,themeName:themeName },
                function(response){
                    var result = $.parseJSON(response);
                    self.msgTpl = $.extend(self.msgTpl,result);
                }
            );
        },

        // 더보기 버튼 세팅
        initBtnMore : function(){
           var comment_item = $(this.role_commentContainer).find('[data-role="comment-item"]:last');
           var currentPage = $(comment_item).attr('data-page');
           var totalPage = $(comment_item).attr('data-totalPage');
           var btnMore_container = this.options.role_btnMoreContainer;
           if(totalPage>currentPage) $(btnMore_container).show();
           else $(btnMore_container).hide();
        },

        //자료없음 표시
        initDataNone : function(){
          var comment_main_ele = this.options.commentMainEle;
          var comment_none_ele = this.options.commentNoneEle;
          var totalRow = this.totalRow;
          if (totalRow==0) {
            $(comment_main_ele).addClass('d-none');
            $(comment_none_ele).removeClass('d-none')
          } else {
            $(comment_main_ele).removeClass('d-none');
            $(comment_none_ele).addClass('d-none')
          }
        },

        delegateEvents: function() {
            this.bindEvents(false);
        },

        undelegateEvents: function() {
            this.bindEvents(true);
        },

        bindEvents: function(unbind) {
            var bindFunction = unbind ? 'off' : 'on';
            for (var key in this.events) {
                var eventName = key.split(' ')[0];
                var selector = key.split(' ').slice(1).join(' ');
                var methodNames = this.events[key].split(' ');
                for(var index in methodNames) {
                    if(methodNames.hasOwnProperty(index)) {
                        var method = this[methodNames[index]];
                        // Keep the context
                        method = $.proxy(method, this);

                        if (selector == '') {
                            this.$el[bindFunction](eventName, method);
                        } else {
                            // scroll 이벤트는 해당 엘리먼트에 직접 바인딩 해야한다.
                            if(eventName=='scroll') $(selector)[bindFunction](eventName,method);
                            else this.$el[bindFunction](eventName, selector, method);
                        }
                    }
                }
            }
        },

        // 메뉴 노출/숨김 함수
        showHideMenu: function(e){
            var target = e.currentTarget;
            var type = $(target).data('type');
            var backdrop = $(target).parent().find('.backdrop')
            var sheet = $(target).parent().find('[data-role="menu-container-'+type+'"]')
            sheet.addClass('active');
            backdrop.removeClass('hidden');
        },

        // 수정 취소
        cancelEditMod: function(e){
            e.preventDefault();
            var target = e.currentTarget;
            var type = $(target).data('type');
            var uid = $(target).data('uid');
            var e_data = {"type":type,"uid":uid};
            var origin_content = $('[data-role="'+type+'-origin-content-'+uid+'"]').html();
            $('[data-role="'+type+'-content-editable-'+uid+'"]').html(origin_content); // 기존 원래내용으로 복원

            // 수정시 입력창 및 버튼 세팅 함수 실행
            this.setEditModBtn(e_data,'deactive');

        },

        // 수정 박스 생성 함수
        createEditMod: function(e){
            e.preventDefault();
            var target = e.currentTarget;
            var type = $(target).data('type');
            var uid = $(target).data('uid');
            var e_data = {"type":type,"uid":uid};

            // 수정시 입력창 및 버튼 세팅 함수 실행
            this.setEditModBtn(e_data,'active');

        },

        // 수정시 입력창 및 버튼 세팅 함수
        setEditModBtn: function(data,mod){
            if(mod=='active'){
                // 입력창 active
                $('[data-role="'+data.type+'-content-editable-'+data.uid+'"]')
                .prop("contenteditable",true)
                .focus()
                .removeClass('markdown-body')
                .css({"border":"solid 1px #ccc","padding":"5px","margin-bottom":"3px","background":"#fff","min-height":"33px"});
                placeCaretAtEnd(document.querySelector('[data-role="'+data.type+'-content-editable-'+data.uid+'"]'));

                // 수정/취소 버튼 노출
                $('[data-role="'+data.type+'-modify-btn-wrapper-'+data.uid+'"]').show();
            }else if(mod=='deactive'){
                // 입력창 deactive
                $('[data-role="'+data.type+'-content-editable-'+data.uid+'"]')
                .prop("contenteditable",false)
                .addClass('markdown-body')
                .css({"border":"none","padding":"0px","margin-bottom":"0px","background":"none","min-height":"0"});

                // 수정/취소 버튼 숨김
                $('[data-role="'+data.type+'-modify-btn-wrapper-'+data.uid+'"]').hide();
            }
        },

        // 한줄의견 입력창 wrapper 숨김/노출 함수
        showHideOnelineInput: function(e){
            if(!memberid){
              $('#modal-login').modal()  // 비로그인 일 경우 로그인 모달 호출
              return false;
            }
            var target = e.currentTarget;
            var parent = $(target).data('parent');// 댓글 PK
            var oneline_input_wrapper = $('[data-role="oneline-input-wrapper-'+parent+'"]');
            $(oneline_input_wrapper).toggle();
        },

        // 글자 수 체크
        fnChkByte : function(inputEle,maxByte) {
            var str = $(inputEle).val();
            var str_len = $(inputEle).val().length;

            var rbyte = 0;
            var rlen = 0;
            var one_char = "";
            var str2 = "";

            for (var i = 0; i < str_len; i++) {
                one_char = str.charAt(i);

                if (escape(one_char).length > 4) {
                    rbyte++;
                    //rbyte += 2; //한글2Byte byte 수로 체크하는 경우
                } else {
                    rbyte++; //영문 등 나머지 1Byte
                }

                if (rbyte <= maxByte) {
                    rlen = i + 1; //return할 문자열 갯수
                }
            }

            if (rbyte > maxByte){
                this.showNotify(this.options.role_commentWriteContainer,this.options.commentLength+'자 를 초과했습니다.',null);
                str2 = str.substr(0, rlen); //문자열 자르기
                $(inputEle).val(str2);
                this.fnChkByte(inputEle, maxByte);
            } else {
                $(this.options.role_showInputLength).text(rbyte);
            }
        },

        commentInputKeyUp: function(e){
            var target = e.currentTarget;
            var len = $(target).val().length;
            if(this.options.commentLength){
                // 글자수 체크함수 호출
                this.fnChkByte(target,this.options.commentLength);
                //$(this.options.role_showInputLength).text(len);
            }
        },

        // 콤마 추가 함수
        addComma: function(string){
            var commaString=string.toLocaleString().split(".")[0];
            return commaString;
        },

        // 콤마 삭제
        delComma: function(commaString){
            var string=commaString.replace(/,/gi,'');
            return string;
        },

        // 전체 row 수량 업데이트
        updateTotal: function(num,type){
            var totalRow = this.totalRow; // 최초 합계
            var total_row_wrap = this.options.showTotalRowEle;
            var comment_main_ele = this.options.commentMainEle;
            var comment_none_ele = this.options.commentNoneEle;
            var total_row_text=$(total_row_wrap).text();
            total_row_text=this.delComma(total_row_text);
            var total_row;

            if(type=='add'){
               total_row=parseInt(total_row_text)+parseInt(num);
               this.totalRow = totalRow+num;
            }
            else if(type=='del'){
               total_row=parseInt(total_row_text)-parseInt(num);
               this.totalRow = totalRow-num;
            }

            if (total_row==0) {
              $(comment_main_ele).addClass('d-none');
              $(comment_none_ele).removeClass('d-none')
            } else {
              $(comment_main_ele).removeClass('d-none');
              $(comment_none_ele).addClass('d-none')
            }

            // 최종 합계에 콤마 추가
            total_row_comma=this.addComma(total_row);

            // 취소버튼 클릭시 초기화
            if(type=='init'){
               total_checked_num=0;
               $(total_row_wrap).text(0);
            }
            else $(total_row_wrap).text(total_row_comma);
        },

        // 글쓰기 권한 적용
        initWritePerm : function(){
            var role_commentInput = this.options.role_commentInput;
            var role_onelineInput = this.options.role_onelineInput;
            var input_array = [role_commentInput,role_onelineInput];

            if(!this.perm_write){

                $.each(input_array,function(key,InputEle){
                    $(InputEle).css("padding-left","10px");
                    $(InputEle).attr("placeholder","로그인을 해주세요.")
                    $(InputEle).attr("readonly",true);
                    $(InputEle).attr("data-toggle","modal");
                    $(InputEle).attr("data-target","#modal-login");
                    $(InputEle).attr("role","button");
                });
                // 댓글 입력창
                $(this.options.emoticonBox).remove();
            }else{
                // 옵션에서 정한 placeholder
                $(role_commentInput).attr("placeholder",this.options.commentPlaceHolder);
            }
            // 입력수 제한값 세팅
            if(this.options.commentLength){
                $(this.options.role_showTextLimit).text(this.options.commentLength);
            }
        },

        // 댓글 더 가져오기 이벤트
        checkScrollTop : function(e){
            var comment_box = e.currentTarget;
            var scrollTop = $(comment_box).scrollTop();
            var comment_row = $(comment_box).find('[data-role="comment-item"]:first');
            //var _currentPage = $(comment_row).data('page');
            var totalPage = this.totalPage;
            if((scrollTop<50) && (this.currentPage<totalPage)){
                this.getCommentList(this.currentPage);
                this.currentPage++;
            }
        },

        // 댓글 더 보기
        getMoreComment: function(){
            var sort = sort?sort:this.sort;
            var orderby = orderby?orderby:this.orderby;
            var recnum = recnum?recnum:this.recnum;
            var currentPage = this.currentPage;//$(comment_item).data('page'); // 현재 페이지
            var totalPage = this.totalPage; // 전체 페이지
            var currentPage = this.currentPage; // 현재 페이지
            var nextPage = parseInt(currentPage)+1;
            if(totalPage>currentPage){
                this.getCommentList(sort,orderby,recnum,nextPage,'more');
                this.currentPage= nextPage;
            }else{
                this.showNotify(null,this.options.noMoreCommentMsg,null);
            }
        },

        // 댓글 리스트 출력 함수  : getType (getMore : append , reload: html)
        getCommentList : function(sort,orderby,recnum,page,getType){
            var role_commentContainer = this.options.role_commentContainer;
            var role_moreBtnContainer = this.options.role_moreBtnContainer;
            var self = this;
            var sort = sort?sort:this.sort;
            var orderby = orderby?orderby:this.sort;
            var recnum = recnum?recnum:this.recnum;
            var page = page?page:this.page;
            if(this.options.useLoader){
                var loaderPosition = getType=='more'?'bottom':'top';
                this.showLoader(role_commentContainer,loaderPosition);
                // if(getType=='more') $(role_commentContainer).append(this.loader);
                // else $(role_commentContainer).prepend(this.loader);
            }
            $.get(rooturl+'/?r='+raccount+'&m='+this.module+'&a=do_userAct',{
                act: 'getCommentList',
                parent: this.parent,
                theme_name: this.theme_name,
                page : page,
                sort: sort,
                orderby: orderby,
                recnum: recnum,
            },function(response) {
                var result = $.parseJSON(response);
                var error = result.error;
                var commentList = result.content;
                if(error){
                    var error_comment = result.error_comment;
                    self.showNotify(null,error_comment,null);
                }else{
                    setTimeout(function(){
                       $(role_commentContainer).find(self.loader).remove(); // loader 삭제
                    },50);

                    if(getType=='more') $(role_commentContainer).append(commentList);
                    else if(getType=='reload') $(role_commentContainer).html(commentList);

                    // 더보기 버튼 초기화
                    self.initBtnMore();
                }
            });
        },

        // 사용자 액션 실행
        doUserAct : function(e){
            e.preventDefault();
            var self = this;
            var target = e.currentTarget;
            var act = $(target).data('kcact'); // 액션 구분값
            var parent = $(target).data('parent'); // 부모 PK
            var grant = $(target).data('grant'); // 한줄의견 기준 댓글의 부모 PK
            var register = $(target).data('register');// 등록자 PK
            var type = $(target).data('type'); // comment, oneline...
            var uid = $(target).data('uid'); // comment, oneline PK
            var entry = $(target).data('entry');
            var totalRow = this.totalRow;
            var theme_name = this.theme_name;
            var parent_table = this.parent_table;
            var grant_table = this.parent_table; // 한줄의견 기준 댓글의 부모 table
            var sess_code = this.getWriteToken(); // 보안 토큰값
            var recnum = this.recnum;
            var html = $(target).data('html');
            var markdown = $(target).data('markdown');
            var effect = $(target).data('effect');

            if(!memberid && (act!='reload'&&act!='more')){
                // alert('로그인을 해주세요.');
                $('#modal-login').modal()
                return false;
            }

            if(act=='regis' || act=='edit'){
                var target_input;
                var result_container;
                var msg_container;
                var content;
                if(type=='comment'){ // 댓글
                    target_input = $(this.role_commentInput);
                    result_container = this.role_commentContainer;
                    msg_container = $('[data-role="comment-input-wrapper"]');
                }
                else if(type=='oneline'){ // 한줄의견
                    target_input = $('[data-role="oneline-input-'+parent+'"]');
                    result_container = $('[data-role="oneline-container-'+parent+'"]');
                    msg_container = $('[data-role="oneline-input-wrapper-'+parent+'"]');
                }
                // 입력내용
                if(act=='regis') content = target_input.val();
                else if(act=='edit') {
                  var content_editable = $('[data-role="'+type+'-content-editable-'+uid+'"]')
                  var tag = content_editable.prop('tagName');
                  if (tag=='DIV' || tag=='ARTICLE' || tag=='SECTION') {
                    content = content_editable.html();
                  } else {
                    content = content_editable.val();
                  }
                  html = 'HTML'
                }
                // console.log(tag)

                if(content==''){
                    self.showNotify(msg_container,'내용을 입력해주세요.',null);
                    return false;
                }else{
                    $(target_input).val(''); // 입력내용 초기화
                    if(this.options.commentLength) $(this.options.role_showInputLength).text(0); // 입력 글자수 초기화
                }

                $.post(rooturl+'/?r='+raccount+'&m='+this.module+'&a=regis_'+type,{
                    content : content,
                    parent : parent,
                    grant : grant,
                    parent_table : parent_table,
                    grant_table: grant_table,
                    theme_name : theme_name,
                    sess_code : sess_code,
                    uid : uid,
                    recnum : recnum,
                    html : html,
                    markdown : markdown,
                },function(response) {
                    var result = $.parseJSON(response);
                    var error = result.error;
                    if(error){
                        self.showNotify(msg_container,result.error_msg,null);
                    }else{
                        if(act=='regis'){
                            var last_row = result.last_row;
                            var last_uid = result.lastuid;
                            $(result_container).prepend(last_row); // 등록된 댓글 출력
                            $(result_container).find('[data-role="'+type+'-item"][data-uid='+last_uid+']').addClass(effect);
                            if(type=='comment') self.updateTotal(1,'add');
                            // 콜백 이벤트
                            var e = $.Event('saved.rb.'+type, { relatedTarget: self.$el_id });
                            self.$el.trigger(e);

                        }else if(act=='edit'){
                            var edit_content = result.edit_content;
                            var edit_uid = result.edit_uid;
                            var edit_time = result.edit_time;
                            var edit_data = {"type": type,"content": edit_content,"uid": edit_uid,"time": edit_time};
                            var e = $.Event('edited.rb.'+type, { relatedTarget: self.$el_id });
                            self.$el.trigger(e);
                            self.updateEdit(edit_data); // 수정 적용 함수로 넘김
                        }
                    }

                });
                return false;

            }else if(act=='changeSort'){
                var sort = $(target).data('sort');
                var orderby = $(target).data('orderby');
                this.sort = sort;
                this.orderby = orderby;
                this.currentPage = 1; // 페이지 리셋
                this.getCommentList(sort,orderby,null,1,'reload');
                // return false;

            }else if(act=='reload'){
                var sort = this.sort;
                var orderby = this.orderby;
                this.currentPage = 1; // 페이지 리셋
                this.getCommentList(sort,orderby,null,1,'reload');
                return false;

            }else{

                if(act=='delete'){
                  var delete_confirm = confirm("정말로 삭제하시겠습니까?");
                  if (delete_confirm == false) return false;
                }

                var comment_container = $('[data-role="'+type+'-container"]');
                var comment_item_container = $('[data-role="comment-item"][data-uid="'+uid+'"]');
                var oneline_container = $('[data-role="'+type+'-container-'+parent+'"]');
                var msg_container;
                if(type=='comment') msg_container = comment_item_container;
                else if(type=='oneline') msg_container = oneline_container;

                $.post(rooturl+'/?r='+raccount+'&m='+this.module+'&a=do_userAct',{
                    act : act,
                    parent : parent,
                    register : register,
                    type : type,
                    uid : uid,
                    entry: entry,
                },function(response) {
                    var result = $.parseJSON(response);
                    var error = result.error;
                    if(error){
                        var error_msg = result.error_msg;
                        self.showNotify(msg_container,error_msg,null);
                    }else{
                        if(act=='like'){
                            var total_like = result.total_like;
                            var is_liked = result.is_liked;
                            $('[data-role="'+type+'-likeTotal-'+entry+'"]').text(total_like);

                            if (is_liked) {
                              $('[data-role="'+type+'-isLiked-'+entry+'"]').addClass('active '+effect);
                            } else {
                              $('[data-role="'+type+'-isLiked-'+entry+'"]').removeClass('active '+effect);
                            }

                        }else if(act=='delete'){

                          if(type=='comment') self.updateTotal(1,'del');

                          // 해당 row 삭제
                          if(type=='oneline') $(oneline_container).find('[data-uid="'+uid+'"]').slideUp();
                          else if(type=='comment') $(comment_container).find('[data-uid="'+uid+'"]').slideUp();
                        }
                    }

                });
            }

        },

        // 수정사항 업데이트 함수 d : edit_data
        updateEdit: function(d){

          // 수정내용 적용
          var content_wrapper = $('[data-role="'+d.type+'-content-wrapper-'+d.uid+'"]');
          $(content_wrapper).html(d.content);

          // 원본저장 div 에도 적용
          $('[data-role="'+d.type+'-origin-content-'+d.uid+'"]').html(d.content);

           // 수정시간 업데이트
          $('[data-role="'+d.type+'-time-wrapper-'+d.uid+'"]').text(d.time);

          // 입력창 및 버튼 세팅 함수 호출
          var e_data ={"type":d.type,"uid":d.uid}
          this.setEditModBtn(e_data,'deactive');
        },


        // Start of upload setting *****************************************************************************************************
        initUploadInput: function(){
            var sesscode = this.getWriteToken;
            var uploadButton = $('<span/>', {
                'class': 'comment-attach'
            });
            var uploadIcon = $('<i/>', {
                'class': 'fa fa-picture-o fa-lg'
            });
            var fileInput = $('<input/>', {
                type: 'file',
                name: 'upfiles[]',
                'data-role': this.options.uploadInputDataRoleName,
                'data-sesscode' : sesscode
            });
            // Multi file upload might not work with backend as the the file names
            // may be the same causing duplicates
            if(!$.browser.mobile) fileInput.attr('multiple', 'multiple');
            if(!this.options.enableAttachments) fileInput.attr('disabled', 'disabled');

            uploadButton.append(uploadIcon).append(fileInput);
            $(this.options.uploadBtnWrapper).append(uploadButton);
        },

        // 업로드 input change 이벤트
        fileInputChanged: function(e) {
            var files = e.currentTarget.files;
            var uploadInputFileEle = $('[data-role="'+this.options.uploadInputDataRoleName+'"]');
            var sesscode = $(uploadInputFileEle).data('sesscode');
            var uploadOptions = {
                uploadDir : this.options.uploadDir,
                sesscode : sesscode
            };
            if (sesscode === undefined){
                alert('파일 업로드를 위한 셋팅에 문제가 있습니다.');
                return false;
            }else if(files.length>0) this.uploadAttachments(files,uploadOptions);
        },

        // 업로드 실행 함수
        uploadAttachments: function(files,uploadOptions){
            var self = this;
            var data = new FormData();

            $.each(files, function(key, value) {data.append(key, value);});
            $.each(uploadOptions, function(key, value) {data.append(key, value);});

            $.ajax({
                url: rooturl+'/?r='+raccount+'&m='+this.module+'&a=upload_Attachments',
                type: 'post',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var result=$.parseJSON(response);
                    var fileList = result.fileList;
                    var comment_content = '';
                    var upload = '';
                    var files=fileList.split(',');
                    $.each(files,function(key,list){
                        var list_arr = list.split('^^');
                        var src = list_arr[0];
                        var uid = list_arr[1];
                        var type = list_arr[2];
                        upload +='['+uid+']';
                        if(type==2){
                            var photo_data = {"type":"photo","photo_src":src};
                            comment_content += self.getCommentTpl(photo_data);
                        }
                    });
                    self.uploadClientComment(comment_content,upload);
                },
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function(e) {
                            if(e.lengthComputable){
                                var max = e.total;
                                var current = e.loaded;
                                var Percentage = (current * 100)/max;
                                console.log(Percentage);
                                // progressBar.css({width: Percentage + '%'});
                                // percent.html(parseInt(Percentage));
                            }
                        }, false);
                    }
                    return myXhr;
                }
            });
        },

// End of upload setting ********************************************************************************************************

        // 업로드 전송 함수 :
        uploadClientComment : function(comment_content,upload_value){
            var token = this.getWriteToken();
            var data = {"comment":comment_content,"notice":0,"upload":upload_value,"token": token};
            this.saveComment(data);
        },

        // emoticon 박스 보여주기
        showEmoticonBox: function(){
            $(this.options.emoticonBox).slideToggle('fast');
        },

        // emoticon 입력
        insertEmoticon: function(e){
            var ele = e.currentTarget;
            var emoticon_comment = $(ele).data('emotion');
            var emoticon_src = this.emoticonPath+'/emo_'+emoticon_comment+'.png';
            var emoticon_data = {"type":"emoticon","emoticon_src":emoticon_src};
            var comment = this.getCommentTpl(emoticon_data);
            var token = this.getWriteToken();
            var comment_data = {"comment":comment,"notice":0,"token": token};
            this.saveComment(comment_data);
            $(this.options.emoticonBox).slideToggle('fast');
        },

        // comment toekn 생성
        getWriteToken : function(){
            function chr4(){
               return Math.random().toString(16).slice(-4);
            }
            return chr4() + chr4() + '.' + chr4() + chr4() + chr4();
        },

        // 입력창 포커스 이벤트
        focusInput : function(userInputEle){
            setTimeout(function(){
                $(userInputEle).focus();
            },10);
        },

        // 입력내용 중 a 요소 자동으로 링크 만들기
        linkify: function(inputText) {
            var replacedText, replacePattern1, replacePattern2, replacePattern3;

            // URLs starting with http://, https://, file:// or ftp://
            replacePattern1 = /(^|\s)((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
            replacedText = inputText.replace(replacePattern1, '$1<a href="$2" target="_blank">$2</a>');

            // URLs starting with "www." (without // before it, or it'd re-link the ones done above).
            replacePattern2 = /(^|\s)(www\.[\S]+(\b|$))/gim;
            replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

            // Change email addresses to mailto:: links.
            replacePattern3 = /(^|\s)(([a-zA-Z0-9\-\_\.]+)@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
            replacedText = replacedText.replace(replacePattern3, '$1<a href="mailto:$2">$2</a>');

            // If there are hrefs in the original text, let's split
            // the text up and only work on the parts that don't have urls yet.
            var count = inputText.match(/<a href/g) || [];

            if(count.length > 0){
                // Keep delimiter when splitting
                var splitInput = inputText.split(/(<\/a>)/g);
                for (var i = 0 ; i < splitInput.length ; i++){
                    if(splitInput[i].match(/<a href/g) == null){
                        splitInput[i] = splitInput[i].replace(replacePattern1, '<a href="$1" target="_blank">$1</a>').replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>').replace(replacePattern3, '<a href="mailto:$1">$1</a>');
                    }
                }
                var combinedReplacedText = splitInput.join('');
                return combinedReplacedText;
            } else {
                return replacedText;
            }
        },
        // 알림 출력
        showNotify : function(target,message,type){
            var target = target?target:this.$el;
            var notify_msg ='<div class="comment-notify-msg">'+message+'</div>';
            var notify = $('<div/>', { id: 'comment-notify', html: notify_msg});
            $(target).css("position","relative");
            $(notify).addClass('active').appendTo(target);
            setTimeout(function(){
                $(notify).removeClass('active');
                $(notify).remove();
            }, 1500);

        },

        // loader 생성
        getLoader : function(){
            var spinner = '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>';
            var loader =$('<div/>',{id: 'comment-spinner-wrap',html: spinner});
            return loader;
        },

        // loader 출력
        showLoader: function(container,position){
            if(position=='bottom') $(this.loader).attr("class","comment-bottom5p");
            else if(position=='top') $(this.loader).attr("class","comment-top5p");
            $(container).append(this.loader);
        }
    };

    $.fn.Rb_comment = function(options) {
        return this.each(function() {
            var comments = Object.create(Comments);
            $.data(this, 'comments', comments);
            comments.init(options || {}, this);
        });
    };
}));
