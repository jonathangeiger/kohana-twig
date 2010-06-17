<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parses a {% url %} tag
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Url_Node extends Twig_Node
{
	/**
	 * The route to invoke
	 * @var object
	 */
	protected $route;
	
	/**
	 * Parameters to pass to the route
	 * @var object
	 */
	protected $params;

	/**
	 * Compiles the tag
	 *
	 * @param object $compiler 
	 * @return void
	 * @author Jonathan Geiger
	 */
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
