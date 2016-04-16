<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.cache
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla! Page CacheWithControl Plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  System.cache
 * @since       1.5
 */
class PlgSystemCacheWithControl extends JPlugin
{
	var $_cache		= null;

	var $_cache_key	= null;
	
	private $caching = 0;

	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe.
	 * @param   array   $config    An optional associative array of configuration settings.
	 *
	 * @since   1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		// Set the language in the class.
		$options = array(
			'defaultgroup'	=> 'page',
			'browsercache'	=> $this->params->get('browsercache', false),
			'caching'		=> false,
		);

		$this->_cache		= JCache::getInstance('page', $options);
		$this->_cache_key	= JUri::getInstance()->toString();
	}

	/**
	 * Converting the site URL to fit to the HTTP request.
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public function onAfterRoute()
	{
		global $_PROFILER;

		$app  = JFactory::getApplication();
		$user = JFactory::getUser();
		
		if( $this->checkRules() && $app->isSite() ){
                $this->caching = JFactory::getConfig()->get('caching');
                JFactory::getConfig()->set('caching', 0);
				return;
        }
		
		if ($app->isAdmin())
		{
			return;
		}

		if (count($app->getMessageQueue()))
		{
			return;
		}

		if ($user->get('guest') && $app->input->getMethod() == 'GET')
		{
			$this->_cache->setCaching(true);
		}

		$data = $this->_cache->get($this->_cache_key);

		if ($data !== false)
		{
			// Set cached body.
			$app->setBody($data);

			echo $app->toString($app->get('gzip'));

			if (JDEBUG)
			{
				$_PROFILER->mark('afterCache');
			}

			$app->close();
		}
	}

	/**
	 * After render.
	 *
	 * @return   void
	 *
	 * @since   1.5
	 */
	public function onAfterRender()
	{
		$app = JFactory::getApplication();

		if ($app->isAdmin())
		{
			return;
		}

		if (count($app->getMessageQueue()))
		{
			return;
		}

		$user = JFactory::getUser();
		
		if ($user->get('guest') && (! $this->checkRules()))
		{
			// We need to check again here, because auto-login plugins have not been fired before the first aid check.
			$this->_cache->store(null, $this->_cache_key);
		}
	}
	
	
	public function onAfterDispatch(){
		if( $this->checkRules() && JFactory::getApplication()->isSite() ){
			$plugin = JPluginHelper::getPlugin('system', 'cachewithcontrol');
			jimport( 'joomla.html.parameter' );
			$pluginParams = $this->params;                
			JFactory::getConfig()->set('caching', $this->caching);                
		}
	}
	
	public function checkRules(){
	  
		$plugin = JPluginHelper::getPlugin('system', 'cachewithcontrol');
		jimport( 'joomla.html.parameter' );
		$pluginParams = $this->params;
		$defs = str_replace("\r","",$pluginParams->def('definitions',''));
		$defs = explode("\n", $defs);
		
		foreach($defs As $def){
			$result = $this->parseQueryString($def);
			if(is_array($result)){
				$found = 0;
				$required = count($result);
				foreach($result As $key => $value){
					if( JRequest::getVar($key) == $value || ( JRequest::getVar($key, null) !== null && $value == '?' ) ){
						$found++;
					}
				}
				if($found == $required){
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function parseQueryString($str) {
		$op = array();
		$pairs = explode("&", $str);
		foreach ($pairs as $pair) {
			list($k, $v) = array_map("urldecode", explode("=", $pair));
			$op[$k] = $v;
		}
		return $op;
	} 
}