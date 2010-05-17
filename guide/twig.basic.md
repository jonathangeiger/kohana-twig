### Controller

The twig module comes with a controller which you can easily extend. It's similar
to how the current template controller works so you wont encounter too many issues
switching over.

[!!] Template names are generated automatically by default. The example below would
look for welcome/index.html

	<?php defined('SYSPATH') or die('No direct script access.');

	Class Controller_Welcome extends Controller_Template_Twig
	{
		public function action_index()
		{
			$this->template->variable = 'Hello World';
		}
	}

If you would prefer to load a custom template, then you can do so by assigning
$this->template a Twig object.

	$this->template = Twig::factory('welcome');
