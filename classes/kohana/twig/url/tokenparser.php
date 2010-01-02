<?php

class Kohana_Twig_URL_TokenParser extends Twig_TokenParser
{
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Find the route we're matching
		$route = $this->parser->getExpressionParser()->parseExpression();

		// Check for arguments for the route
		if ($this->parser->getStream()->test(Twig_Token::OPERATOR_TYPE, ','))
		{
			$this->parser->getStream()->expect(Twig_Token::OPERATOR_TYPE, ',');
			$args = $this->parser->getExpressionParser()->parseExpression();
		}
		else
		{
			$args = FALSE;
		}
				
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_URL_Node($lineno, $this->getTag(), $route, $args);
	}

	public function getTag()
	{
		return 'url';
	}
}
