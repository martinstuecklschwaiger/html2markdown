<?php

require_once __DIR__.'/../vendor/autoload.php';

use TheFox\HTML\HTML2Markdown;

$html2md = new HTML2Markdown(file_get_contents(__DIR__.'/blogpost.html'));

print "markdown:\n".$html2md->parse()."\n";
