<?php

class Twig_Extension_Trans extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Twig_TokenParser_Trans(),
			new Twig_TokenParser_BlockTrans(),
		);
	}

	public function getName()
	{
		return 'trans';
	}
}
