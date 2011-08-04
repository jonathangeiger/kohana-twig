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
	 * @var string  Template path that points to the action view 
	 */
	protected $_template_path;

	/**
	 * @var boolean  Standalone context
	 */
	private $__context;

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
        return isset( $this->__context[$key] )
             ? $this->__context[$key]
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
        return $this->__context[$key] = $value;
    }
    
	/**
	 * Before the action gets executed we need run a few processes.
	 * 
	 * @uses  $this->_set_template_path
	 * @return  void
	 */
	public function before()
	{
	    
        // Load the path that points to the view (if applicable)
        $this->_set_template_path( $this->request->controller(), $this->request->action(), 'html' );
        parent::before();
        
	}

	/**
	 * Renders the template if necessary
	 *
	 * @return void
	 */
	public function after()
	{
	    if((bool)$this->__template_path)
	    {
            if((bool)$this->_auto_render)
            {
                $this->request->response( Twig::factory($this->_template_path, $this->__context, $this->_environment) );
            }
	    }
	}
    
	/**
	 * Load the path that points to the view (if applicable)
	 * 
	 * @param   string  $path       Directory path
	 * @param   string  $file       File name
	 * @param   string  $extension  File Extension
	 * @usedby  $this->before
	 * @return  mixed
	 */
    protected function _set_template_path($path,$file,$extension="html")
    {
        $path = "views".DIRECTORY_SEPARATOR.$path;
        if( Kohana::find_file($path,$file,$extension) )
        {
            $this->__template_path = $path.DIRECTORY_SEPARATOR.$file.".".$extension;
        }
    }
    
} // End Controller_Twig
