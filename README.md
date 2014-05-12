# HTML to Markdown
PHP class for converting HTML to [Markdown][md].

[![Latest Stable Version](https://poser.pugx.org/TheFox/html2markdown/v/stable.png)](https://packagist.org/packages/TheFox/html2markdown)
[![Latest Unstable Version](https://poser.pugx.org/thefox/html2markdown/v/unstable.png)](https://packagist.org/packages/thefox/html2markdown)
[![License](https://poser.pugx.org/thefox/html2markdown/license.png)](https://packagist.org/packages/thefox/html2markdown)

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
			"thefox/html2markdown": "0.2.*"
		}
	}
	```

3. Run Composer:

	``` sh
	php composer.phar install
	```

Browse for more packages on [Packagist](https://packagist.org).

## Contributors
- Christian Mayer (<thefox21at@gmail.com>)
- Mirko Bonadei (<mirko.bonadei@gmail.com>)

## Markdown documentation
<http://daringfireball.net/projects/markdown/>

## License
Copyright (C) 2013 Christian Mayer (<thefox21at@gmail.com> - <http://fox21.at>)

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.

[md]: http://daringfireball.net/projects/markdown/ "Markdown"
