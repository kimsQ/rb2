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

<?php getImport('ckeditor5','classic/build/ckeditor',false,'js'); ?>

<script>

let editor;

ClassicEditor
	.create( document.querySelector( '#ckeditor_textarea' ),{
		toolbar: {
			items: [
				'heading',
				'|',
				'fontColor',
				'fontSize',
				'|',
				'bold',
				'italic',
				'link',
				'highlight',
				'|',
				'bulletedList',
				'numberedList',
				'|',
				'indent',
				'outdent',
				'|',
				'imageUpload',
				'blockQuote',
				'insertTable',
				'mediaEmbed',
				'|',
				'undo',
				'redo'
			]
		},
    extraPlugins: [rbUploadAdapterPlugin],
		language: 'ko',
		image: {
			toolbar: [
				'imageTextAlternative',
				'imageStyle:full',
				'imageStyle:side'
			]
		},
		table: {
			contentToolbar: [
				'tableColumn',
				'tableRow',
				'mergeTableCells'
			]
		},
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
		link: {
				decorators: {
						addTargetToLinks: {
								mode: 'manual',
								label: '새탭에서 열기',
								attributes: {
										target: '_blank',
										rel: 'noopener noreferrer'
								}
						}
				}
		},

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
