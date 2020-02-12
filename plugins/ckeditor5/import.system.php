<?php
if(!defined('__KIMS__')) exit;
?>

<?php if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9'): ?>
<div class="" >
	<div data-role="loader">
		<div class="d-flex justify-content-center align-items-center text-muted bg-white" style="height:100vh">
			<div class="spinner-border mr-2" role="status"></div>
		</div>
	</div>

	<div data-role="editor" class="d-none">
		<div class="document-editor__toolbar border"></div>
		<div class="document-editor border-top-0">
		    <div class="document-editor__toolbar"></div>
		    <div class="document-editor__editable-container">
		        <div class="document-editor__editable">
		            <?php echo $__SRC__?>
		        </div>
		    </div>
		</div>

    <div class="opener">
    	<button type="button" class="btn btn-secondary js-openSidebar shadow" data-toggle="tooltip" title="첨부패널 열기">
    		<i class="fa fa-upload fa-2x" aria-hidden="true"></i>
    	</button>
    </div>

	</div>

</div>

<?php
getImport('ckeditor5','decoupled-document/build/ckeditor','16.0.0','js');
getImport('ckeditor5','decoupled-document/build/translations/ko','16.0.0','js');
?>
<script src="<?php echo $g['s']?>/_core/js/ckeditor5.js"></script>
<script>
  var attach_file_saveDir = '<?php echo $g['path_file']?>site/';// 파일 업로드 폴더
  var attach_module_theme = '_desktop/bs4-default-attach';// attach 모듈 테마
</script>

<script>


let editor;

DecoupledEditor
	.create( document.querySelector( '.document-editor__editable' ),{
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
		const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
		toolbarContainer.appendChild( editor.ui.view.toolbar.element );

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
