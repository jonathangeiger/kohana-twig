<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'environment' => array
	(
		'debug'               => FALSE,
		'trim_blocks'         => FALSE,
		'charset'             => 'utf-8',
		'base_template_class' => 'Twig_Template',
		'cache'               => APPPATH.'cache/twig',
		'auto_reload'         => TRUE,
	),
	'extensions' => array
	(
		'Twig_Extension_Escaper',
		'Kohana_Twig_Extensions',
	),
	'templates'      => APPPATH.'views',
	'suffix'         => '.html',
	'context' 		 => 'Kohana_Twig_Context',
);