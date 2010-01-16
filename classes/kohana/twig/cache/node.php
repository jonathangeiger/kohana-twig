<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Cache_Node extends Twig_Node
{
	protected $key;
	protected $data;
	protected $lifetime;

	public function __construct($lineno, $tag, $key, $lifetime, $data)
	{
		parent::__construct($lineno);

		$this->key = $key;
		$this->data = $data;
		$this->lifetime = $lifetime;
	}

	public function compile($compiler)
	{
		$compiler
			->write('if (!fragment::load(')
			->subcompile($this->key);
			
		if ($this->lifetime)
		{
			$compiler 
				->write(', ')
				->subcompile($this->lifetime)
				->write(')) {');
		}
		else
		{
			$compiler 
				->write(')) {');
		}
			
		$compiler
			->raw("\n")
			->subcompile($this->data)
			->raw("\n")
			->write('fragment::save();')
			->raw("\n}\n");
	}
}
