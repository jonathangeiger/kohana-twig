<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Compiler for helpers, which allows a public static methods to be called on a class
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Helper_Node extends Twig_Node
{
	/**
	 * @param object $compiler 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function compile($compiler)
	{
		// Output the route
		$compiler
			->write('echo '.$this->getNode('tag').'::'.$this->getNode('method')->getValue().'(');
			
		// I suppose this is how you compile multiexpressions?
		$count = count($this->getNode('params')) - 1;
		foreach ($this->getNode('params') as $i => $param)
		{
			$compiler->subcompile($param);
			
			if ($count != $i)
			{
				$compiler->write(',');
			}
		}
			
		$compiler
			->write(')')
			->raw(";\n");
	}
}
