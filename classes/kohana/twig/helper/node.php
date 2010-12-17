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
		$params = $this->getNode('expression')->getIterator();
	
		// Output the route		
		$compiler->write('echo '.$this->getNodeTag().'::'.$this->getAttribute('method').'(');
		
		if ($params->count() > 1)
		{
			foreach($params as $i => $row)
			{ 
				$compiler->subcompile($row);
				
				if (($params->count() - 1) !== $i)
				{
					$compiler->write(',');
				}
			}
		}
		else
		{
			$compiler->subcompile($this->getNode('expression'));
		}
		
		$compiler->write(')')->raw(';');
	}
}
