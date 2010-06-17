<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parser for {% class.method %} style tags
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
abstract class Kohana_Twig_Helper_TokenParser extends Twig_TokenParser
{
	/**
	 * @param Twig_Token $token 
	 * @return object
	 * @author Jonathan Geiger
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Methods are called like this: html.method, expect a period
		$this->parser->getStream()->expect(Twig_Token::OPERATOR_TYPE, '.');
		
		// Find the html method we're to call
		$method = $this->parser->getStream()->expect(Twig_Token::NAME_TYPE);
		$params = $this->parser->getExpressionParser()->parseMultitargetExpression();
		
		// The first element in the array is whether or 
		// not a multi expression is returned. Handle it
		if ($params[0] === FALSE)
		{
			$params = array($params[1]);
		}
		else
		{
			$params = $params[1];
		}
				
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Helper_Node(array(
			'method' => $method, 'params' => $params), array(), $lineno, $this->getTag());
	}
}
