<?php
if(!defined('__KIMS__')) exit;
?>

<div class="rb-article">
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center border text-muted bg-white" style="height:215px">
			<div class="spinner-border mr-2" role="status"></div>
		</div>
	</div>
	<div data-role="editor" class="d-none">
		<input type="hidden" name="content" value="">
		<div id="ckeditor_textarea" class="border">
			<?php echo getContents($R['content'],$R['html'],'')?>
		</div>
	</div>
</div>


<?php
getImport('ckeditor5','balloon-block/build/ckeditor',false,'js');
getImport('ckeditor5','balloon-block/build/translations/ko',false,'js');
?>

<script>

let editor;

BalloonEditor
.create( document.querySelector( '#ckeditor_textarea' ),{
	language: 'ko',
	extraPlugins: [rbUploadAdapterPlugin],
	mediaEmbed: {
			extraProviders: [
					{
							name: 'other',
							url: /^([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)/
					},
					{
							name: 'another',
							url: /^([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)/
					}
			]
	},
	typing: {
			transformations: {
					include: [
						'quotes',
						'typography',
					],
					extra: [
							// Add some custom transformations – e.g. for emojis.
							{ from: ':)', to: '🙂' },
							{ from: ':+1:', to: '👍' },
							{ from: ':tada:', to: '🎉' }
					],
			}
	},
} )
.then( newEditor => {
	editor = newEditor;
	$('[data-role="loader"]').addClass('d-none') //로더 제거
	$('[data-role="editor"]').removeClass('d-none')
})
.catch( error => {
		console.error( error );
} );

</script>
