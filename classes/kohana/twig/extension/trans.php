<?php

class Kohana_Twig_Extension_Trans extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Kohana_Twig_TokenParser_Trans(),
			new Kohana_Twig_TokenParser_BlockTrans(),
		);
	}

	public function getName()
	{
		return 'trans';
	}
}
