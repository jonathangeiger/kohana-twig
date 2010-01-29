<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Token Parser for {% form.method %}
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Form_TokenParser extends Kohana_Twig_Helper_TokenParser
{
	/**
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function getTag()
	{
		return 'form';
	}
}
