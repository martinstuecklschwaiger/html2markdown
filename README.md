# HTML to Markdown
PHP class for converting HTML to [Markdown][md].

Visit [fox21.at](http://fox21.at).

## Development stage
This software is in [pre-alpha stage](http://en.wikipedia.org/wiki/Software_release_life_cycle#Pre-alpha). This means it supports only `<p>`, `<i>`, `<em>`, `<b>`, `<strong>`, `<a>`, `<img>`, `<pre>`, `<code>`, `<br>`, `<ul>`, `<ol>`, `<li>`, `<h1>`, `<h2>`, `<h3>`, `<h4>`, `<h5>`, `<del>`. Not the full [Markdown][md] specification.

## Installation
1. Download the [`composer.phar`](https://getcomposer.org/composer.phar) executable or use the installer.

	``` sh
	curl -sS https://getcomposer.org/installer | php
	```

2. Create a `composer.json` defining your dependencies.

	``` json
	{
		"require": {
			"thefox/html2markdown": ">=0.1.0"
		}
	}
	```

3. Run Composer:

	``` sh
	php composer.phar install
	```

Browse for more packages on [Packagist](https://packagist.org).

## Markdown documentation
[http://daringfireball.net/projects/markdown/][md]

[md]: http://daringfireball.net/projects/markdown/ "Markdown"
