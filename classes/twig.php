<?php
/**
 * Twig loader
 *
 * @package    Kohana-Twig
 * @author     John Heathco <jheathco@gmail.com>
 */
class Twig
{
	/**
	 * @var Twig_Environment  Singleton environment instance
	 */
	public static $instance;

	public static function load()
	{
		require_once MODPATH.'twig/vendor/Twig/Autoloader.php';

		// Register the autoloader
		Twig_Autoloader::register();
	}

	public static function instance()
	{
		if ( ! isset(self::$instance))
		{
			// Initialize Twig environment
			$loader = new Twig_Loader_Filesystem(Kohana::config('twig.templates'), Kohana::config('twig.cache'), Kohana::config('twig.auto_reload'));
			$instance = new Twig_Environment($loader, Kohana::config('twig.environment'));

			$instance->addExtension(new Twig_Extension_Trans());
		}

		return $instance;
	}
}