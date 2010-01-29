<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Compiler for the two asset tags
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Asset_Node extends Twig_Node
{
	/**
	 * @var object The method to be called
	 */
	protected $method;
	
	/**
	 * @var object An array of files to render
	 */
	protected $files;
	
	/**
	 * @var object An array of options
	 */
	protected $options;

	/**
	 * Constructor
	 * 
	 * @param string $lineno 
	 * @param string $method 
	 * @param string $files 
	 * @param string $options 
	 * @author Jonathan Geiger
	 */
	public function __construct($lineno, $method, $files, $options = NULL)
	{
		parent::__construct($lineno);

		$this->method = $method;
		$this->files = $files;
		$this->options = $options;
	}

	/**
	 * @param string $compiler 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function compile($compiler)
	{
		// Output the args first
		$compiler
			->write('$asset_files = ')
			->subcompile($this->files)
			->raw(";\n");
			
		if ($this->options)
		{
			$compiler
				->write('$asset_options = ')
				->subcompile($this->options)
				->raw(";\n");
		}
		else
		{
			$compiler
				->write('$asset_options = NULL')
				->raw(";\n");
		}

		// Output the asset call
		$compiler
			->write('echo asset::'.$this->method.'($asset_files, $asset_options)')
			->raw(";\n");
	}
}
