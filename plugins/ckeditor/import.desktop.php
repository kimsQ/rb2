<?php
if(!defined('__KIMS__')) exit;
?>

<style>
/* 툴바 감추기 설정 - 게시판 테마 */
<?php if (!$d['theme']['show_edittoolbar']): ?>
#cke_1_top {display: none}
<?php endif; ?>
</style>

<div class="rb-article">
	<textarea name="content" class="form-control ckeditor d-none" id="ckeditor_textarea"><?php echo $__SRC__?></textarea>
</div>

<?php
getImport('ckeditor','full-all/ckeditor','4.9.0','js');
$editor_type = 'html'; // 에디터 타입 : html,markdown
$editor_height = $d['theme']['edit_height']?$d['theme']['edit_height']:'350';
?>


<script>

function InserHTMLtoEditor(type,sHTML) {
	CKEDITOR.instances['ckeditor_textarea'].insertHtml(sHTML);
}

CKEDITOR.replace( 'ckeditor_textarea', {
	// Define the toolbar: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_toolbar
	// The standard preset from CDN which we used as a base provides more features than we need.
	// Also by default it comes with a 2-line toolbar. Here we put all buttons in a single row.


	toolbar: [
		{ name: 'styles', items: [ 'Styles', 'Format' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
		{ name: 'links', items: [ 'Link', 'Unlink' ] },
		{ name: 'insert', items: [ 'Image', 'EmbedSemantic', 'Table','HorizontalRule'] },
		{ name: 'tools', items: [ 'Maximize' ] }
	],
	// Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
	// One HTTP request less will result in a faster startup time.
	// For more information check http://docs.ckeditor.com/ckeditor4/docs/#!/api/CKEDITOR.config-cfg-customConfig
	customConfig: '',
	// Enabling extra plugins, available in the standard-all preset: http://ckeditor.com/presets-all
	extraPlugins: 'autoembed,embedsemantic,tableresize,horizontalrule',
	/*********************** File management support ***********************/
	// In order to turn on support for file uploads, CKEditor has to be configured to use some server side
	// solution with file upload/management capabilities, like for example CKFinder.
	// For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_ckfinder_integration
	// Uncomment and correct these lines after you setup your local CKFinder instance.
	// filebrowserBrowseUrl: 'http://example.com/ckfinder/ckfinder.html',
	// filebrowserUploadUrl: '/uploader/upload.php',
	/*********************** File management support ***********************/
	// Remove the default image plugin because image2, which offers captions for images, was enabled above.
	// removePlugins: 'image',
	// Make the editing area bigger than default.
	height: 450,

	// An array of stylesheets to style the WYSIWYG area.
	// Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
	// contentsCss: [ 'https://cdn.ckeditor.com/4.8.0/standard-all/contents.css', 'mystyles.css' ],
	// This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
	bodyClass: 'article-editor',
	// Reduce the list of block elements listed in the Format dropdown to the most commonly used.
	format_tags: 'p;h1;h2;h3;pre',
	// Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
	removeDialogTabs: 'image:advanced;link:advanced',
	// Define the list of styles which should be available in the Styles dropdown list.
	// If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
	// (and on your website so that it rendered in the same way).
	// Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
	// that file, which means one HTTP request less (and a faster startup).
	// For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_styles
	stylesSet: [
		/* Inline Styles */
		{ name: '작성자',			element: 'span', attributes: { 'class': 'marker' } },
		{ name: 'Inline Quotation',	element: 'q' },
		/* Object Styles */
		{
			name: '강조박스',
			element: 'div',
			styles: {
				margin: '15px 0',
				padding: '5px 10px',
				background: '#eee',
				border: '1px solid #ccc'
			}
		},
		{
			name: '콤팩트 테이블',
			element: 'table',
			attributes: {
				cellpadding: '5',
				cellspacing: '0',
				border: '1',
				bordercolor: '#ccc'
			},
			styles: {
				'border-collapse': 'collapse'
			}
		},
		{ name: '테두리 없는 테이블',		element: 'table',	styles: { 'border-style': 'hidden', 'background-color': '#E6E6FA' } },
		{ name: '사각 목록',	element: 'ul',		styles: { 'list-style-type': 'square' } },
		// { name: '반응형 이미지',	element: 'img',	styles: { 'max-width': '100%', 'height': 'auto' } },
		/* Widget Styles */
		// We use this one to style the brownie picture.
		{ name: '반응형 이미지', type: 'widget', widget: 'image', styles: { 'max-width': '100%', 'height': 'auto' } },
		// Media embed
		{ name: '240p', type: 'widget', widget: 'embedSemantic', attributes: { 'class': 'embed-240p' } },
		{ name: '360p', type: 'widget', widget: 'embedSemantic', attributes: { 'class': 'embed-360p' } },
		{ name: '480p', type: 'widget', widget: 'embedSemantic', attributes: { 'class': 'embed-480p' } },
		{ name: '720p', type: 'widget', widget: 'embedSemantic', attributes: { 'class': 'embed-720p' } },
		{ name: '1080p', type: 'widget', widget: 'embedSemantic', attributes: { 'class': 'embed-1080p' } }
	]
} );

</script>
