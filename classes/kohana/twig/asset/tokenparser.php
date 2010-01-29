<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Token Parser for the asset tag
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
abstract class Kohana_Twig_Asset_TokenParser extends Twig_TokenParser
{
	/**
	 * @param Twig_Token $token 
	 * @return object
	 * @author Jonathan Geiger
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		// Find the call (javascripts or stylesheets)
		$method = $this->getTag();

		// Grab the files array
		$files = $this->parser->getExpressionParser()->parseExpression();
		
		// Check for 'as [options]'
		if ($this->parser->getStream()->test('as') && $this->parser->getStream()->expect('as'))
		{
			$options = $this->parser->getExpressionParser()->parseExpression();
		}
		else
		{
			$options = FALSE;
		}
				
		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Asset_Node($lineno, $method, $files, $options);
	}
}
