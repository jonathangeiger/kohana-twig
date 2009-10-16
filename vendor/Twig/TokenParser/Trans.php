<?php

class Twig_TokenParser_Trans extends Twig_TokenParser
{
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Grab the expression to use as the language string
		$data = $this->parser->getExpressionParser()->parseExpression();

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Twig_Node_Trans($lineno, $this->getTag(), $data);
	}

	public function getTag()
	{
		return 'trans';
	}
}
