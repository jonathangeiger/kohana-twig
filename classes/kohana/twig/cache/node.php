<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Compiler for {% cache "some-key" %} Some text {% endcache %}
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Cache_Node extends Twig_Node
{
	/**
	 * The cache key
	 * @var object
	 */
	protected $key;
	
	/**
	 * The data to cache
	 * @var object
	 */
	protected $data;
	
	/**
	 * The cache lifetime
	 * @var object
	 */
	protected $lifetime;

	/**
	 * @param string $lineno 
	 * @param string $tag 
	 * @param string $key 
	 * @param string $lifetime 
	 * @param string $data 
	 * @author Jonathan Geiger
	 */
	public function __construct($lineno, $tag, $key, $lifetime, $data)
	{
		parent::__construct($lineno);

		$this->key = $key;
		$this->data = $data;
		$this->lifetime = $lifetime;
	}

	/**
	 * @param object $compiler 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function compile($compiler)
	{
		$compiler
			->write('if (!fragment::load(')
			->subcompile($this->key);
		
		// Lifetime will be false if it wasn't parsed
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
