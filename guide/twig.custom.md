# Custom Tags and Filters

This module comes with a few custom filters and tags that aim to integrate Kohana and Twig.

## html and form
To provide an array argument without keys use: `["val1", "val2"]`

If you need to provide keys, then use a hash `{"key1":"val1", "key2":"val2"}`

With that in mind. A usage example:

	{% html.anchor "http://google.com", "Google", {"class":"link"} %}

Output:
    
    <a href="http://google.com" class="link">Google</a>

All html and form helper functions are available and take arguments as you would expect.

## cache

This makes use of the Kohana fragment cache and provides a simplified interface
for creating cacheable blocks of content.

	{% cache "key" %}
		This will be cached.
	{% endcache %}

You can also pass a lifetime value in seconds as the second argument.

	{% cache "key", 3600 %}
		This will be cached for one hour.
	{% endcache %}

## url

The url tag is a way to generate URIs from your routes. The first argument is the 
route name and the second is a `key:value` array.

	{% url "default", {"action": "register"} %}

Output:

	http://example.com/welcome/register

As shown above, you can also omit optional keys to so the route will use its default segment. 

## Generating links

Unfortunately you can't mix the url block with the html block and so if you need
to use reverse routing you'll need to construct the html anchors manually like so:

	<a href="{% url "default", {"action":"register"} %}">Register</a>