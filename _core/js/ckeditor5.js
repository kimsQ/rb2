// ckeditor5 이미지 업로드 어텝터
class rbUploadAdapter {
	constructor( loader ) {
		this.loader = loader;
	}

	upload() {
		return this.loader.file
			.then( file => new Promise( ( resolve, reject ) => {

				this._initRequest();
				this._initListeners( resolve, reject, file );
				this._sendRequest( file );
			} ) );
	}

	// Aborts the upload process.
	abort() {
		if ( this.xhr ) {
			this.xhr.abort();
		}
	}

	// Initializes the XMLHttpRequest object using the URL passed to the constructor.
	_initRequest() {
		const xhr = this.xhr = new XMLHttpRequest();
		xhr.open( 'POST', rooturl+'/?r='+raccount+'&m=mediaset&a=upload', true );
		xhr.responseType = 'json';
	}

	// Initializes XMLHttpRequest listeners.
	_initListeners( resolve, reject, file ) {
		const xhr = this.xhr;
		const loader = this.loader;
		const genericErrorText = `업로드 에러 : ${ file.name }.`;

		xhr.addEventListener( 'error', () => reject( genericErrorText ) );
		xhr.addEventListener( 'abort', () => reject() );
		xhr.addEventListener( 'load', () => {
			const response = xhr.response;
			if ( !response || response.error ) {
				return reject( response && response.error ? response.error.message : genericErrorText );
			}
			resolve( {
				default: response.url
			} );

			//첨부 목록에 삽입
			const attach_type  = response.type;
			const attach_item  = response.preview_default;

			if (attach_type=='photo') {
				$('[data-role="attach-preview-photo"]').append(attach_item)
			}
		} );

		if ( xhr.upload ) {
			xhr.upload.addEventListener( 'progress', evt => {
				if ( evt.lengthComputable ) {
					loader.uploadTotal = evt.total;
					loader.uploaded = evt.loaded;
				}
			} );
		}
	}

	_sendRequest( file ) {
		const data = new FormData();
		data.append( 'files', file );
		data.append( 'saveDir', attach_file_saveDir );
		data.append( 'theme', attach_module_theme );
		data.append( 'wysiwyg', 'Y' );
		data.append( 'hidden', 1 );  // 본문삽입의 경우 첨부목록에서 숨김
		this.xhr.send( data );
	}
}

// ckeditor5 이미지 업로드 어텝터
function rbUploadAdapterPlugin( editor ) {
	editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
		return new rbUploadAdapter( loader );
	};
}

// ckeditor5 내용삽입
function InserHTMLtoEditor(editor,content) {
	const viewFragment = editor.data.processor.toView( content );
	const modelFragment = editor.data.toModel( viewFragment );
	editor.model.insertContent( modelFragment );
	editor.editing.view.focus();
}
