<?php

class Twig_Node_BlockTrans extends Twig_Node
{
	protected $data;
	protected $vals;

	public function __construct($lineno, $tag, $data, $vals = array())
	{
		parent::__construct($lineno);

		$this->data = $data;
		$this->vals = $vals;
	}

	public function compile($compiler)
	{
		$compiler
			->addDebugInfo($this)
			->write('$vals = array()')
			->raw(";\n");

		// Each key is the name to substitute and value is the variable/expression
		foreach ($this->vals as $key => $val)
		{
			$compiler
				->write('$vals[')
				->string($key)
				->raw('] = ')
				->subcompile($val)
				->raw(";\n");
		}

		// Compile what's in the body and grab it from the buffer to use as the language string
		$compiler
			->write("ob_start();\n")
			->subcompile($this->data)
			->write('$data = ob_get_contents();')
			->raw("\n")
			->write("ob_end_clean();\n");

		// Call the __() method for translation
		$compiler->write('echo __($data, $vals);');
	}
}
