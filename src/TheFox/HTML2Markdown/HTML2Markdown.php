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
		
		print "\n\nmarkdown:\n$rv\n";
		
		
		exit();
		
		return $this->getMarkdown();
	}
	
	public function parseElement($node, $level = 0){
		$rv = '';
		$contentPre = '';
		$content = '';
		$contentPost = '';
		
		#print "parseElement\n";
		#print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType.", ".$node->getNodePath()."\n";
		#print "\t '".$node->nodeValue."'\n";
		#print "\t '".$node->textContent."'\n";
		#sleep(1);
		
		#var_export($node->childNodes);print "\n";print "\n";
		#return;
		
		if($node->nodeType == XML_TEXT_NODE){
			$content = $node->wholeText;
			$content = preg_replace('/\n+/', ' ', $content);
		}
		elseif($node->nodeType == XML_ELEMENT_NODE){
			
			#print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType.", ".$node->getNodePath()."\n";
			
			if($node->nodeName == 'p'){
				$contentPost = "\n\n";
			}
			elseif($node->nodeName == 'i' || $node->nodeName == 'em'){
				$contentPre = '*';
				$contentPost = '*';
			}
			elseif($node->nodeName == 'b' || $node->nodeName == 'strong'){
				$contentPre = '**';
				$contentPost = '**';
			}
			elseif($node->nodeName == 'a'){
				print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType.", ".$node->getNodePath()."\n";
				
				var_export($node->childNodes);print "\n\n";
				
				$contentPre = '[';
				$contentPost = ']('.$node->getAttribute('href').($node->hasAttribute('title') ? ' "'.$node->getAttribute('title').'"' : '').')';
			}
			else{
				#print "node '".$node->nodeName."' not implemented\n";
			}
		}
		
		if($node->hasChildNodes()){
			foreach($node->childNodes as $node){
				$content .= $this->parseElement($node, $level + 1);
			}
		}
		
		$rv .= $contentPre.$content.$contentPost;
		
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
