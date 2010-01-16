<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Cache_TokenParser extends Twig_TokenParser
{
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		$vals = array();

		// Format of tag should be {% cache 'name' %}Example Text{% endcache %}
		$key = $this->parser->getExpressionParser()->parseExpression();
		
		// Check for arguments for the route
		if ($this->parser->getStream()->test(Twig_Token::OPERATOR_TYPE, ','))
		{
			$this->parser->getStream()->expect(Twig_Token::OPERATOR_TYPE, ',');
			$lifetime = $this->parser->getExpressionParser()->parseExpression();
		}
		else
		{
			$lifetime = NULL;
		}
		
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		// Grab the body
		$data = $this->parser->subparse(array($this, 'decideBlockEnd'), TRUE);

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Cache_Node($lineno, $this->getTag(), $key, $lifetime, $data);
	}

	public function getTag()
	{
		return 'cache';
	}
	
	public function decideBlockEnd($token)
	{
		return $token->test('endcache');
	}
}
