<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Cache_Node extends Twig_Node
{
	protected $key;
	protected $data;

	public function __construct($lineno, $tag, $key, $data)
	{
		parent::__construct($lineno);

		$this->key = $key;
		$this->data = $data;
	}

	public function compile($compiler)
	{
		$compiler
			->write('if (!fragment::load(')
			->subcompile($this->key)
			->write(')) {')
			->raw("\n")
			->subcompile($this->data)
			->raw("\n")
			->write('fragment::save();')
			->raw("\n}\n");
	}
}
