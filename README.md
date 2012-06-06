# Template Benchmark

This is a simple benchmark to test the memory usage and speed of rendering
templates using [Elefant](http://www.elefantcms.com/)'s Template class and
[Twig](http://twig.sensiolabs.org/).

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

This adds two URLs to Elefant:

* http://www.example.com/template-bench/elefant
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
<td> Elefant </td>
<td> 0.00062322616577148 </td>
<td> 60 KB </td>
</tr>
<tr>
<td> Twig </td>
<td> 0.051060914993286 </td>
<td> 2.9 MB </td>
</tr>
</tbody>
</table></p>

In the compilation step, which runs whenever a template file has changed,
Elefant uses negligible memory compared to Twig's 2.9 MB, and generates the
cached template in a fraction of the time.

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
<td> Elefant </td>
<td> 0.00019192695617676 </td>
<td> 54 KB </td>
</tr>
<tr>
<td> Twig </td>
<td> 0.0015380382537842 </td>
<td> 248 KB </td>
</tr>
</tbody>
</table></p>

Rendering from cached templates puts Elefant at 5x faster and using 1/5th
of the memory as Twig does. Interestingly, regenerating templates in Elefant
uses only 6 KB more memory than rendering from cache, and is also faster
than Twig is at rendering a template from cache.
