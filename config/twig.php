<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'default' => array
	(
		'environment' => array
		(
			/**
			 * debug               : Allow the use of the debug block
			 * trim_blocks         : The first newline after a template tag is removed
			 * charset             : Self explanatory
			 * base_template_class : Template name to use in the compiled classes.
			 * 
			 * cache
			 *  null  : Will create a directory under the temporary system directory.
			 *  false : Turn off caching all-together.
			 *  path  : Absolute path to cache directory (enabled).
			 * 
			 * auto_reload : Update the template when the source code changes
			 */
			'debug'               => FALSE,
			'trim_blocks'         => FALSE,
			'charset'             => 'utf-8',
			'base_template_class' => 'Twig_Template',
			'cache'               => APPPATH.'cache/twig',
			'auto_reload'         => TRUE,
			/**
			 * Allow customization of the Twig Syntax.
			 * Note : This is waiting to be fixed upstream by fabien
			 */
			'syntax' => array
			(
				'tag_block'    => array('{%', '%}'),
				'tag_comment'  => array('{#', '#}'),
				'tag_variable' => array('{{', '}}'),
			)
		),
		/**
		 * These are white-lists and restrict what a template designer has
		 * access to. Everything should be self explanatory.
		 */
		'sandboxing' => array
		(
			'global'  => FALSE,
			'filters' => array(),
			'tags'    => array(),
			/**
			 * The key is the class name and the value is an
			 * array of methods and properties.
			 */
			'methods'    => array(),
			'properties' => array(),
		),
		'loader' => array
		(
			'class' => 'Twig_Loader_Kohana',
			'extension' => 'html',
			'options' => array(),
		),
		'extensions' => array
		(
			'Twig_Extension_Escaper',
			'Kohana_Twig_Extensions',
			'Twig_Extension_Optimizer',
		),
	),
);
