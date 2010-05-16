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

Installation
------------

1. `git submodule add https://ThePixelDeveloper@github.com/ThePixelDeveloper/kohana-twig.git modules/twig`
2. `git submodule update --init`
3. Enable twig in your bootstrap.php file
4. Extend the Controller\_Twig\_Template