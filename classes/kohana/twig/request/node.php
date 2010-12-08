<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parses a {% request %} tag
 *
 * Based on Kohana_Twig_URL_Node
 *
 * @package kohana-twig
 * @author MasterCJ
 */
class Kohana_Twig_Request_Node extends Twig_Node
{
	/**
	 * Compiles the tag
	 *
	 * @param object $compiler 
	 * @return void
	 * @author MasterCJ
	 */
	public function compile($compiler)
	{
		// Render weee
		$compiler
			->write('echo Request::Factory(')
			->subcompile($this->getNode('uri'))
			->write(')->execute()->response')
			->raw(";\n");
	}
}
