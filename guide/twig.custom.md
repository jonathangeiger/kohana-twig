# Custom Blocks

The modules comes with a few pre-made blocks.


### html

Allows you to use the html helper in the following format

	{% html.anchor "http://google.com", "Google" %}

All html helper functions are available and take arguments as you would expect.

### form

The same as the html helper, just replace `html` with `form` and `anchor` with a form
function

### cache

This makes use of the Kohana fragment cache and provides a simplified interface
for creating cachable blocks of content.

	{% cache "key" %}
		This will be cached.
	{% endcache %}

You can also pass a lifetime value in seconds as the second argument.

	{% cache "key", 3600 %}
		This will be cached.
	{% endcache %}

Will be cached for one hour.

### url

Use reverse routing in your templates.

	{% url "default", ["action":"register"] %}

The first argument is the route name and the second is a key:value array. So the above
would produce:

	http://example.com/welcome/register

You can set certain keys to `null` so the route will use the default segment in
the bootstrap.php or init.php files. If we wanted to remove `welcome` for example:

	{% url "default", ["controller":null,"action":"register"] %}

would produce:

	http://example.com/register

#### Generating links

Unfortunately you can't mix the url block with the html block and so if you need
to use reverse routing you'll need to construct the html anchors manually like so:

	<a href="{% url "default", ["action":"register"] %}">Register</a>