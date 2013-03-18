/********************************************************************
 * openWYSIWYG settings file Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 *
 * $Id: wysiwyg-settings.js,v 1.4 2007/01/22 23:05:57 xhaggi Exp $
 ********************************************************************/

/*
 * Full featured setup used the openImageLibrary addon
 */
var full = new WYSIWYG.Settings();
//full.ImagesDir = "images/";
//full.PopupsDir = "popups/";
//full.CSSFile = "styles/wysiwyg.css";
full.Width = "85%"; 
full.Height = "250px";
// customize toolbar buttons
full.addToolbarElement("font", 3, 1); 
full.addToolbarElement("fontsize", 3, 2);
full.addToolbarElement("headings", 3, 3);
// openImageLibrary addon implementation
full.ImagePopupFile = "addons/imagelibrary/insert_image.php";
full.ImagePopupWidth = 600;
full.ImagePopupHeight = 245;

/*
 * Small Setup Example
 */
var small = new WYSIWYG.Settings();
small.Width = "350px";
small.Height = "100px";
small.DefaultStyle = "font-family: Arial; font-size: 12px; background-color: #AA99AA";
small.Toolbar[0] = new Array("font", "fontsize", "bold", "italic", "underline"); // small setup for toolbar 1
small.Toolbar[1] = ""; // disable toolbar 2
small.StatusBarEnabled = false;

/*
 * My seetings
 *
 * With location.host for paths...
 */
if (location.host == 'localhost') host = "http://" + location.host + "/www/joetaveras/milan";
else host = "http://" + location.host;

var my_settings = new WYSIWYG.Settings();
my_settings.ImagesDir = host + "/jscript/openwysiwyg/images/";
my_settings.PopupsDir = host + "/jscript/openwysiwyg/popups/";
my_settings.CSSFile = host + "/jscript/openwysiwyg/styles/wysiwyg.css";
my_settings.Width = "85%"; 
my_settings.Height = "300px";
// openImageLibrary addon implementation
my_settings.ImagePopupFile = host + "/jscript/openwysiwyg/addons/imagelibrary/insert_image.php";
my_settings.ImagePopupWidth = 600;
my_settings.ImagePopupHeight = 245;

