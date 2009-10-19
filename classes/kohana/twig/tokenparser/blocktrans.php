<?php

class Kohana_Twig_TokenParser_BlockTrans extends Twig_TokenParser
{
	public function parse(Twig_Token $token)
	{
		$lineno = $token->getLine();

		$vals = array();

		// Format of tag should be {% blocktrans with [var/expr1] as ':key1' and [var/expr2] as ':key2' %}Example :key1 :key2{% endblocktrans %}

		if ($this->parser->getStream()->test('with'))
		{
			$this->parser->getStream()->expect('with');

			do
			{
				// Grab the expression we will be substituting in
				$value = $this->parser->getExpressionParser()->parseExpression();

				$this->parser->getStream()->expect('as');

				// Grab the key we're substituting in form
				$key = $this->parser->getStream()->expect(Twig_Token::STRING_TYPE);

				// Add it to the array
				$vals[$key->getValue()] = $value;

			} while ($this->parser->getStream()->test('and') AND $this->parser->getStream()->expect('and'));
		}

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		// Grab the body
		$data = $this->parser->subparse(array($this, 'decideBlockEnd'), TRUE);

		$this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

		return new Kohana_Twig_Node_BlockTrans($lineno, $this->getTag(), $data, $vals);
	}

	public function getTag()
	{
		return 'blocktrans';
	}

	public function decideBlockEnd($token)
	{
		return $token->test('endblocktrans');
	}
}
