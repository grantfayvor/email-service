<?php
require("../kmeans/trainer.php");
require_once("../kmeans/spam.php");
require_once("../repository/repository.php");

class SpamService{
    private $spamRepository;

    public function __construct() {
		$this->spamRepository = new Repository();
	}

    public function isItSpam($text){
		$spam = new spam("handler");
		$score = number_format($spam->isItSpam($text,'spam'),2);
		return $score > 60 ? true : false;
	}

    public function saveExample($text, $state){
        return $this->spamRepository->saveExample($text, $state);
    }

    public function updateExample($text, $state){
        return $this->spamRepository->updateExample($text, $state);
    }

    public function trainSystem(){
        $trainer = new trainer;
        $query = $this->spamRepository->findAllKnowledge();
        $previouslearn = array();
        while ($row = $query->fetch_array()){
            $previouslearn[$row['belongs']][$row['ngram']] = $row['repite'];
        }
        mysqli_free_result($query);
        echo "setting previous learn <br>";
        $trainer->setPreviousLearn($previouslearn);
        echo "successful in setting previous learn <br>";
        $query = $this->spamRepository->findAllTrainingData();
        // $query1 = $this->spamRepository->findAllComments();
        echo "trying to add examples <br>";
        while ($row = $query->fetch_array()){
            $text = $row['text'];
            $text = strip_tags($text);
            $trainer->add_example($text,$row['state']);
        }
        echo "successful in adding examples <br>";
        mysqli_free_result($query);
        echo "extracting patterns <br>";
        $trainer->extractPatterns();
        echo "successful in extracting patterns and trying to update knowledge <br>";
        foreach ($trainer->knowledge as $tipo => $v) {
            foreach($v as $k => $y) {
                $k = addslashes($k);
                $this->spamRepository->updateKnowledge($k, $tipo, $y);
            }
        }
        echo "successful in updating knowledge <br>";
        return true;
    }

}

function handler($ngrams,$type) {
    $spamRepository = new Repository();
   	$info = array_keys($ngrams);
   	$t = array();
   	$result = $spamRepository->getNgramsAndPercent($type, $info);
   	while ( $row = $result->fetch_array() ) {
       	$t[ $row['ngram'] ]  = $row['percent'];     
   	}
   	return $t;
}