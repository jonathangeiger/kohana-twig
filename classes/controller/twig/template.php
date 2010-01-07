<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig template controller
 *
 * @package    Kohana-Twig
 * @author     John Heathco <jheathco@gmail.com>
 */
abstract class Controller_Twig_Template extends Controller 
{
	/**
	 * @var Twig_Environment
	 */
	protected $twig = 'default';

	/**
	 * @var boolean  Auto-render template after controller method returns
	 */
	protected $auto_render = TRUE;
	
	/**
	 * @var string The template to render
	 */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param Request $request 
	 * @author Jonathan Geiger
	 */
	public function __construct(Request $request)
	{
		// Auto-generate template filename
		if (empty($this->template))
		{
			$this->template = $request->controller.'/'.$request->action;

			// Prepend directory if needed
			if (!empty($request->directory))
			{
				$this->template = $request->directory.'/'.$this->template;
			}

			// Convert underscores to slashes
			$this->template = str_replace('_', '/', $this->template);
		}
		
		// Create the initial context object
		$this->template = Twig_View::factory($this->template, $this->twig);
		$this->twig = $this->template->environment();

		parent::__construct($request);
	}

	/**
	 * Renders the template if necessary
	 *
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function after()
	{	
		if ($this->auto_render)
		{
			// Search for a default context
			$config = Kohana::config('context');
			
			if (isset($config[$this->request->uri]))
			{
				$this->template->set_default($config[$this->request->uri]);
			}
			else if (isset($config[$this->template->path()]))
			{
				$this->template->set_default($config[$this->template->path()]);
			}
			
			// Auto-render the template
			$this->request->response = $this->template->render();
		}
	}

} // End Controller_Twig
