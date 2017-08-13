<?php

if (defined("TRAINER_CLASS") ) return true;
define("TRAINER_CLASS",true);
require(dirname(__FILE__)."/ngram.php");

class trainer {
    var $examples;
    var $ngram;
    var $knowledge;
    
    function trainer() {
        $this->ngram = new ngram;
    }
    
    function add_example($text, $clasification) {
        $this->examples[$clasification][] = $text;
    }
    
    function setPreviousLearn($f) {
        $this->previous = $f;
    }
    
    function extractPatterns() {
        $previous = & $this->previous;
        $examples = & $this->examples;
        $ngram = & $this->ngram;
        $knowledge = & $this->knowledge;
        
        foreach($examples as $tipo => $texts) {
            $params[$tipo] = 0;
            $ngram->setInitialNgram( isSet($previous[$tipo]) ? $previous[$tipo] : array() );
            foreach ($texts as $text) {
                $ngram->setText($text);
                for($i=3; $i <= 5;$i++) {
                    $ngram->setLength($i);
                    $ngram->extract();
                }
            }
 
            $actual = & $knowledge[$tipo];
            foreach( $ngram->getnGrams() as $k => $v) {
                $actual[$k]['cant'] = $v;
                $params[$tipo] += $v;
            }
        }
        $this->computeBayesianFiltering($params);
    }
    
    function computeBayesianFiltering($param) {
        $knowledge = & $this->knowledge;
        //print_r($param);
        //
        foreach($knowledge as $tipo => $caracterist) {
            foreach($caracterist as $k => $v) {
                 $t = ($v['cant']/$param[$tipo]);
                 $f = 0;
                 foreach($param as $k1 => $v1) 
                     if ( $k1 != $tipo) {
                        
                        $f += isset($knowledge[$k1][$k]['cant']) ? $knowledge[$k1][$k]['cant'] / $v1 : 0; 
                    }
                 $knowledge[$tipo][$k]['kmeans'] = $t / ($t + $f);
            }
        }
    }
}
?>