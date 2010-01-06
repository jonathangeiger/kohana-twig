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
	 * @var object  Stores mapping of template vars => values
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

		// Create the initial context object
		$context = Kohana_Twig::$config->context;
		$this->context = new $context;

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
			$this->request->response = $this->twig->loadTemplate($this->template)->render($this->context->as_array());
		}
	}

} // End Controller_Twig
