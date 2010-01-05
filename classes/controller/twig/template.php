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
	protected $twig;

	/**
	 * @var boolean  Auto-render template after controller method returns
	 */
	protected $auto_render = TRUE;

	/**
	 * @var array|object  Stores mapping of template vars => values
	 */
	protected $context;
	
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
		// Setup the Twig loader environment
		$this->twig = Kohana_Twig::instance();
		
		// Search for a default context
		$config = Kohana::config('context');
		
		// Search for a default context based on the URI
		if (isset($config[$request->uri]))
		{
			$this->context = $config[$request->uri];
		}
		// Try based on controller/action
		else if (isset($config[$request->controller.'/'.$request->action]))
		{
			$this->context = $config[$request->controller.'/'.$request->action];
		}

		// Ensure it's cast to the proper type
		if (Kohana_Twig::$config->context_object)
		{
			// Context treated as an object
			$this->context = (object)$this->context;
		}
		else
		{
			// Context treated as an array
			$this->context = (array)$this->context;
		}

		// Auto-generate template filename ('index' method called on Controller_Admin_Users looks for 'admin/users/index')
		$this->template = $request->controller.'/'.$request->action.Kohana_Twig::$config->suffix;

		// Prepend directory if needed
		if ( !empty($request->directory))
		{
			$this->template = $request->directory.'/'.$this->template;
		}
		
		// Convert underscores to slashes
		$this->template = str_replace('_', '/', $this->template);

		parent::__construct($request);
	}

	public function after()
	{
		if ($this->auto_render)
		{
			// Auto-render the template
			$this->request->response = $this->twig->loadTemplate($this->template)->render((array) $this->context);
		}
	}

} // End Controller_Twig
