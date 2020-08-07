<?php
if(!defined('__KIMS__')) exit;
?>

<style>

:root {
  --ck-color-toolbar-background: #fff;
  --ck-color-toolbar-border: rgba(0, 0, 0, 0.085);
  --ck-border-radius :0
}

.document-editor__toolbar .ck.ck-toolbar {
  border-left-width: 0 !important;
  border-right-width: 0 !important;
}

.document-editor__editable-container {
  overflow-x: hidden;
  padding: calc(2*var(--ck-spacing-large));
  background: var(--ck-color-base-foreground);
}

.document-editor__editable-container .document-editor__editable {
  width: 20.8cm;
  min-height: 21cm;
  padding: 1cm 2cm 2cm;
  border: 1px solid #d3d3d3;
  border-radius: var(--ck-border-radius);
  background: #fff;
  box-shadow: 0 0 5px rgba(0,0,0,.1);
  margin: 0 auto;
  border-radius: 0
}

.ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused {
  box-shadow: 0 0 5px rgba(0,0,0,.1);
  border: 1px solid #d3d3d3;
  outline: 0
}

</style>

<?php if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9'): ?>
<div class="" >
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center text-muted bg-white" style="height:100vh">
			<div class="spinner-border mr-2" role="status"></div>
		</div>
	</div>

	<div data-role="editor" class="d-none">
		<input type="hidden" name="content" value="">
		<div class="document-editor__toolbar border-right"></div>
		<div class="document-editor border-top-0">
		    <div class="document-editor__toolbar"></div>
		    <div class="document-editor__editable-container">
		        <div class="document-editor__editable">
		            <?php echo $__SRC__?>
		        </div>
		    </div>
		</div>

	</div>

</div>

<?php getImport('ckeditor5','decoupled-document/build/ckeditor',false,'js'); ?>

<script>
  var attach_file_saveDir = '<?php echo $g['path_file']?>site/';// 파일 업로드 폴더
  var attach_module_theme = '_desktop/bs4-default-attach';// attach 모듈 테마
</script>

<script>


let editor;

DecoupledDocumentEditor
	.create( document.querySelector( '.document-editor__editable' ),{
		language: 'ko',
		toolbar: [
			'undo',
			'redo',
			'|',
			'heading',
			'|',
			'highlight',
			'|',
			'bold',
			'italic',
			'underline',
			'strikethrough',
			'|',
			'alignment:left',
			'alignment:right',
			'alignment:center',
			'alignment:justify',
			'|',
			'numberedList',
			'bulletedList',
			'|',
			'outdent',
			'indent',
			'|',
			'link',
			'blockquote',
			'imageUpload',
			'insertTable',
			'code',
			'codeBlock',
			'exportPdf',
			'removeFormat'
			],
    extraPlugins: [rbUploadAdapterPlugin],
    mediaEmbed: {
        extraProviders: [
            {
                name: 'other',
                url: /^([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)/
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
		image: {
			toolbar: [
				'imageTextAlternative',
				'imageStyle:full',
				'imageStyle:side'
			]
		}
	} )
  .then( newEditor => {
		editor = newEditor;

    $('[data-role="loader"]').addClass('d-none') //로더 제거
		$('[data-role="editor"]').removeClass('d-none')
		const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
		toolbarContainer.appendChild( editor.ui.view.toolbar.element );
		editor.editing.view.focus();

    $('.document-editor__editable-container').on('scroll', function(){
      var height = $(this).scrollTop();
      if(height > 50) {
        $('.document-editor__toolbar').addClass('shadow-sm')
      } else {
        $('.document-editor__toolbar').removeClass('shadow-sm')
      }
    });

	})
	.catch( error => {
			console.error( error );
	} );

</script>
<?php else: ?>
<div class="rb-article">
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center border text-muted" style="height:80vh">
			<div class="text-center">
				<p class="mb-2">에디터가 지원되지 않는 환경 입니다.</p>
				<small>Edge,Chrome,Firefox,Safari 브라우저 이용을 부탁드립니다.</small>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
