/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
 
var getAbsoluteUrl = (function() {
        var a;
        return function(url) {
            if(!a) a = document.createElement('a');
            a.href = url;
            return a.href;
        };
    })();

var basePath = '/opc/abstract/';
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for a single toolbar row.
	/*config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'forms' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' },
		{ name: 'about' }
	];*/
	
	config.contentsCss = basePath+'ckeditor/contents.css';
	

	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'about', groups: [ 'about' ] },
	];
	
	config.wordcount = {
		// Whether or not you want to show the Paragraphs Count
		showParagraphs: false,
	
		// Whether or not you want to show the Word Count
		showWordCount: true,
	
		// Whether or not you want to show the Char Count
		showCharCount: false,
	
		// Whether or not you want to count Spaces as Chars
		countSpacesAsChars: false,
	
		// Whether or not to include Html chars in the Char Count
		countHTML: false,
		
		// Maximum allowed Word Count, -1 is default for unlimited
		maxWordCount: -1,
	
		// Maximum allowed Char Count, -1 is default for unlimited
		maxCharCount: -1,
	};
	
	config.extraPlugins = 'specialchar,htmlwriter,wordcount,notification';
	
	//config.simpleuploads_maximumDimensions = {width:700, height:1000}

	config.removeButtons = 'Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Scayt,Link,Unlink,Anchor,Image,Table,HorizontalRule,Maximize,Source,Strike,NumberedList,BulletedList,Outdent,Indent,Blockquote,Styles,Format,About,addFile';
	
	config.filebrowserUploadUrl = basePath+'ckeditor/upload.php';

	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	//config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';

	// Dialog windows are also simplified.
	config.removeDialogTabs = 'link:advanced';
};
