<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'default' => array
	(
		'loader' => array
		(
			'class' => 'Twig_Loader_Filesystem',
			'templates' => APPPATH.'views',
			'extension' => 'html',
			'options' => array(),
		),
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
	),
);