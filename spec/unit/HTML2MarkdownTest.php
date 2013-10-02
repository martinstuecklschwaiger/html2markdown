<?php

require_once __DIR__ . '/../../src/TheFox/HTML/HTML2Markdown.php';

use TheFox\HTML\HTML2Markdown;

class HTML2MarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function testDivNodeShouldBeWrappedBetweenEmptyLines()
    {
        $expectedOutput = PHP_EOL . '<div>Something here...</div>' . PHP_EOL;
        $givenInput = '<div>Something here...</div>';
        $html2markdown = new HTML2Markdown($givenInput);
        $this->assertEquals($expectedOutput, $html2markdown->parse());
    }

    public function testDivNodeTagsShouldBeStrippedFromTabsOrSpaces()
    {
        $expectedOutput = PHP_EOL . '<div>Something here...</div>' . PHP_EOL;
        $givenInput = "\t" . '<div>Something here...   </div>';
        $html2markdown = new HTML2Markdown($givenInput);
        $this->assertEquals($expectedOutput, $html2markdown->parse());
    }
}
