<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Asset_Javascript_TokenParser extends Kohana_Twig_Asset_TokenParser
{
	public function getTag()
	{
		return 'javascripts';
	}
}
