/**

 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.html or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here.

	// For the complete reference:

	// http://docs.ckeditor.com/#!/api/CKEDITOR.config



	// The toolbar groups arrangement, optimized for two toolbar rows.

	config.toolbarGroups = [

		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },

		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },

		{ name: 'links' },

		{ name: 'insert' },

		{ name: 'forms' },

		{ name: 'tools' },

		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },

		{ name: 'others' },

		'/',

		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },

		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },

		{ name: 'styles' },

		{ name: 'colors' },

		{ name: 'cleanup' }

	];



	// Remove some buttons, provided by the standard plugins, which we don't

	// need to have in the Standard(s) toolbar.

	config.removeButtons = 'Underline,Subscript,Superscript';

	config.enterMode = CKEDITOR.ENTER_BR;

	config.height = '250px';

	config.extraPlugins = 'justify';



	// Se the most common block elements.

	config.format_tags = 'p;h1;h2;h3;pre';

	

	config.allowedContent = true;



	// Make dialogs simpler.

	config.removeDialogTabs = 'image:advanced;link:advanced';

	

   //config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';

   config.filebrowserImageBrowseUrl = 'librari/ckeditor/plugins/mediamanager/index.html';

  // config.filebrowserFlashBrowseUrl = '/ckfinder/ckfinder.html?type=Flash';

   config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

   config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

   config.filebrowserFlashUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};

