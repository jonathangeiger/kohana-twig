<?php

class Kohana_Twig_Extensions extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Kohana_Twig_URL_TokenParser(),
			new Kohana_Twig_Asset_Javascript_TokenParser(),
			new Kohana_Twig_Asset_Stylesheet_TokenParser(),
		);
	}

	public function getName()
	{
		return 'kohana_twig';
	}
}
