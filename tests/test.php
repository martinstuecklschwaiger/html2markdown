<?php

require_once __DIR__.'/../vendor/autoload.php';

use TheFox\HTML2Markdown\HTML2Markdown;

$html2md = new HTML2Markdown();
$html2md->test();

$html2md = new HTML2Markdown(file_get_contents(__DIR__.'/blogpost.html'));

print "\n\nmarkdown:\n".$html2md->parse()."\n";
