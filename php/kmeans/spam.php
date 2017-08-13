<?php
 
if (defined("SPAM_CLASS") ) return true;
define("SPAM_CLASS",true);

require(dirname(__FILE__)."/ngram.php");


class spam {
    var $_source;
    
    function spam($callback='') {
        if ( !is_callable($callback) ) {
            trigger_error("$callback is not a valid funciton",E_USER_ERROR);
        }
        $this->_source = $callback;
    }
    
    function isItSpam($text,$type) {
        $ngram = new ngram;
        $ngram->setText($text);
        
        for($i=3; $i <= 5;$i++) {
            $ngram->setLength($i);
            $ngram->extract();
        }
        
        $fnc = $this->_source;
        $ngrams =  $ngram->getnGrams();
        $knowledge =  $fnc( $ngrams,$type );
        $total=0;
        $acc=0;
        foreach($ngrams as $k => $v) {
            if ( isset($knowledge[$k]) ) {
                $acc += $knowledge[$k] * $v;
                $total++;
            }
        }
        if($total != 0){
            $percent = ($acc/$total);
            $percent = $percent > 1.0 ? 1.0 : $percent;
            return $percent * 100;
        }
    }
    
   
    
    function isItSpam_v2($text,$type) {
        $ngram = new ngram;
        $ngram->setText($text);
        
        for($i=3; $i <= 5;$i++) {
            $ngram->setLength($i);
            $ngram->extract();
        }
        
        $fnc = $this->_source;
        $ngrams =  $ngram->getnGrams();
        $knowledge =  $fnc( $ngrams,$type );
        $total=0;
        $acc=0;
       
        $N = 0;
        $H = $S = 1;
        
        foreach($ngrams as $k => $v) {
            if ( !isset($knowledge[$k]) ) continue;
            $N++;
            $value = $knowledge[$k] * $v; 
            $H *= $value;
            $S *= (float)( 1 - ( ($value>=1) ? 0.99 : $value) );
        }

        $H = $this->chi2Q( -2 * log( $N *  $H), 2 * $N);
        $S = (float)$this->chi2Q( -2 * log( $N *  $S), 2 * $N);
        $percent = (( 1 + $H - $S ) / 2) * 100;
        return is_finite($percent) ? $percent : 100;
    }
    
    function chi2Q( $x,  $v) {
        $m = (double)$x / 2.0;
        $s = exp(-$m);
        $t = $s;
        
        for($i=1; $i < ($v/2);$i++) {
            $t *= $m/$i;
            $s += $t;
        }
        return ( $s < 1.0) ? $s : 1.0;
    }
}
?>