<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class for managing Twig contexts as arrays
 *
 * @package default
 * @author Jonathan Geiger
 */
class Kohana_Twig_Context implements ArrayAccess
{
	/**
	 * @var array Global data, merged just before compilation
	 */
	protected static $global_data;

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
				Kohana_Twig_Context::$global_data[$key2] = $value;
			}
		}
		else
		{
			Kohana_Twig_Context::$global_data[$key] = $value;
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
		Kohana_Twig_Context::$global_data[$key] =& $value;
	}
	
	/**
	 * @var array Local data
	 */
	protected $data;
	
	/**
	 * Constructor
	 *
	 * @param array $data 
	 * @author Jonathan Geiger
	 */
	public function __construct($data = array())
	{
		$this->data = $data;
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
	 * Returns the final data plus global data merged as an array
	 *
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function as_array()
	{
		return $this->data + Kohana_Twig_Context::$global_data;
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
		if (isset($this->data[$key]))
		{
			return $this->data[$key];
		}
		elseif (isset(Kohana_Twig_Context::$global_data[$key]))
		{
			return Kohana_Twig_Context::$global_data[$key];
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
				$this->data[$name] = $value;
			}
		}
		else
		{
			$this->data[$key] = $value;
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
		$this->data[$key] =& $value;

		return $this;
	}
	
	/**
	 * For adherence to the ArrayAccess Interface
	 *
	 * @param string $offset 
	 * @return mixed
	 * @author Jonathan Geiger
	 */
	public function offsetExists($offset)
	{
		return (isset($this->data[$key]) || isset(Kohana_Twig_Context::$global_data[$key]));
	}
	
	/**
	 * For adherence to the ArrayAccess Interface
	 *
	 * @param string $offset 
	 * @return mixed
	 * @author Jonathan Geiger
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}
	
	/**
	 * For adherence to the ArrayAccess Interface
	 *
	 * @param string $offset 
	 * @param string $value 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function offsetSet($offset, $value)
	{
		$this->set($offset, $value);
	}
	
	/**
	 * For adherence to the ArrayAccess Interface
	 *
	 * @param string $offset 
	 * @return void
	 * @author Jonathan Geiger
	 */
	public function offsetUnset($offset)
	{
		if (isset($this->data[$key]))
		{
			unset($this->data[$key]);
		}
		elseif (isset(Kohana_Twig_Context::$global_data[$key]))
		{
			unset(Kohana_Twig_Context::$global_data[$key]);
		}
	}
}