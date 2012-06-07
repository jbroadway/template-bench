# Template Benchmark

This is a simple benchmark to test the memory usage and speed of rendering
templates using [Elefant](http://www.elefantcms.com/)'s
[Template engine](http://www.elefantcms.com/wiki/Templates),
[Twig](http://twig.sensiolabs.org/), and [Smarty 3](http://www.smarty.net/).

## Machine specs

The tests were done on an iMac with the following specs:

```
Mac OS X 10.7.4
3.06 GHz Core 2 Duo w/ 8 GB RAM
Apache 2.2.21
PHP 5.3.10
```

## Running the tests

To run the tests yourself, started with a fresh copy of Elefant 1.3.1-beta.
Add the following `composer.json` file to the root of the site:

```json
{
	"require": {
		"twig/twig": "1.*"
	},
	"config": {
		"vendor-dir": "lib/vendor"
	}
}
```

Now run the following to install Twig:

```
cd /path/to/your/site
php composer.phar install
```

> Note: Requires [Composer](http://getcomposer.org/).

Lastly, run these commands to install the tests:

```
cd apps
git clone https://github.com/jbroadway/template-bench.git
```

This adds the following new URLs to Elefant:

* http://www.example.com/template-bench/elefant
* http://www.example.com/template-bench/raw
* http://www.example.com/template-bench/smarty3
* http://www.example.com/template-bench/twig

The first time each of these is run, it will generate the cached copy
of the template. Subsequent runs will use the cached templates.

## Rendering with compilation (uncached)

<p><table>
<thead>
<tr>
<th> Engine </th>
<th> Microtime </th>
<th> Memory </th>
</tr>
</thead>
<tbody>
<tr>
<td> Raw PHP </td>
<td> 0.00012397766113281 </td>
<td> 7 KB </td>
</tr>
<tr>
<td> Elefant </td>
<td> 0.00062322616577148 </td>
<td> 60 KB </td>
</tr>
<tr>
<td> Smarty 3 </td>
<td> 0.033155918121338 </td>
<td> 4.7 MB </td>
</tr>
<tr>
<td> Twig </td>
<td> 0.051060914993286 </td>
<td> 2.9 MB </td>
</tr>
</tbody>
</table></p>

In the compilation step, which runs whenever a template file has changed,
Elefant uses negligible memory compared to Twig's 2.9 MB and Smarty's 4.7 MB,
and generates the cached template in a fraction of the time.

## Rendering from cached template

<p><table>
<thead>
<tr>
<th> Engine </th>
<th> Microtime </th>
<th> Memory </th>
</tr>
</thead>
<tbody>
<tr>
<td> Raw PHP </td>
<td> 0.00012397766113281 </td>
<td> 7 KB </td>
</tr>
<tr>
<td> Elefant </td>
<td> 0.00019192695617676 </td>
<td> 54 KB </td>
</tr>
<tr>
<td> Smarty 3 </td>
<td> 0.00063490867614746 </td>
<td> 8 KB </td>
</tr>
<tr>
<td> Twig </td>
<td> 0.0015380382537842 </td>
<td> 248 KB </td>
</tr>
</tbody>
</table></p>

Rendering from cached templates puts Elefant at 8x faster and using 1/5th
of the memory as Twig does, and about 3x faster than Smarty. Interestingly,
regenerating templates in Elefant uses only 6 KB more memory than rendering
from cache, and is also faster than Twig is at rendering a template from cache,
and equal in speed to Smarty's compiled performance.

## Setup memory usage

I also wanted to see how much memory the setup for each library required.
For this, I went outside of the Elefant framework in order to load each
library independently of the framework surrounding it. Here are the results
of how much memory each templating engine consumes during its setup:

<p><table>
<thead>
<tr>
<th> Engine </th>
<th> Memory </th>
</tr>
</thead>
<tbody>
<tr>
<td> Raw PHP </td>
<td> 0 KB </td>
</tr>
<tr>
<td> Elefant </td>
<td> 375 KB </td>
</tr>
<tr>
<td> Smarty 3 </td>
<td> 1.7 MB </td>
</tr>
<tr>
<td> Twig </td>
<td> 851 KB </td>
</tr>
</tbody>
</table></p>

The results clearly show Elefant leading in memory usage and speed, with
Smarty 3 a close second on performance, and Twig trailing behind on rendering
but still using less overall memory than Smarty 3.

## Notes

The raw PHP test added a sanitizing function, since that is such an important
consideration in data output. This function simply wraps `htmlspecialchars()`
with the appropriate parameters.
