<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig template controller
 *
 * @package    Kohana-Twig
 * @author     John Heathco <jheathco@gmail.com>
 */
abstract class Kohana_Controller_Template_Twig extends Controller
{
	/**
	 * @var Twig_Environment
	 */
	public $environment = 'default';

	/**
	 * @var boolean  Auto-render template after controller method returns
	 */
	public $auto_render = TRUE;

	/**
	 * @var Twig
	 */
	public $template;

	/**
	 * Setup view
	 *
	 * @return void
	 */
	public function before()
	{
		if ((bool)$this->template)
		{
			// Generate a template name if one wasn't set.
			$this->template = str_replace('_', DIRECTORY_SEPARATOR, $this->request->controller()).DIRECTORY_SEPARATOR.$this->request->action();

			if ( ! (bool)$this->request->directory())
			{
				$this->template = $this->request->directory().DIRECTORY_SEPARATOR.$this->template;
			}
		}

		if ($this->auto_render)
		{
			// Load the twig template.
			$this->template = Twig::factory($this->template, $this->environment);

			// Return the twig environment
			$this->environment = $this->template->environment();
		}

		return parent::before();
	}

	/**
	 * Renders the template if necessary
	 *
	 * @return void
	 */
	public function after()
	{
		if ($this->auto_render)
		{
			// Auto-render the template
			$this->request->response = $this->template;
		}

		return parent::after();
	}

} // End Controller_Twig
