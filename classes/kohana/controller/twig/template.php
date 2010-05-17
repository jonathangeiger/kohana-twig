<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig template controller
 *
 * @package    Kohana-Twig
 * @author     John Heathco <jheathco@gmail.com>
 */
abstract class Kohana_Controller_Twig_Template extends Controller
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
	 * @var Twig_View
	 */
	public $template;

	/**
	 * Setup view
	 *
	 * @return void
	 */
	public function before()
	{
		if (empty($this->template))
		{
			// Generate a template name if one wasn't set.
			$this->template = $this->request->controller.'/'.$this->request->action;
		}

		if ($this->auto_render)
		{
			// Load the twig template.
			$this->template = Twig_View::factory($this->template, $this->environment);

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
