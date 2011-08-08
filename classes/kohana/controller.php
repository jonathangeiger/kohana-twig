<?php defined('SYSPATH') or die('No direct script access.');

abstract class Kohana_Controller
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
	public $__context;

	/**
	 * @var  Request  Request that created the controller
	 */
	public $request;

	/**
	 * @var  Response The response that will be returned from controller
	 */
	public $response;
    
	/**
	 * Creates a new controller instance. Each controller must be constructed
	 * with the request object that created it.
	 *
	 * @param   Request   $request  Request that created the controller
	 * @param   Response  $response The request's response
	 * @return  void
	 */
	public function __construct(Request $request, Response $response)
	{
		// Assign the request to the controller
		$this->request = $request;

		// Assign a response to the controller
		$this->response = $response;
	}

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
        
	}

	/**
	 * Renders the template if necessary
	 *
	 * @return void
	 */
	public function after()
    {
        // Output the template automatically (if applicable)
	    if((bool)$this->_template_path)
	    {
            if((bool)$this->_auto_render)
            {
                $this->response->body( Twig::factory($this->_template_path, $this->__context, $this->_environment)->render() );
            }
	    }
	    
	}
    
	/**
	 * Load the path that points to the view (if applicable).
	 * We return a bool so that the method can be reused even
	 * if there's the need to extend the method
	 * 
	 * @param   string  $path       Directory path
	 * @param   string  $file       File name
	 * @param   string  $extension  File Extension
	 * @usedby  $this->before
	 * @return  bool  This boolean determines whether the file exists or not
	 */
    protected function _set_template_path($path,$file,$extension="html")
    {
        $exists = Kohana::find_file("views".DIRECTORY_SEPARATOR.$path,$file,$extension);
        if( $exists )
        {
            $this->_template_path = $path.DIRECTORY_SEPARATOR.$file.".".$extension;
        }
        return $exists;
    }
    
} // End Controller
