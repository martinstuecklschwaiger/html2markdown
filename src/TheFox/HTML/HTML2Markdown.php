<?php

namespace TheFox\HTML;

class HTML2Markdown{
	
	private $html = '';
	private $markdown = '';
	
	function __construct($str = ''){
		$this->html = $str;
		
		set_error_handler(function($errno, $errstr, $errfile, $errline){
			#print "ERROR: ".$errno.", ".$errstr."\n";
			switch($errno){
				case 2:
					print "\nWARNING: ".$errstr."\n\n";
					exit(1);
					break;
			}
		});
	}
	
	public function parse(){
		
		$markdown = '';
		
		if($this->html){
			
			$this->html = str_replace("\r", '', $this->html);
			$this->html = str_replace('&#8217;', "'", $this->html);
			
			$dom = new \DOMDocument();
			try{
				if($dom->loadHTML($this->html)){
					#var_export($dom);
					
					$markdown = $this->parseElement($dom);
					
				}
				else{
					print "ERROR: loadHTML() failed\n";
					exit(1);
				}
			}
			catch(Exception $e){
				print "ERROR: ".$e->getMessage()."\n";
				exit(1);
			}
		}
		
		$markdown = str_replace("\n\n --- ", "\n\n---\n\n", $markdown);
		
		#$markdown = str_replace(' ', '~', str_replace("\n", "$\n", str_replace("\t", '____', $markdown)));
		
		#print "\n\nmarkdown:\n$markdown\n";exit();
		
		#file_put_contents('test.md', $markdown); system('killall Mou &> /dev/null; open test.md');
		
		$this->setMarkdown($markdown);
		
		return $markdown;
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
            elseif($node->nodeName == 'div') {
                $contentPre = PHP_EOL . '<div>';
                $contentPost = '</div>' . PHP_EOL;
                $trim = true;
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
			elseif($node->nodeName == 'img'){
				$contentPre = '![';
				$content = $node->hasAttribute('alt') ? $node->getAttribute('alt') : '';
				$contentPost = ']('.$node->getAttribute('src').($node->hasAttribute('title') ? ' "'.$node->getAttribute('title').'"' : '').')';
			}
			elseif($node->nodeName == 'pre'){
				#print "pre found: ".(int)( $node->firstChild->nodeName != 'code' )."\n";
				if($node->firstChild->nodeName != 'code'){
					$contentPre = "\t";
					$contentPreAllLines = "\t";
					$contentPost = "\n\n";
				}
			}
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
			elseif($node->nodeName == 'h1'){
				$contentPre = '# ';
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'h2'){
				$contentPre = '## ';
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'h3'){
				$contentPre = '### ';
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'h4'){
				$contentPre = '#### ';
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'h5'){
				$contentPre = '##### ';
				$contentPost = "\n";
			}
			elseif($node->nodeName == 'del'){
				$contentPre = '~~';
				$contentPost = '~~';
			}
			elseif($node->nodeName == 'blockquote'){}
			elseif($node->nodeName == 'span'){}
			elseif($node->nodeName == 'tt'){}
			elseif($node->nodeName == 'html' || $node->nodeName == 'meta' || $node->nodeName == 'body'){}
			else{
				print "WARNING: node '".$node->nodeName."' not implemented\n";
				#exit(1);
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
