<?php

class Kohana_Twig_Node_Trans extends Twig_Node
{
	protected $data;

	public function __construct($lineno, $tag, $data)
	{
		parent::__construct($lineno);

		$this->data = $data;
	}

	public function compile($compiler)
	{
		// Call the __() method for translation
		$compiler
			->write('echo __(')
			->subcompile($this->data)
			->raw(');');
	}
}
