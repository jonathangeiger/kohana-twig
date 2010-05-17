# Configuration

#### Environment

Name                | Description
--------------------|------------------------------------------
debug               | Allow the use of the `{% debug %}` block
trim_blocks         | Will remove new lines after a block (mimic PHP behaviour)
charset             | Self explanatory
base_template_class | Template name to use in the compiled classes
cache               | 1. **null** : Will create a directory under the system /tmp directory
                    | 2. **false** : Turn off caching all-together
                    | 3. **path** : Absolute path to cache directory
auto_reload         | Update the template when the source code changes


#### Sandboxing

Sandboxing can be enabled globally or can be used on a per include basis as follows:

	{% include "template.html" sandboxed %}

For more information on sandboxing please check the
[designer](http://www.twig-project.org/book/02-Twig-for-Template-Designers)
and [developer](http://www.twig-project.org/book/03-Twig-for-Developers) docs.

[!!] The methods and properties array takes a class name as the key and an array
of values.

Name       | Description
-----------|------------------------------------------
global     | Should sandboxing be enabled globally?
filters    | White-listed filters
tags       | 〃 tags
methods    | 〃 methods
properties | 〃 properties


#### Loader

The options here should not need to be changed and are only really for advanced
usage.

Name      | Description
----------|------------------------------------------
class     | Used to load the template files. Should implement the `Twig_LoaderInterface` interface
extension | Template extension, default is html
options   | Array of options passed the loader `__construct`


#### Extensions

The extensions item is just an array of extension class names. 