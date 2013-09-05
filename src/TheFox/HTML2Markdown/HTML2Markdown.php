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
			
			$this->html = str_replace("\r", '', $this->html);
			$this->html = str_replace('&#8217;', "'", $this->html);
			
			$dom = new \DOMDocument();
			if($dom->loadHTML($this->html)){
				#var_export($dom);
				
				$rv = $this->parseElement($dom);
				
			}
			
		}
		
		#$rv = str_replace(' ', '~', str_replace("\n", "$\n", str_replace("\t", '____', $rv)));
		
		#print "\n\nmarkdown:\n$rv\n";exit();
		
		#file_put_contents('test.md', $rv); system('killall Mou &> /dev/null; open test.md');
		
		$this->setMarkdown($rv);
		
		return $rv;
	}
	
	public function parseElement($node){
		$rv = '';
		$contentPre = '';
		$contentPreAllLines = '';
		$content = '';
		$contentPost = '';
		$trim = false;
		
		#print "parseElement\n";
		#print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType.", ".$node->getNodePath().", ".$node->parentNode->nodeName."\n";
		#print "\t '".$node->nodeValue."'\n";
		#print "\t '".$node->textContent."'\n";
		
		if($node->nodeType == XML_TEXT_NODE){
			$content = $node->wholeText;
			
			if($node->parentNode->nodeName != 'code' && $node->parentNode->nodeName != 'pre'){
				$content = preg_replace('/\n+/', ' ', $content);
				$content = preg_replace('/\t+/', ' ', $content);
				$content = preg_replace('/ +/', ' ', $content);
				$content = preg_replace('/^ +$/', '', $content);
			}
			
			#if($content){ print "\t '".$content."'\n"; }
		}
		elseif($node->nodeType == XML_ELEMENT_NODE){
			#print "node: ".get_class($node).", ".$node->nodeName.", ".$node->nodeType.", ".$node->getNodePath()."\n";
			
			if($node->nodeName == 'p'){
				if($node->parentNode->nodeName == 'blockquote'){
					$contentPre = '> ';
					$contentPreAllLines = '> ';
				}
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
				$contentPre = '[';
				$contentPost = ']('.$node->getAttribute('href').($node->hasAttribute('title') ? ' "'.$node->getAttribute('title').'"' : '').')';
			}
			elseif($node->nodeName == 'pre'){}
			elseif($node->nodeName == 'code'){
				if($node->parentNode->nodeName == 'pre'){
					$contentPre = "\t";
					$contentPreAllLines = "\t";
					$contentPost = "\n\n";
				}
				else{
					$contentPre = "`";
					$contentPost = "`";
				}
			}
			elseif($node->nodeName == 'blockquote'){
				
			}
			elseif($node->nodeName == 'br'){
				$contentPost = "  \n";
			}
			elseif($node->nodeName == 'ul'){
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'ol'){
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'li'){
				if($node->parentNode->nodeName == 'ul'){
					$contentPre = '- ';
				}
				elseif($node->parentNode->nodeName == 'ol'){
					$contentPre = '1. ';
				}
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'html' || $node->nodeName == 'body'){}
			else{
				print "node '".$node->nodeName."' not implemented\n";
			}
		}
		
		if($node->hasChildNodes()){
			foreach($node->childNodes as $node){
				$content .= $this->parseElement($node);
			}
		}
		
		if($trim){ $content = trim($content); }
		
		if($contentPreAllLines){ $content = str_replace("\n", "\n".$contentPreAllLines, $content); }
		
		$rv .= $contentPre.$content.$contentPost;
		
		return $rv;
	}
	
	public function setMarkdown($md){
		$this->markdown = $md;
	}
	
	public function getMarkdown(){
		return $this->markdown;
	}
	
}
