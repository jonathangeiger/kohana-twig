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
	protected $_environment = 'default';

	/**
	 * @var boolean  Auto-render template after controller method returns
	 */
	protected $_auto_render = TRUE;

	/**
	 * @var Twig
	 */
	protected $_template;

	/**
	 * Have a standalone action context. A context should not be within a template because not
	 * all request require a template, thus, we allow the controller to handle the context for
	 * later manipulation. We use magic methods to manipulate the data:
	 *
	 *     class Controller_Object{
     *         public function action_index()
     *         {
     *             // Setter
     *             $this->var1 = "test";
     *             $this->var2 = array(
     *                 'k1' => 'v1',
     *                 'k2' => 'v2',
     *                 'k3' => 'v3',
     *             );
     *         }
	 *     }
	 *
	 * @param   mixed  $key
	 * @return  array
	 */
    public function __get( $key )
    {
        return isset( $this->__data[$key] )
             ? $this->__data[$key]
             : array();
    }
    
	/**
	 * Have a standalone action context. A context should not be within a template because not
	 * all request require a template, thus, we allow the controller to handle the context for
	 * later manipulation. We use magic methods to manipulate the data:
	 *
	 *     class Controller_Object{
     *         public function action_index()
     *         {
     *             // Getter
     *             $var1 = $this->var1;
     *             // modify the var1
     *             $this->var1 = $var1;
     *         }
	 *     }
	 *
	 * @param   string  $key
	 * @param   mixed   $value
	 * @return  mixed
	 */
    public function __set( $key,$value )
    {
        return $this->__data[$key] = $value;
    }
    
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
