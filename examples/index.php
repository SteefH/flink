<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_startup_errors', '1');
ini_set('display_errors', '1');


$selectedExample = null;
$file = null;
if (isset($_GET['example'])) {
	$selectedExample = $_GET['example'];
	if (preg_match('/^[a-zA-Z]+$/', $selectedExample)) {
		$file = dirname(__FILE__)."/methods/${selectedExample}.php";
		if (!is_file($file)) {
			$file = null;
			$selectedExample = null;
		}
	}
}

require_once dirname(__FILE__).'/../library/Flink/autoloader.php';

$examples = \Flink\Enumerable::create(
		new \GlobIterator(dirname(__FILE__).'/methods/*.php')
	)->select(function ($filename) use ($selectedExample) {
		$basename = substr(basename($filename), 0, -4);
		$result = new \StdClass;
		$result->name = $basename;
		$result->link = '?example='.$basename;
		$result->selected = $selectedExample === $basename;
		return $result;
	});
	
/******************************************************************************/
?>
<html>
<head><title>Flink Examples<?= $selectedExample ? ' - \\Flink\\Enumerable::'.$selectedExample.'()' : '' ?></title>
	<style type="text/css">
	body, code, pre {
		font-family: Consolas,"Courier New", monospace;
		font-weight: bold;
	}
	html, body {
		margin: 0;
		padding: 0;
	}
	body {
		font-size: 14px;
		padding: 1em;
	}
	code, pre {
		font-size: 14px;
		font-weight: bold;
	}
	a {
		color: #f70;
		font-weight: bold;
		text-decoration: none;
	}
	a:hover,
	a.selected {
		text-decoration:underline;
	}
	fieldset {
		border:none;
		border-left: 3px solid #f70;
		margin-bottom: 2em;
	}
	h1 {
		border-bottom: 3px solid #f70;
	}
	legend h3 {
		border: none;
		font-size: 18px;
	}
	</style>
	
	</head>
	<body>

<h1>\Flink\Enumerable</h1>
<div style="position:absolute; width: 200px;">
<h2>Methods</h2>
<ul>
<?php foreach ($examples as $example): ?>
	<li><a href="<?= $example->link ?>"<?= $example->selected ? ' class="selected"' : ''?>><?= $example->name ?>()</a></li>
<?php endforeach; ?>
</ul>
</div>
<div style="position:absolute; left: 210px; right: 10px;">
<? if($file !== null): ?>
	<h2>\Flink\Enumerable::<?= $selectedExample ?>()</h2>
	<fieldset>
		<legend><h3>Source</h3></legend>
		<? highlight_file($file) ?>
	</fieldset>
	<fieldset>
		<legend><h3>Output</h3></legend>
		<pre><? include $file ?></pre>
	</fieldset>
<?php endif; ?>
</div>
</body>
</html>