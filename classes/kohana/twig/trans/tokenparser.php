<?php

/**
 * Token parser for the trans tag.
 * 
 * Both block styles are allowed:
 * 
 *     {% trans "String to translate" %}
 * 
 *     {% trans %}
 *         String to translate
 *     {% endtrans %}
 * 
 * The body of the tag will be trim()ed before being passed to __().
 * 
 * @package kohana-twig
 */
class Twig_TokenParser_Trans extends Twig_TokenParser
{
	/**
	 * Parses a token and returns a node.
	 *
	 * @param Twig_Token $token A Twig_Token instance
	 * @return Twig_NodeInterface A Twig_NodeInterface instance
	 */
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();
		$stream = $this->parser->getStream();

		// Allow passing only an expression without an endblock
		if ( ! $stream->test(Twig_Token::BLOCK_END_TYPE)) 
		{
			$body = $this->parser->getExpressionParser()->parseExpression();
		}
		else 
		{
			$stream->expect(Twig_Token::BLOCK_END_TYPE);
			$body = $this->parser->subparse(array($this, 'decideForEnd'), true);
		}

		$stream->expect(Twig_Token::BLOCK_END_TYPE);
		
		// Sanity check the body
		$this->check_trans_string($body, $lineno);
		
		// Pass it off to the compiler
		return new Twig_Node_Trans(array('body' => $body), array(), $lineno, $this->getTag());
	}

	/**
	 * Tests for the endtrans block
	 *
	 * @return  boolean
	 */
	public function decideForEnd($token)
	{
		return $token->test('endtrans');
	}

	/**
	 * Gets the tag name associated with this token parser.
	 *
	 * @param string The tag name
	 */
	public function getTag()
	{
		return 'trans';
	}

	/**
	 * Ensures only "simple" vars are in the body to be translated.
	 *
	 * @param Twig_NodeInterface $body 
	 * @param string $lineno 
	 * @return void
	 * @author Tiger Advertising
	 */
	protected function check_trans_string(Twig_NodeInterface $body, $lineno)
	{
		foreach ($body as $i => $node) 
		{
			if (
				$node instanceof Twig_Node_Text
				||
				($node instanceof Twig_Node_Print && $node->expr instanceof Twig_Node_Expression_Name)
			) {
				continue;
			}

			throw new Twig_SyntaxError(sprintf('The text to be translated with "trans" can only contain references to simple variables'), $lineno);
		}
	}
}
