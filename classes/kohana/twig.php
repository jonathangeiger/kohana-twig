<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig loader.
 *
 * @package  Kohana-Twig
 * @author   John Heathco <jheathco@gmail.com>
 */
class Kohana_Twig {

	/**
	 * @var  object  Kohana_Twig instance
	 */
	public static $instance;

	/**
	 * @var  object  Kohana_Twig configuration (Kohana_Config object)
	 */
	public static $config;

	public static function instance()
	{
		if ( ! Kohana_Twig::$instance)
		{
			// Load Twig configuration
			Kohana_Twig::$config = Kohana::config('twig');

			// Create the the loader
			$loader = new Twig_Loader_Filesystem(Kohana_Twig::$config->templates, Kohana_Twig::$config->cache, Kohana_Twig::$config->auto_reload);

			// Set up Twig
			Kohana_Twig::$instance = new Twig_Environment($loader, Kohana_Twig::$config->environment);

			foreach (Kohana_Twig::$config->extensions as $extension)
			{
				// Load extensions
				Kohana_Twig::$instance->addExtension(new $extension);
			}
		}

		return Kohana_Twig::$instance;
	}

	final private function __construct()
	{
		// This is a static class
	}

} // End Kohana_Twig
