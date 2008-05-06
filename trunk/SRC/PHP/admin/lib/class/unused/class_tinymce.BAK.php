<?php 
/*
 * TinyMce - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.TinyMce.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: TinyMce.php
 * 	This is the integration file for PHP.
 * 	
 * 	It defines the TinyMce class that can be used to create editor
 * 	instances in PHP pages on server side.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@TinyMce.net)
 */
 
 /* EXEMPLE 
 
require_once ("inc/TinyMce/TinyMce.php");
$Ed = new TinyMce('myInputName');
$Ed->ToolbarSet = 'Basic';  // BasicStyle | BasicTab | BasicImg
$Ed->Width = '100%';
$Ed->Height = '280px';
$Ed->Value = 'Bla bla';
$Ed->Create();

 */

class TinyMce
{
	var $InstanceName ;
	var $BasePath ;
	var $Width ;
	var $Height ;
	var $ToolbarSet ;
	var $Value ;
	var $Config ;

	// PHP 5
	function __construct( $instanceName )
 	{
		$this->InstanceName	= $instanceName ;
		$this->BasePath		= '/tiny_mce/' ;
		$this->width		= '80%';
		$this->height		= '290';
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;
		$this->Config		= array() ;
	}
	
	// PHP 4
	function TinyMce( $instanceName )
	{
		$this->__construct( $instanceName ) ;
	}

	function Create()
	{
		return $this->CreateHtml() ;
	}
	
	function CreateHtml()
	{
		global $WWW;
		$HtmlValue = htmlspecialchars( $this->Value ) ;
		
		static $idCounter = 0;

		// Default CONFIG
		$toolbar = 'preview,separator,';
		$toolbar2 = $toolbar3 = '';
		$plugg = 'preview,inlinepopups';
		$config_supp = "
			plugin_preview_width : '460',
			plugin_preview_height : '600',
			plugin_preview_pageurl : '".$WWW."admin/lib/tiny_mce/plugins/preview/tiny_mce_preview.html',
			popups_css_add : '".$WWW."admin/style_admin.css.php',
			content_css : '".$WWW."admin/style_wysiwyg.css.php',
		";
		$arrayStyles = 'Bleu=bleu'; //;
		
		// Switch TOOLBAR
		switch($this->ToolbarSet) { // Default, Basic, BasicImg, BasicStyle, BasicTab
			
			case 'Basic' :
				$toolbar .= 'bold,italic,separator,link,unlink,separator,bullist,numlist,indent,outdent,justifyleft,justifycenter,justifyright,justifyfull,separator,pasteword,cleanup,removeformat';
			break;
			
			case 'BasicTab' :
				$toolbar .= 'bold,italic,separator,link,unlink,separator,bullist,numlist,indent,outdent,justifyleft,justifycenter,justifyright,justifyfull,separator,pasteword,cleanup,removeformat,code';
				$toolbar2 = 'tablecontrols';
				$plugg .= ',table';
				$config_supp .= "
					table_cell_limit : 100,
					table_row_limit : 6,
					table_col_limit : 6,
					theme_advanced_toolbar_location : 'top',
					theme_advanced_statusbar_location : 'bottom',
				";
			break;
			
			case 'BasicImg' :
				$toolbar .= 'image,separator,bold,italic,separator,link,unlink,separator,bullist,numlist,indent,outdent,justifyleft,justifycenter,justifyright,justifyfull,separator,pasteword,cleanup,removeformat,code';
			break;
			
			case 'BasicStyle' :
				$toolbar .= 'bold,italic,separator,styleselect,separator,link,unlink,separator,bullist,numlist,indent,outdent,justifyleft,justifycenter,justifyright,justifyfull,separator,pasteword,cleanup,removeformat,code';
				$config_supp .= "
					theme_advanced_styles : '$arrayStyles',
					theme_advanced_toolbar_location : 'top',
					theme_advanced_statusbar_location : 'bottom',
					theme_advanced_path : true,
				";
			break;
			
			case 'BasicFormat' :
				$toolbar .= 'bold,italic,hr,separator,formatselect,separator,link,unlink,separator,bullist,numlist,indent,outdent,justifyleft,justifycenter,justifyright,justifyfull,separator,pasteword,cleanup,removeformat,code';
				$plugg .= ',paste';
				$config_supp .= "
					theme_advanced_styles : '$arrayStyles',
					theme_advanced_toolbar_location : 'top',
					theme_advanced_statusbar_location : 'bottom',
					theme_advanced_path : true,
					theme_advanced_blockformats : 'p,h1,h2,h3,h4,h5',
				";
			break;
			
			case 'Default' : 
			default :
				$toolbar .= ',separator,bold,italic,separator,link,unlink,separator,separator,pasteword,cleanup,removeformat';
			break;
		}
		
		$js_file = $javascript = '';
		
		global $TinyMceEditorDone;
		
		if( $TinyMceEditorDone != 1 ) {
			$TinyMceEditorDone = 1;
			global $WWW,$JS,$JSE;
			
			$js_file = $WWW."admin/lib/tiny_mce/tiny_mce.js";
			
			$js_file = '<script language="javascript" type="text/javascript" src="'.$js_file.'"></script>';

			$javascript = js("
			tinyMCE.init({
				width : '640px',
				height : '".$this->height.(strpos($this->height,'%')!==false?'':'px')."',
				mode : 'exact',
				cleanup : true,
				theme : 'advanced',
				elements : '' ,
				language : 'fr',
				plugins : '".$plugg."',
				theme_advanced_buttons1 : '".$toolbar."',
				theme_advanced_buttons2 : '".$toolbar2."',
				theme_advanced_buttons3 : '',
				theme_advanced_resizing : true,
				theme_advanced_resizing_use_cookie : false,
				button_tile_map : true,
				auto_reset_designmode : true,
				dialog_type : 'modal',
				cleanup_on_startup : true,
				cleanup: true,
				object_resizing : false,
				".$config_supp."
				debug : false
			});
			",false);
			/*
				content_css : "/mycontent.css",
				verify_css_classes : true, //class names placed in class attributes will be verified agains the content CSS. So elements with a class attribute containing a class that doesn't exist in the CSS will be removed
				auto_resize : true,
				forced_root_block : 'p',
				execcommand_callback : 'myCustomExecCommandHandler',
				hide_selects_on_submit : true,
				strict_loading_mode : false,
				theme_advanced_buttons1_add_before : '',
				theme_advanced_text_colors : 'FF00FF,FFFF00,000000',
				theme_advanced_fonts : 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace',
				theme_advanced_background_colors : 'FF00FF,FFFF00,000000',
				theme_advanced_toolbar_location : "top",';
				theme_advanced_statusbar_location : "bottom",';
			*/
		}
		
$javascript_E = js("
tinyMCE.idCounter=".$idCounter.";
tinyMCE.execCommand('mceAddControl', false, '".$this->InstanceName."');
", false);

		$idCounter++;
		
		$html = '<div>
		<textarea name="'.$this->InstanceName.'" id="'.$this->InstanceName.'" cols="40" rows="12" wrap="virtual" style="width:640px;height:'.$this->height.(strpos($this->height,'%')!==false?'':'px').';">'.$HtmlValue.'</textarea>
		</div>';

		$js_html = $js_file.$javascript.chr(13).chr(10).$html.chr(13).chr(10).$javascript_E;
		
		return $js_html;

	}
}

?>