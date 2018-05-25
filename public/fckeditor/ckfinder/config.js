/*
Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
For licensing, see license.txt or http://cksource.com/ckfinder/license
*/

CKFinder.customConfig = function( config )
{
	// Define changes to default configuration here.
	// For the list of available options, check:
	// http://docs.cksource.com/ckfinder_2.x_api/symbols/CKFinder.config.html

	// Sample configuration options:
	// config.uiColor = '#BDE31E';
	// config.language = 'fr';
	// config.removePlugins = 'basket';
	// config.readOnly = true;
	config.callback = function( api ) {
	// Disable download function
	api.disableFileContextMenuOption( 'downloadFile', false );
	// Disable "View" option
	api.disableFileContextMenuOption( 'viewFile', false );
	// Disable "Edit" option
	api.disableFileContextMenuOption( 'editFile', false );
	};

};
