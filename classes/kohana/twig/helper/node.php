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
	 * The name of the class
	 * @var object
	 */
	protected $tag;
	
	/**
	 * The method to be invoked on the class
	 * @var object
	 */
	protected $method;
	
	/**
	 * Any params to be passed to the class
	 * @var array
	 */
	protected $params;

	/**
	 * @param string $lineno 
	 * @param string $tag 
	 * @param string $method 
	 * @param string $params 
	 * @author Jonathan Geiger
	 */
	public function __construct($lineno, $tag, $method, $params = array())
	{
		parent::__construct($lineno);

		$this->tag = $tag;
		$this->method = $method;
		$this->params = $params;
	}

	/**
	 * @param object $compiler 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function compile($compiler)
	{
		// Output the route
		$compiler
			->write('echo '.$this->tag.'::'.$this->method->getValue().'(');
			
		// I suppose this is how you compile multiexpressions?
		$count = count($this->params) - 1;
		foreach ($this->params as $i => $param)
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
