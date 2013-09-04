<?php

namespace TheFox\HTML2Markdown;

class HTML2Markdown{
	
	private $markdown = '';
	
	function __construct($str = ''){
		$dom = new \DOMDocument();
		if($str){
			
			$dom->loadHTML($str);
			
			var_export($dom);
			
		}
	}
	
	public function getMarkdown(){
		return $this->markdown;
	}
	
	public function test(){
		print "test\n";
	}
	
}
