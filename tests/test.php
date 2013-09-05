<?php

require_once __DIR__.'/../vendor/autoload.php';

use TheFox\HTML2Markdown\HTML2Markdown;

$html2md = new HTML2Markdown(file_get_contents(__DIR__.'/blogpost.html'));
#$html2md = new HTML2Markdown(file_get_contents(__DIR__.'/blogpost2.html'));
$html2md = new HTML2Markdown(file_get_contents(__DIR__.'/blogpost3.html'));

print "markdown:\n".$html2md->parse()."\n";
