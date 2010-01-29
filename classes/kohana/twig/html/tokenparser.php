<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_HTML_TokenParser extends Kohana_Twig_Helper_TokenParser
{
	public function getTag()
	{
		return 'html';
	}
}
