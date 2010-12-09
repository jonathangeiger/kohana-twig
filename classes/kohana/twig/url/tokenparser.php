<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parses a {% url %} tag
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_URL_TokenParser extends Twig_TokenParser
{
	/**
	 * @param Twig_Token $token 
	 * @return object
	 * @author Jonathan Geiger
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Find the route we're matching
		$route = $this->parser->getExpressionParser()->parseExpression();

		// Check for arguments for the route
		if ($this->parser->getStream()->test(Twig_Token::PUNCTUATION_TYPE, ','))
		{
			$this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, ',');
			$params = $this->parser->getExpressionParser()->parseExpression();
		}
		else
		{
			$params = FALSE;
		}
				
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_URL_Node(array('route' => $route, 'params' => $params), array(), $lineno, $this->getTag());
	}
	
	/**
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function getTag()
	{
		return 'url';
	}
}
