<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link active" href="#kf" data-toggle="tab">kimsQ</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#awesome" data-toggle="tab">Awesome</a>
	</li>
</ul>
<!-- Tab panes -->
<div class="tab-content icon-gallery">
	<div class="tab-pane active" id="kf">
		<h5>Default Modules</h5>
		<ul class="icon-list kf">
			<li><span class="kf-comment" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-bbs" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-analysis" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-admin" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-widget" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-upload" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-tag" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-home" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-search" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-popup" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-notify" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-module" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-member" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-media" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-market" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-layout" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-domain" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-device" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-dbmanager" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-dashboard" onclick="iconDrop(this.className);"></span></li>
			<li><span class="kf-contents" onclick="iconDrop(this.className);"></span></li>
		</ul>
		<h5>kimsQ BI</h5>
		<ul class="icon-list kf">
			<li><span class="fa kf-bi-03" onclick="iconDrop(this.className);"></span></li>
			<li><span class="fa kf-bi-04" onclick="iconDrop(this.className);"></span></li>
			<li><span class="fa kf-bi-05" onclick="iconDrop(this.className);"></span></li>
			<li><span class="fa kf-bi-06" onclick="iconDrop(this.className);"></span></li>
			<li><span class="fa kf-bi-07" onclick="iconDrop(this.className);"></span></li>
		</ul>
	</div>
	<div class="tab-pane" id="awesome">
		<h5 class="text-primary">Brand Icons <small></small></h5>
		<ul class="icon-list awesome">
			<li title="android"><span class="fa fa-android" onclick="iconDrop(this.className);"></span></li>
			<li title="apple"><span class="fa fa-apple" onclick="iconDrop(this.className);"></span></li>
			<li title="google-plus"><span class="fa fa-google-plus" onclick="iconDrop(this.className);"></span></li>
			<li title="twitter"><span class="fa fa-twitter" onclick="iconDrop(this.className);"></span></li>
			<li title="facebook"><span class="fa fa-facebook" onclick="iconDrop(this.className);"></span></li>
			<li title="html5"><span class="fa fa-html5" onclick="iconDrop(this.className);"></span></li>
			<li title="css3"><span class="fa fa-css3" onclick="iconDrop(this.className);"></span></li>
			<li title="dropbox"><span class="fa fa-dropbox" onclick="iconDrop(this.className);"></span></li>
			<li title="flickr"><span class="fa fa-flickr" onclick="iconDrop(this.className);"></span></li>
			<li title="github"><span class="fa fa-github" onclick="iconDrop(this.className);"></span></li>
			<li title="github-alt"><span class="fa fa-github-alt" onclick="iconDrop(this.className);"></span></li>
			<li title="instagram"><span class="fa fa-instagram" onclick="iconDrop(this.className);"></span></li>
			<li title="linkedin"><span class="fa fa-linkedin" onclick="iconDrop(this.className);"></span></li>
			<li title="linux"><span class="fa fa-linux" onclick="iconDrop(this.className);"></span></li>
			<li title="pinterest"><span class="fa fa-pinterest" onclick="iconDrop(this.className);"></span></li>
			<li title="skype"><span class="fa fa-skype" onclick="iconDrop(this.className);"></span></li>
			<li title="vimeo"><span class="fa fa-vimeo-square" onclick="iconDrop(this.className);"></span></li>
			<li title="windows"><span class="fa fa-windows" onclick="iconDrop(this.className);"></span></li>
			<li title="youtube"><span class="fa fa-youtube" onclick="iconDrop(this.className);"></span></li>
			<li title="dribbble"><span class="fa fa-dribbble" onclick="iconDrop(this.className);"></span></li>
			<li title="foursquare"><span class="fa fa-foursquare" onclick="iconDrop(this.className);"></span></li>
			<li title="tumblr"><span class="fa fa-tumblr" onclick="iconDrop(this.className);"></span></li>
			<li title="pagelines"><span class="fa fa-pagelines" onclick="iconDrop(this.className);"></span></li>
			<li title="maxcdn"><span class="fa fa-maxcdn" onclick="iconDrop(this.className);"></span></li>
		</ul>
		<h5 class="text-primary">Web Application Icons <small>(업데이트 예정)</small></h5>
		<ul class="icon-list awesome">
			<li><span class="fa fa-adjust" onclick="iconDrop(this.className);"></span></li>
			<li><span class="fa fa-anchor" onclick="iconDrop(this.className);"></span></li>
		</ul>

	</div>
</div>



<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" hidden>
	<h4 class="modal-title" id="myModalLabel"><i class="fa fa-flag"></i> 아이콘 갤러리</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div id="_modal_footer" hidden>
	<button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">닫기</button>
</div>



<script type="text/javascript">
//<![CDATA[
function iconDrop(val)
{
	parent.iconDrop(val);
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '600px';
	parent.getId('_modal_iframe_modal_window').style.height = '450px'
	parent.getId('_modal_body_modal_window').style.height = '450px';


	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
//]]>
</script>


<style>

#rb-body {
    background-color: #fff;
	padding: 15px;
}

/*icon-gallery*/

.icon-gallery {
    height: 380px;
    overflow: auto;
    padding: 15px;
}

.icon-gallery .icon-list {
    padding-left: 0;
    padding-bottom: 1px;
    margin-bottom: 20px;
    list-style: none;
    overflow: hidden;
}
.icon-gallery .icon-list li {
    float: left;
    width: 12.5%;
    padding: 10px;
    margin: 0 -1px -1px 0;
    font-size: 12px;
    line-height: 1.4;
    text-align: center;
    border: 1px solid #ddd;
    list-style-type: none;
    cursor: pointer;
}
.icon-gallery .kf span {
    font-size: 30px;
}
.icon-gallery .awesome span {
    font-size: 30px;
}
.icon-gallery .icon-list .glyphicon {
    font-size: 25px;
}
.icon-gallery .icon-list .glyphicon-class {
    display: block;
    text-align: center;
}
.icon-gallery .icon-list li:hover {
    background-color: rgba(86,61,124,.1);
}

.icon-gallery .icon-list li.active {
    background-color: rgba(86,61,124,.1);
}
</style>
