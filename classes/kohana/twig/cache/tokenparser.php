<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Cache_TokenParser extends Twig_TokenParser
{
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		$vals = array();

		// Format of tag should be {% cache 'name' %}Example Text{% endcache %}
		$key = $this->parser->getExpressionParser()->parseExpression();
		
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		// Grab the body
		$data = $this->parser->subparse(array($this, 'decideBlockEnd'), TRUE);

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Cache_Node($lineno, $this->getTag(), $key, $data);
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
