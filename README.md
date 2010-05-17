Twig Module
===========

From [twig-project.org](http://twig-project.org)

> **Fast**: Twig compiles templates down to plain optimized PHP code. The overhead
compared to regular PHP code was reduced to the very minimum.

> **Secure**: Twig has a sandbox mode to evaluate untrusted template code. This allows
Twig to be used as a templating language for applications where users may modify
the template design.

> **Flexible**: Twig is powered by a flexible lexer and parser. This allows the developer
to define its own custom tags and filters, and create its own DSL.

Credit goes to [Jonathan Geiger](http://github.com/jonathangeiger/kohana-twig) and
[John Heathco](http://github.com/jheathco/kohana-twig) for creating the original modules.
This fork contains the following improvements.

* Sandbox configuration
* Syntax 〃
* Kohana template loader. Now templates aren't restricted to one directory
* Updated to follow the Kohana convention

Installation
------------

1. `git submodule add https://ThePixelDeveloper@github.com/ThePixelDeveloper/kohana-twig.git modules/twig`
2. `git submodule update --init`
3. Enable twig in your bootstrap.php file
4. Extend the Controller\_Template\_Twig

Usage
-----

Pretty similar to using the Controller\_Template class.

    class Controller_Example extends Controller_Template_Twig
    {
      // Template names are generated automatically if not specified. So this
      // action would map to: example/index.html
      public function action_index()
      {
        $this->template->variable = "Hello World";
      }
    }

Not Happy?
---------

Either [file a bug report](http://github.com/ThePixelDeveloper/kohana-twig/issues)
or try an alternative project:

* [kotwig](http://github.com/Burgestrand/kotwig) by [Burgestrand](http://github.com/Burgestrand)