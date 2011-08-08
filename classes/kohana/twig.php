<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class for managing Twig contexts as arrays
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
abstract class Kohana_Twig
{
	/**
	 * @var array Global data, merged just before compilation
	 */
	protected static $_global_data = array();
	
	/**
	 * Factory for Twigs
	 *
	 * @param string $file 
	 * @param string $data 
	 * @param string $env 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public static function factory($file = NULL, $data = NULL, $env = 'default')
	{
		return new Twig($file, $data, $env);
	}

	/**
	 * Sets a global variable, similar to the set() method.
	 * 
	 * The name is a bit of a misnomer, since Twig has no real
	 * concept of "global" variables, just one context available 
	 * to the entire view structure. However, it is implemented
	 * to provide an API similar to Kohana_View, as well as to
	 * allow passing a default set of values (perhaps from the 
	 * 'context' configuration) that can be overridden by set().
	 * 
	 * The global data persists across environments.
	 *
	 * @param	string	 variable name or an array of variables
	 * @param	mixed	 value
	 * @return	View
	 */
	public static function set_global($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $key2 => $value)
			{
				Twig::$_global_data[$key2] = $value;
			}
		}
		else
		{
			Twig::$_global_data[$key] = $value;
		}
	}

	/**
	 * Assigns a global variable by reference, similar to the bind() method.
	 *
	 * @param	string	 variable name
	 * @param	mixed	 referenced variable
	 * @return	View
	 */
	public static function bind_global($key, & $value)
	{
		Twig::$_global_data[$key] =& $value;
	}
	
	/**
	 * @var string The file to render
	 */
	protected $_file;
	
	/**
	 * @var string The extension of the file
	 */
	protected $_extension;
	
	/**
	 * @var array Local data
	 */
	protected $_data = array();
	
	/**
	 * @var string The environment the view is attached to
	 */
	protected $_environment;
	
	/**
	 * Constructor
	 *
	 * @param array $data 
	 * @author Jonathan Geiger
	 */
	public function __construct($file = NULL, $data = NULL, $env = 'default')
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}

		// Allow passing the environment if $data is not needed
		if (is_string($data))
		{
			$env = $data;
			$data = NULL;
		}
		
		if ($data !== NULL)
		{
			// Add the values to the current data
			$this->_data = $data + $this->_data;
		}
		
		// Allow passing a Twig_Environment
		if ($env instanceof Twig_Environment == FALSE)
		{
			// Load the default extension from the config
			$this->_extension = Kohana::$config->load('twig.'.$env.'.loader.extension');
			
			$env = Kohana_Twig_Environment::instance($env);
		}
		
		$this->_environment = $env;
	}
	
	/**
	 * Magic method. See get()
	 *
	 * @param	string	variable name
	 * @return	mixed
	 */
	public function &__get($key)
	{
		return $this->get($key);
	}

	/**
	 * Magic method, calls set() with the same parameters.
	 *
	 * @param	string	variable name
	 * @param	mixed	value
	 * @return	void
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}
	
	/**
	 * Magic method, determines if a variable is set and is not NULL.
	 *
	 * @param   string  variable name
	 * @return  boolean
	 */
	public function __isset($key)
	{
		return (isset($this->_data[$key]) OR isset(Twig::$_global_data[$key]));
	}

	/**
	 * Magic method, unsets a given variable.
	 *
	 * @param   string  variable name
	 * @return  void
	 */
	public function __unset($key)
	{
		unset($this->_data[$key], Twig::$_global_data[$key]);
	}
	
	/**
	 * Magic method, returns the output of render(). If any exceptions are
	 * thrown, the exception output will be returned instead.
	 *
	 * @return  string
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			// Display the exception message
			Kohana::exception_handler($e);

			return '';
		}
	}
	
	/**
	 * Sets the view filename.
	 *
	 * @throws  View_Exception
	 * @param   string  filename
	 * @return  View
	 */
	public function set_filename($file)
	{
		// Store the file path locally
		$this->_file = $file;
		
		// Split apart at the extension if necessary
		if ($extension = pathinfo($file, PATHINFO_EXTENSION))
		{
			$this->set_extension($extension);
		}

		return $this;
	}
	
	/**
	 * Sets a file exension
	 *
	 * @param string $extension 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function set_extension($extension)
	{
		// Strip any leading period
		$extension = ltrim($extension, '.');
		
		// Use this for regenerating the path, using substr 
		// or some other method seems like it could miss some edge-cases
		$pathinfo = pathinfo($this->_file);
		
		if (isset($pathinfo['dirname']) && isset($pathinfo['filename']))
		{
			// Chomp off any extension at the end
			$this->_file = $pathinfo['dirname'].'/'.$pathinfo['filename'];
		}
		
		// Save this for later
		$this->_extension = $extension;
		
		return $this;
	}
	
	/**
	 * Returns the templates filename (sans extension)
	 *
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function filename()
	{
		return $this->_file;
	}
	
	/**
	 * Returns the template's extension
	 *
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function extension()
	{
		return $this->_extension;
	}
	
	/**
	 * Returns the full path of the current template ($filename + $extension)
	 *
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function path()
	{
		if ($this->_extension)
		{
			return $this->_file.'.'.$this->_extension;
		}
		else
		{
			return $this->_file;
		}
	}

	/**
	 * Returns the final data plus global data merged as an array
	 *
	 * @return array
	 * @author Jonathan Geiger
	 */
	public function as_array()
	{
		return $this->_data + Twig::$_global_data;
	}
	
	/**
	 * Returns the environment this view is attached to
	 *
	 * @return Twig_Environment
	 * @author Jonathan Geiger
	 */
	public function environment()
	{
		return $this->_environment;
	}
	
	/**
	 * Searches for the given variable and returns its value.
	 * Local variables will be returned before global variables.
	 *
	 * @param	string	variable name
	 * @return	mixed
	 */
	public function &get($key, $default = NULL)
	{
		if (isset($this->_data[$key]))
		{
			return $this->_data[$key];
		}
		elseif (isset(Twig::$_global_data[$key]))
		{
			return Twig::$_global_data[$key];
		}
		else
		{
			return $default;
		}
	}
	
	/**
	 * Assigns a variable by name. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *	   // This value can be accessed as $foo within the view
	 *	   $view->set('foo', 'my value');
	 *
	 * You can also use an array to set several values at once:
	 *
	 *	   // Create the values $food and $beverage in the view
	 *	   $view->set(array('food' => 'bread', 'beverage' => 'water'));
	 *
	 * @param	string	 variable name or an array of variables
	 * @param	mixed	 value
	 * @return	View
	 */
	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->_data[$name] = $value;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this;
	}
	
	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *	   // This reference can be accessed as $ref within the view
	 *	   $view->bind('ref', $bar);
	 *
	 * @param	string	 variable name
	 * @param	mixed	 referenced variable
	 * @return	View
	 */
	public function bind($key, & $value)
	{
		$this->_data[$key] =& $value;

		return $this;
	}
	
	/**
	 * Renders the view object to a string. Global and local data are merged
	 * and extracted to create local variables within the view file.
	 *
	 * Note: Global variables with the same key name as local variables will be
	 * overwritten by the local variable.
	 *
	 * @throws   View_Exception
	 * @param    view filename
	 * @return   string
	 */
	public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}
		
		if (empty($this->_file))
		{
			throw new Kohana_View_Exception('You must set the file to use within your view before rendering');
		}
		
		// Combine local and global data and capture the output
		return $this->_environment->loadTemplate($this->path())->render($this->as_array());
	}
}