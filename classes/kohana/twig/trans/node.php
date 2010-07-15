<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Represents a trans node.
 *
 * Based off of the core twig code for the trans tag, but modified
 * to use Kohana's __() function.
 * 
 * @package kohana-twig
 */
class Kohana_Twig_Trans_Node extends Twig_Node
{
	/**
	 * Compiles the node to PHP.
	 *
	 * @param Twig_Compiler A Twig_Compiler instance
	 */
	public function compile($compiler)
	{
		$compiler->addDebugInfo($this);

		list($msg, $vars) = $this->compileString($this->body);

		$compiler
			->write('echo __(trim(')
			->subcompile($msg)
			->write('), array(');
		
		foreach ($vars as $var) 
		{
			$compiler
				->string(':'.$var['name'])
				->raw(' => ')
				->subcompile($var)
				->raw(', ');
		}
		
		$compiler->raw("));\n");
	}

	/**
	 * Parses out the body to extract vars to pass to the translation function.
	 *
	 * @param    Twig_NodeInterface $body 
	 * @return   array
	 */
	protected function compileString(Twig_NodeInterface $body)
	{
		if ($body instanceof Twig_Node_Expression_Name || $body instanceof Twig_Node_Expression_Constant) {
			return array($body, array());
		}

		$msg = '';
		$vars = array();
		foreach ($body as $node) {
			if ($node instanceof Twig_Node_Print) {
				$n = $node->expr;
				while ($n instanceof Twig_Node_Expression_Filter) {
					$n = $n->node;
				}
				$msg .= sprintf(':%s', $n['name']);
				$vars[] = new Twig_Node_Expression_Name($n['name'], $n->getLine());
			} else {
				$msg .= $node['data'];
			}
		}

		return array(new Twig_Node(array(new Twig_Node_Expression_Constant(trim($msg), $node->getLine()))), $vars);
	}
}
