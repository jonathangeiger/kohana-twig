<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig Loader
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Environment
{
	/**
	 * Loads Twig_Environments based on the 
	 * configuration key they represent
	 *
	 * @param string $env 
	 * @return Twig_Environment
	 * @author Jonathan Geiger
	 */
	public static function instance($env = 'default')
	{
		static $instances;

		if (!isset($instances[$env]))
		{
			$config = Kohana::config('twig.'.$env);
			
			// Create the the loader
			$loader = $config['loader']['class'];
			$options = $config['loader']['options'];
			
			$loader = new $loader($options);

			// Set up the instance
			$twig = $instances[$env] = new Twig_Environment($loader, $config['environment']);

			foreach ($config['extensions'] as $extension)
			{
				// Load extensions
				$twig->addExtension(new $extension);
			}
		}

		return $instances[$env];
	}
	
	final private function __construct()
	{
		// This is a static class
	}
}