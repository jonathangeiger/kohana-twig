<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Token Parser for {% cache 'some-key' %} Some Text {% endcache %}
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Cache_TokenParser extends Twig_TokenParser
{
	/**
	 * @param Twig_Token $token 
	 * @return object
	 * @author Jonathan Geiger
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		$vals = array();

		// Format of tag should be {% cache 'name' %}Example Text{% endcache %}
		$key = $this->parser->getExpressionParser()->parseExpression();
		
		// Check for arguments for the lifetime
		if ($this->parser->getStream()->test(Twig_Token::OPERATOR_TYPE, ','))
		{
			$this->parser->getStream()->expect(Twig_Token::OPERATOR_TYPE, ',');
			$lifetime = $this->parser->getExpressionParser()->parseExpression();
		}
		else
		{
			$lifetime = FALSE;
		}
		
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		// Grab the body until an endblock is found
		$data = $this->parser->subparse(array($this, 'decideBlockEnd'), TRUE);

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Cache_Node(array(
			'key' => $key, 'lifetime' => $lifetime, 'data' => $data), array(), $lineno, $this->getTag());
	}

	/**
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function getTag()
	{
		return 'cache';
	}
	
	/**
	 * Decides when an endtag has been found for block
	 *
	 * @param object $token 
	 * @return boolean
	 * @author Jonathan Geiger
	 */
	public function decideBlockEnd($token)
	{
		return $token->test('endcache');
	}
}
