<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Extensions extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Kohana_Twig_URL_TokenParser(),
			new Kohana_Twig_Asset_Javascript_TokenParser(),
			new Kohana_Twig_Asset_Stylesheet_TokenParser(),
		);
	}
	
	public function getFilters()
	{
		return array(
			// Translation
			'translate' => new Twig_Filter_Function('__'),
			
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
		);
	}

	public function getName()
	{
		return 'kohana_twig';
	}
}
