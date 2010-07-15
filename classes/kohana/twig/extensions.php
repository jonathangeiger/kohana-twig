<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Loads a default set of filters and extensions for 
 * Twig based on Kohana helpers
 *
 * @package kohana-twig
 * @author Jonathan Geiger
 */
class Kohana_Twig_Extensions extends Twig_Extension
{
	/**
	 * Returns the added token parsers
	 *
	 * @return array
	 * @author Jonathan Geiger
	 */
	public function getTokenParsers()
	{
		return array(
			new Kohana_Twig_HTML_TokenParser(),
			new Kohana_Twig_Form_TokenParser(),
			new Kohana_Twig_URL_TokenParser(),
			new Kohana_Twig_Cache_TokenParser(),
			new Kohana_Twig_Trans_TokenParser(),
			new Kohana_Twig_Request_TokenParser(),
		);
	}
	
	/**
	 * Returns the added filters
	 *
	 * @return array
	 * @author Jonathan Geiger
	 */
	public function getFilters()
	{
		return array(
			// Translation
			'translate' => new Twig_Filter_Function('__'),
			'trans' => new Twig_Filter_Function('__'),
			
			// Date and time
			'timestamp' => new Twig_Filter_Function('strtotime'),
			'timesince' => new Twig_Filter_Function('Kohana_Twig_Filters::timesince'),
			'fuzzy_timesince' => new Twig_Filter_Function('date::fuzzy_span'),
			
			// Strings
			'plural' => new Twig_Filter_Function('inflector::plural'),
			'singular' => new Twig_Filter_Function('inflector::singular'),
			'humanize' => new Twig_Filter_Function('inflector::humanize'),
			
			// HTML 
			'obfuscate' => new Twig_Filter_Function('html::obfuscate'),			
			
			// Numbers
			'ordinal' => new Twig_Filter_Function('Kohana_Twig_Filters::ordinal'),
			'num_format' => new Twig_Filter_Function('num::format'),
			
			// Text
			'limit_words' => new Twig_Filter_Function('text::limit_words'),
			'limit_chars' => new Twig_Filter_Function('text::limit_chars'),
			'auto_link' => new Twig_Filter_Function('text::auto_link'),
			'auto_p' => new Twig_Filter_Function('text::auto_p'),
			'bytes' => new Twig_Filter_Function('text::bytes'),

			'urltitle' => new Twig_Filter_Function('url::title'),
		);
	}
	
	/**
	 * @return string
	 * @author Jonathan Geiger
	 */
	public function getName()
	{
		return 'kohana_twig';
	}
}
