
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
        theme_path: null,
        userLevel: 0,
        userGroup: 0,
        currentPage: 1,
        totalPage: null,
        totalRow: null,
        perm_write: null, // 작성 권한 
        is_admin: is_admin==1?true:false,
        uploadInputEle : null,
        emoticonPath : null,
        options: {},
        events: {
            'keydown [data-role="comments-inputEle"]' : 'enterClientComment',
            'keyup [data-role="comments-inputEle"]' : 'showStatusComment',
            'mouseover [data-role="comment-row"]' : 'showCommentMenu', // 댓글 row 메뉴 노출 이벤트(desktop)
            'mouseout [data-role="comment-row"]' : 'hideCommentMenu', // 댓글 row 메뉴 숨김 이벤트(desktop)
            'keypress [data-role="comment-row"]' : 'showCommentMenu', // 댓글 row 메뉴 노출 이벤트(mobile)
            'tap [data-role="comment-row"]' : 'hideCommentMenu', // 댓글 row 메뉴 숨김  이벤트(mobile)
            'click [data-act]' : 'doUserAct', // 사용자 액션
            'tap [data-act]' : 'doUserAct', // 사용자 액션
            'scroll [data-role="comments-logContainer"]' : 'checkScrollTop', // 스크롤 이벤트 (댓글내역 더 가져오기)
            'change [data-role="upload-inputFile"]' : 'fileInputChanged', // 파일업로드 input change
            'click [data-role="open-emoticon"]' : 'showEmoticonBox', // 이모티콘 박스 보여주기
            'click [data-role="insert-emoticon"]' : 'insertEmoticon' // 이모티콘 입력

        },

        // Default options
        getDefaultOptions: function() {
            return {
                userInputEle : '[data-role="comments-inputEle"]',
                commentLogContainer : '[data-role="comments-logContainer"]',
                statusBox : '[data-role="comments-status"]',
                nowText : '현재',
                userNameText : memberid?memberid:'손님',
                meText : '나',
                menuEle : '[data-role="comment-menuEle"]',
                uploadBtnWrapper : '[data-role="uploadBtn-wrapper"]',
                enableAttachments: true, // 업로드 가능 여부
                uploadInputDataRoleName : 'upload-inputFile',
                emoticonBox: '[data-role="emoticon-box"]',
                blockListWrapper: '[data-role="blockList-wrapper"]',
                showTotalRowEle : '[data-role="show-totalRow"]'
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
            this.parent_table = this.options.parent_table; // 위젯에서 세팅
            this.theme_name = this.options.theme_name; // 위젯에서 세팅
            this.initCommentBox(); // load 챗박스
        },

        // comments box 로딩 및 접속자 권한/관련 데이타 세팅
        initCommentBox : function(){
            var self = this;
            var container = this.$el;
            var commentBox = this.options.commentLogContainer; // 댓글 출력 박스
            $.post(
                rooturl+'/?r='+raccount+'&m='+this.module+'&a=get_Comments_Box',
                {
                    parent : this.parent,
                    parent_table : this.parent_table,
                    theme_name : this.theme_name
                },
                function(response){
                    var result = $.parseJSON(response);
                    self.totalPage = result.totalPage; // 전체 페이지 값
                    self.totalRow = result.totalRow; // 전체 row 갯수 값 (대화 내력받기 시 체크)
                    self.userLevel = result.userLevel; // 접속자 level
                    self.userGroup = result.userGroup; // 접속자 group
                    self.theme_path = result.theme_path;
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
        },

        // 댓글 메뉴 보이기 이벤트
        showCommentMenu : function(e){
            var row = e.currentTarget;
            var menu = $(row).find(this.options.menuEle);
            $(menu).css("visibility", "visible");
        },

        // 댓글 메뉴 보이기 이벤트
        hideCommentMenu : function(e){
            var row = e.currentTarget;
            var menu = $(row).find(this.options.menuEle);
            $(menu).css("visibility", "hidden");
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
            if(!this.perm_write || !this.room_open || this.room_closed){
                $(this.options.userInputEle).attr("placeholder","운영시간이 아니거나 작성권한이 없습니다.")
                $(this.options.userInputEle).attr("disabled","disabled");
                $('[data-role="'+this.options.uploadInputDataRoleName+'"]').attr("disabled","disabled");
                $(this.options.emoticonBox).remove();
            }
        },

        // 댓글 더 가져오기 이벤트
        checkScrollTop : function(e){
            var comment_box = e.currentTarget;
            var scrollTop = $(comment_box).scrollTop();
            var comment_row = $(comment_box).find('[data-role="comment-row"]:first');
            //var _currentPage = $(comment_row).data('page');
            var totalPage = this.totalPage;
            if((scrollTop<50) && (this.currentPage<totalPage)){
                this.getMoreComment(this.currentPage);
                this.currentPage++;
            }
        },

        // 댓글내역 더 가져오기
        getMoreComment : function(currentPage){
            var comment_box = this.options.commentLogContainer;
            $.get(rooturl+'/?r='+raccount+'&m='+this.module+'&a=do_userAct',{
                act : 'getMoreComment',
                currentPage : currentPage,
                bid : this.room
            },function(response) {
                var result = $.parseJSON(response);
                var error = result.error;
                if(error){
                    var error_comment = result.error_comment;
                    self.showNotify(error_comment);
                }else{
                    $(comment_box).prepend(result.content);
                }

            });
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

        // 사용자 액션 실행
        doUserAct : function(e){
            e.preventDefault();
            var self = this;
            var target = e.currentTarget;
            var act = $(target).data('act');
            var token = $(target).data('token');
            var user = $(target).data('user');
            var totalRow = this.totalRow;
            if(act=='dump-xls'){
                if(totalRow==0){
                    alert('데이타가 존재하지 않습니다');
                    return false;
                }
                var input_array ='<input name="r" value="'+raccount+'" />';
                    input_array +='<input name="m" value="'+this.module+'"/>';
                    input_array +='<input name="a" value="do_userAct"/>';
                    input_array +='<input name="act" value="'+act+'"/>';
                    input_array +='<input name="bid" value="'+this.room+'"/>';
                var form = $('<form/>', { name: 'tmpForm', method: 'post', action: '/',html: input_array})
                   .css("display","none")
                   .appendTo(this.$el)
                   setTimeout(function(){
                      var f = document.tmpForm;
                      f.submit();
                      $(form).remove();
                      //getIframeForAction(f);
                   },10);
            }else{
                $.post(rooturl+'/?r='+raccount+'&m='+this.module+'&a=do_userAct',{
                    act : act,
                    token : token,
                    bid : this.room,
                    user: user
                },function(response) {
                    var result = $.parseJSON(response);
                    var error = result.error;
                    if(error){
                        var error_comment = result.error_comment;
                        self.showNotify(error_comment);
                    }else{
                        // 해당 row 삭제
                        if(act=='delete'){
                           self.updateTotal(1,'del');
                           $(self.$el_id).find('[data-row-token="'+token+'"]').remove();

                        }else if(act=='report'||act=='block'||act=='unblock'){
                           if(act=='unblock') $('[data-role="block-row-'+user+'"]').remove();
                           self.showNotify(result.success_comment);
                        }
                        else if(act=='owner-delete'){
                            if(self.totalRow==0){
                                self.showNotify('데이타가 존재하지 않습니다');
                                return false;
                            }
                            // token 으로 엘리먼트 삭제
                            $.each(result.token_array,function(key,token){
                                $(self.$el_id).find('[data-row-token="'+token+'"]').remove();
                            });
                            self.updateTotal(result.delete_qty,'del');
                            self.showNotify(result.success_comment);

                        }else if(act=='getBlockUser'){
                            var block_list = result.content;
                            $(self.options.blockListWrapper).html(block_list);
                        }
                    }

                });
            }

        },

        // 댓글 저장 : token 을 저장하고 삭제시 이용한다.
        saveComment : function(data){
            var self = this;
            $.post(rooturl+'/?r='+raccount+'&m='+this.module+'&a=save_comment',{
                bid : this.room,
                notice : data.notice,
                user : self.options.userNameText,
                content : data.comment,
                token : data.token,
                upload : data.upload
            },function(response) {
                var result = $.parseJSON(response);
                var error = result.error;
                if(error){
                    var error_comment = result.error_comment;
                    self.showNotify(error_comment);
                }else{
                    var emit_data = {"comment": data.comment,"notice": data.notice,"upload": data.upload,"token": data.token,};
                    self.updateTotal(1,'add');
                    self.emitClientComment(emit_data);
                }

                //$("#result").html(result.content);
            });
        },

        // 댓글 출력 함수
        emitClientComment : function(data){
            socket.emit("clientComment", {
                "room" : this.room,
                "notice" : data.notice,
                "name": this.options.userNameText,
                "avatar" : this.options.userAvatarName,
                "comment": data.comment,
                "token": data.token
            });
        },

        // 댓글 전송 함수
        enterClientComment : function(e){
            if (e.which == 13) {
                var userInputEle = e.currentTarget;
                var user_comment = userInputEle.value;
                var comment = $.trim(user_comment);
                var comment_type='text';
                if(comment){
                    var token = this.getCommentToken();
                    var comment_data = {"comment":this.linkify(comment),"notice":0,"token": token};
                    this.saveComment(comment_data);
                    //this.emitClientComment(this.linkify(comment),token); // nodejs 에게 댓글 전송
                    $(userInputEle).val('');
                }else{
                    alert('댓글를 입력해주세요. ');
                    return false;
                    this.focusInput(userInputEle);

                }
            }
        },

        // Start of upload setting *****************************************************************************************************
        initUploadInput: function(){
            var sesscode = this.getCommentToken;
            var uploadButton = $('<span/>', {
                'class': 'comments-attach'
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
            var token = this.getCommentToken();
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
            var token = this.getCommentToken();
            var comment_data = {"comment":comment,"notice":0,"token": token};
            this.saveComment(comment_data);
            $(this.options.emoticonBox).slideToggle('fast');
        },

        // comment toekn 생성
        getCommentToken : function(){
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
    };

    $.fn.comments = function(options) {
        return this.each(function() {
            var comments = Object.create(Comments);
            $.data(this, 'comments', comments);
            comments.init(options || {}, this);
        });
    };
}));
