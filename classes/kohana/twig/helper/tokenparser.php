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
		$this->parser->getStream()->expect(Twig_Token::PUNCTUATION_TYPE, '.');
		
		// Find the html method we're to call
		$method = $this->parser->getStream()->expect(Twig_Token::NAME_TYPE)->getValue();
		$params = $this->parser->getExpressionParser()->parseMultiTargetExpression();
		
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
		
		return new Kohana_Twig_Helper_Node(array('expression' => $params), array('method' => $method), $lineno, $this->getTag());
	} 
}
