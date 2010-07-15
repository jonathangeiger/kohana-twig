# Custom Tags and Filters

This module comes with a few custom filters and tags that aim to integrate Kohana and Twig.

### `html` and `form`

Allows you to use the html and form helpers in the following format.

	{% html.anchor "http://google.com", "Google" %}
	=> <a href="http://google.com">Google</a>
	
	{% form.input "first_name" %}
	=> <input type="text" name="first_name" />

All html and form helper functions are available and take arguments as you would expect.

### `cache`

This makes use of the Kohana fragment cache and provides a simplified interface
for creating cacheable blocks of content.

	{% cache "key" %}
		This will be cached.
	{% endcache %}

You can also pass a lifetime value in seconds as the second argument.

	{% cache "key", 3600 %}
		This will be cached for one hour.
	{% endcache %}

### `url`

The url tag is a way to generate URIs from your routes. The first argument is the 
route name and the second is a `key:value` array.

	{% url "default", ["action": "register"] %}
	=> 	http://example.com/welcome/register

As shown above, you can also omit optional keys to so the route will use its default segment. 
Notice that we didn't specify a controller above, and the default—`welcome`—was used.

#### Generating links

Unfortunately you can't mix the url block with the html block and so if you need
to use reverse routing you'll need to construct the html anchors manually like so:

	<a href="{% url "default", ["action":"register"] %}">Register</a>