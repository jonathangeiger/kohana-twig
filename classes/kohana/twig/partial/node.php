<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Partial_Node extends Twig_Node
{
  protected $expr;
  protected $sandboxed;
  protected $variables;

  public function __construct(Twig_Node_Expression $expr, $sandboxed, $variables, $lineno, $tag = null)
  {
    parent::__construct($lineno, $tag);

    $this->expr = $expr;
    $this->sandboxed = $sandboxed;
    $this->variables = $variables;
  }

  public function __toString()
  {
    return get_class($this).'('.$this->expr.')';
  }

  public function compile($compiler)
  {
    if (!$compiler->getEnvironment()->hasExtension('sandbox') && $this->sandboxed)
    {
      throw new Twig_SyntaxError('Unable to use the sanboxed attribute on an include if the sandbox extension is not enabled.', $this->lineno);
    }

    $compiler->addDebugInfo($this);

    if ($this->sandboxed)
    {
      $compiler
        ->write("\$sandbox = \$this->env->getExtension('sandbox');\n")
        ->write("\$alreadySandboxed = \$sandbox->isSandboxed();\n")
        ->write("\$sandbox->enableSandbox();\n")
      ;
    }

    $compiler
      ->write('$this->env->loadTemplate("partials/".')
      ->subcompile($this->expr)
      ->raw(')->display(')
    ;

    if (null === $this->variables)
    {
      $compiler->raw('$context');
    }
    else
    {
      $compiler->subcompile($this->variables);
    }

    $compiler->raw(");\n");

    if ($this->sandboxed)
    {
      $compiler
        ->write("if (!\$alreadySandboxed)\n", "{\n")
        ->indent()
        ->write("\$sandbox->disableSandbox();\n")
        ->outdent()
        ->write("}\n")
      ;
    }
  }
}
