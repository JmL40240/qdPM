/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
  
  config.toolbarGroups = [
		{ name: 'tools' },
    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [  'selection' ] },		
		{ name: 'insert' },				
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'links' },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks'] },		
		{ name: 'colors' },
		{ name: 'about' }
	];

  
  config.removeButtons = 'Save,Preview,Flash,Iframe,PageBreak,Paste,Cut,Copy,Redo,Anchor,Undo,Subscript,Superscript';    
  config.disableNativeSpellChecker = false;  
  config.forcePasteAsPlainText = true;  
  
  config.codeSnippet_languages = {
    html: 'HTML',
    css: 'CSS',
    javascript: 'JavaScript',
    php: 'PHP',    
    sql: 'SQL',
    xml: 'XML',
    xhtml: 'XHTML'
  };
  
  
};
