<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Token parser for {% javascripts %} 
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Asset_Javascript_TokenParser extends Kohana_Twig_Asset_TokenParser
{
	/**
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function getTag()
	{
		return 'javascripts';
	}
}
