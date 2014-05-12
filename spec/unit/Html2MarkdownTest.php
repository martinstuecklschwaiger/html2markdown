<?php

require_once __DIR__ . '/../../src/TheFox/Html/Html2Markdown.php';

use TheFox\Html\Html2Markdown;

class Html2MarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function testDivNodeShouldBeWrappedBetweenEmptyLines()
    {
        $expectedOutput = PHP_EOL . '<div>Something here...</div>' . PHP_EOL;
        $givenInput = '<div>Something here...</div>';
        $html2markdown = new Html2Markdown($givenInput);
        $this->assertEquals($expectedOutput, $html2markdown->parse());
    }

    public function testDivNodeTagsShouldBeStrippedFromTabsOrSpaces()
    {
        $expectedOutput = PHP_EOL . '<div>Something here...</div>' . PHP_EOL;
        $givenInput = "\t" . '<div>Something here...   </div>';
        $html2markdown = new Html2Markdown($givenInput);
        $this->assertEquals($expectedOutput, $html2markdown->parse());
    }
}
