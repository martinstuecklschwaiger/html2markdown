<?php

namespace TheFox\HTML2Markdown;

class HTML2Markdown{
	
	private $html = '';
	private $markdown = '';
	
	function __construct($str = ''){
		$this->html = $str;
	}
	
	public function parse(){
		
		$rv = '';
		
		if($this->html){
			
			$dom = new \DOMDocument();
			if($dom->loadHTML($this->html)){
				#var_export($dom);
				
				$rv = $this->parseElement($dom);
				
			}
			
		}
		
		print "markdown:\n$rv\n";
		
		
		exit();
		
		return $this->getMarkdown();
	}
	
	public function parseElement($node, $level = 0){
		$rv = '';
		$content = '';
		
		#print "parseElement\n";
		print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType."\n";
		print "\t '".$node->nodeValue."'\n";
		print "\t '".$node->textContent."'\n";
		#sleep(1);
		
		#var_export($node->childNodes);print "\n";print "\n";
		#return;
		
		if($node->nodeType == XML_TEXT_NODE){
			$content = $node->wholeText;
			$content = preg_replace('/\n+$/', ' ', $content);
		}
		elseif($node->nodeType == XML_ELEMENT_NODE){
			
		}
		
		$content = preg_replace('/ +/', ' ', $content);
		print "\t '".$content."'\n\n";
		
		$rv .= $content;
		
		print "\n";print "\n";
		
		if($node->hasChildNodes()){
			foreach($node->childNodes as $node){
				$rv .= $this->parseElement($node, $level + 1);
			}
		}
		
		return $rv;
	}
	
	public function setMarkdown($md){
		$this->markdown = $md;
	}
	
	public function getMarkdown(){
		return $this->markdown;
	}
	
	public function test(){
		print "test\n";
	}
	
}
