<?php
 /**
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE

 * @package JoomApp - Multi Usergroup Plugin
 * @copyright Copyright (c)2012 www.JoomApp.com
 * @license GNU General Public License version 3, or later
 * @version Joomla 3.+ 
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of Plugin
 */

class plgSystemCacheWithControlInstallerScript
{
	/**
	 * method to install the plugin
	 *
	 * @return void
	 */
	function install($parent)
	{
		// $parent is the class calling this method
		
	}

	/**
	 * method to uninstall the plugin
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// $parent is the class calling this method
		
	}

	/**
	 * method to update the plugin
	 *
	 * @return void
	 */
	function update($parent)
	{
		// $parent is the class calling this method
		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		
		if (JPluginHelper::isEnabled('system', 'cache')) {
			JFactory::getApplication()->enqueueMessage(JText::_('Please disable cache joomla system plugin first, Then this plugin can be installed'), 'error');
			return false;	
		}
			
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		
	}
}
