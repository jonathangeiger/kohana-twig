<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig loader.
 *
 * @package  Twig
 * @author   John Heathco <jheathco@gmail.com>
 */
class Twig {

	/**
	 * @var  object  Twig instance
	 */
	public static $instance;

	/**
	 * @var  object  Twig configuration (Kohana_Config object)
	 */
	public static $config;

	public static function instance()
	{
		if ( ! Twig::$instance)
		{
			// Load Twig configuration
			Twig::$config = Kohana::config('twig');

			// Create the the loader
			$loader = new Twig_Loader_Filesystem(Twig::$config->templates, Twig::$config->cache, Twig::$config->auto_reload);

			// Set up Twig
			Twig::$instance = new Twig_Environment($loader, Twig::$config->environment);
			Twig::$instance->addExtension(new Twig_Extension_Trans);
		}

		return Twig::$instance;
	}

	final private function __construct()
	{
		// This is a static class
	}

} // End Twig
