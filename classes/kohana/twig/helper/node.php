<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Helper_Node extends Twig_Node
{
	protected $tag;
	protected $method;
	protected $params;

	public function __construct($lineno, $tag, $method, $params = array())
	{
		parent::__construct($lineno);

		$this->tag = $tag;
		$this->method = $method;
		$this->params = $params;
	}

	public function compile($compiler)
	{
		// Output the route
		$compiler
			->write('echo '.$this->tag.'::'.$this->method->getValue().'(');
			
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
