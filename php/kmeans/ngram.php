<?php

if (defined("NGRAM_CLASS") ) return true;

define("NGRAM_CLASS",true);

class ngram {

    var $text;
    var $length;
    var $ngrams;
    function ngram($letter=1) {
        $this->setLength($letter);
    }
    
    function setLength($length=1){
        $this->length=$length;
    }
    
    function setText($text) {
        $this->text =" ".$text."  ";
    }
    
    function setInitialNgram($arg) {
        $this->ngrams = $arg;
    }
    
    function getnGrams() {
        return $this->ngrams;
    }
    
    function extract() {
        $txt = & $this->text;
        $len = strlen($txt);
        $length = & $this->length;
        $ngrams = & $this->ngrams;
        $buf='';
        $ultimo='';
        for($i=0; $i < $len; $i++) {
            if ( strlen($buf) < $length) {
                if ( !$this->useful($txt[$i]) ) 
                    continue;
                    
                if ($this->is_space($txt[$i]) && $this->is_space($ultimo))
                     continue;
                    
                $buf .= $this->is_space($txt[$i]) ? '_' : $txt[$i];
                $ultimo = $txt[$i];
            } else {
                $buf = strtolower($buf);
                $buf = str_replace(" ","_",$buf);
                $ngrams[$buf] = isset($ngrams[$buf]) ? $ngrams[$buf] + 1 : 1;
                $ultimo='';
                $buf = '';
                $i--;
            }
        }
    }
   
    function is_space($f) {
        return $f==' ' || $f=="\n" || $f=="\r" || $f=="\t";
    }

    function useful($f) {
        $f = strtolower($f);
        return ($f >= 'a' && $f <= 'z') || $this->is_space($f);
    }
}
/*
function is_space($f) {
    return $f==' ' || $f=="\n" || $f=="\r" || $f=="\t";
}

function useful($f) {
    $f = strtolower($f);
    return ($f >= 'a' && $f <= 'z') || is_space($f);
}*/


?>