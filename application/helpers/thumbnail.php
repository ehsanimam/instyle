<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers -------------  MY_ HELPER
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Assets URL
 *
 * Create a local URL function reference to your assets folder. Include
 * the common css, js, images, swf, and toc folders.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('assets_url'))
{
	function assets_url($uri = '')
	{
		$CI =& get_instance();
		return base_url().$CI->config->slash_item('assets_url').$uri;
	}
}

if ( ! function_exists('css_url'))
{
	function css_url($uri = '')
	{
		return assets_url().'css/'.$uri;
	}
}

if ( ! function_exists('js_url'))
{
	function js_url($uri = '')
	{
		return assets_url().'js/'.$uri;
	}
}

if ( ! function_exists('images_url'))
{
	function images_url($uri = '')
	{
		return assets_url().'images/'.$uri;
	}
}

if ( ! function_exists('swf_url'))
{
	function swf_url($uri = '')
	{
		return assets_url().'swf/'.$uri;
	}
}

if ( ! function_exists('toc_url'))
{
	function toc_url($uri = '')
	{
		return assets_url().'toc/'.$uri;
	}
}

// ------------------------------------------------------------------------

/**
 * Template Helper
 *
 * Create a local URL function reference to the template to be used folder.
 * Segments can be passed via the first parameter either as a string or an
 * array.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('template_url'))
{
	function template_url($uri = '')
	{
		$CI =& get_instance();
		return 'includes/templates/'.$CI->config->slash_item('template').$uri;
	}
}

if ( ! function_exists('pages_url'))
{
	function pages_url()
	{
		$CI =& get_instance($uri = '');
		if ( ! $CI->config->item('pages') OR $CI->config->item('pages') == '')
		{
			return 'includes/pages/'.$CI->config->slash_item('template').$uri;
		}
		else
		{
			return 'includes/pages/'.$CI->config->slash_item('pages').$uri;
		}
	}
}

/* End of file MY_url_helper.php */
/* Location: ./system/helpers/url_helper.php */