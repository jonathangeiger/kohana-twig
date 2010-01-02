<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Asset_Node extends Twig_Node
{
	protected $method;
	protected $files;
	protected $options;

	public function __construct($lineno, $method, $files, $options = NULL)
	{
		parent::__construct($lineno);

		$this->method = $method;
		$this->files = $files;
		$this->options = $options;
	}

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
