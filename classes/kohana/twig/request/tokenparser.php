<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parses a {% request %} tag
 *
 * Based on Kohana_Twig_URL_TokenParser
 *
 * @package kohana-twig
 * @author MasterCJ
 */
class Kohana_Twig_Request_TokenParser extends Twig_TokenParser
{
	/**
	 * @param Twig_Token $token 
	 * @return object
	 * @author MasterCJ
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Get the URI
		$uri = $this->parser->getExpressionParser()->parseExpression();

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Request_Node(array('uri' => $uri), array(), $lineno, $this->getTag());
	}

	/**
	 * @return string
	 * @author MasterCJ
	 */
	public function getTag()
	{
		return 'request';
	}
}
