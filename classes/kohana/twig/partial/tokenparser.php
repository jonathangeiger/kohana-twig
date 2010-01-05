<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Partial_TokenParser extends Twig_TokenParser
{
  public function parse(Twig_Token $token)
  {
    $expr = $this->parser->getExpressionParser()->parseExpression();

    $sandboxed = false;
    if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'sandboxed'))
    {
      $this->parser->getStream()->next();
      $sandboxed = true;
    }

    $variables = null;
    if ($this->parser->getStream()->test(Twig_Token::NAME_TYPE, 'with'))
    {
      $this->parser->getStream()->next();
      $variables = $this->parser->getExpressionParser()->parseExpression();
    }

    $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

    return new Kohana_Twig_Partial_Node($expr, $sandboxed, $variables, $token->getLine(), $this->getTag());
  }

  public function getTag()
  {
    return 'partial';
  }
}
