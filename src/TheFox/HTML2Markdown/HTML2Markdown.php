<?php

namespace TheFox\HTML2Markdown;

class HTML2Markdown{
	
	private $html = '';
	private $markdown = '';
	
	function __construct($str = ''){
		$this->html = $str;
	}
	
	public function parse(){
		
		if($this->html){
			
			$dom = new \DOMDocument();
			if($dom->loadHTML($this->html)){
				#var_export($dom);
				
				foreach($dom->childNodes as $node){
					print "node: ".get_class($node).": ".$node->nodeName." = '".$node->nodeValue."' (".$node->nodeType.")\n";
					
				}
				
			}
			
		}
		
		return $this->getMarkdown();
	}
	
	public function getMarkdown(){
		return $this->markdown;
	}
	
	public function test(){
		print "test\n";
	}
	
}
