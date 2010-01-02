<?php

class Kohana_Twig_URL_Node extends Twig_Node
{
	protected $route;
	protected $params;

	public function __construct($lineno, $tag, $route, $params = array())
	{
		parent::__construct($lineno);

		$this->route = $route;
		$this->params = $params;
	}

	public function compile($compiler)
	{
		if ($this->params)
		{
			$compiler
				->write('$route_params = ')
				->subcompile($this->params)
				->raw(";\n");
		}
		else
		{
			$compiler
				->write('$route_params = array()')
				->raw(";\n");
		}

		// Output the route
		$compiler
			->write('echo Kohana::$base_url.Route::get(')
			->subcompile($this->route)
			->write(')->uri($route_params)')
			->raw(";\n");
	}
}
