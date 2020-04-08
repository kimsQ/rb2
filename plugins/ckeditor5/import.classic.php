<?php
if(!defined('__KIMS__')) exit;
?>

<?php if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9'): ?>
<div class="rb-article">
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center border text-muted bg-white" style="height:215px">
			<div class="spinner-border mr-2" role="status"></div>
		</div>
	</div>
	<div data-role="editor" class="d-none">
		<input type="hidden" name="content" value="">
		<div id="ckeditor_textarea" class="border">
			<?php echo getContents($R['content'],$R['html'])?>
		</div>
	</div>
</div>


<?php
getImport('ckeditor5','classic/build/ckeditor',false,'js');
getImport('ckeditor5','classic/build/translations/ko',false,'js');
?>

<script>

let editor;

ClassicEditor
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
								// Use only the 'quotes' and 'typography' groups.
								'quotes',
								'typography',

								// Plus, some custom transformation.
								{ from: '->', to: '→' },
								{ from: ':)', to: '🙂' },
								{ from: ':+1:', to: '👍' },
								{ from: ':tada:', to: '🎉' },
						],
				}
		},
		image: {
				// You need to configure the image toolbar, too, so it uses the new style buttons.
				toolbar: [ 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight' ],

				styles: [
						// This option is equal to a situation where no style is applied.
						'full',

						// This represents an image aligned to the left.
						'alignLeft',

						// This represents an image aligned to the right.
						'alignRight'
				]
		}
	} )
	.then( newEditor => {
		editor = newEditor;
		$('[data-role="loader"]').addClass('d-none') //로더 제거
		$('[data-role="editor"]').removeClass('d-none')

		editor.model.document.on( 'mediaEmbed', () => {
		   console.log('미디어 삽입')
		} );
	})
	.catch( error => {
			console.error( error );
	} );

</script>

<?php else: ?>
<div class="rb-article">
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center border text-muted bg-light" style="height:215px">
			<div class="text-center">
				<p class="mb-2">지원되지 않는 환경 입니다.</p>
				<small>Edge,Chrome,Firefox,Safari 브라우저 이용을 부탁드립니다.</small>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
