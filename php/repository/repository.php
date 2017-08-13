<?php
	require_once("../config/database.php");

	class Repository {

		private $database;

		public function __construct(){
			$this->database = new Database();
		}

		public function saveExample($text, $state){
			$text = $this->database->escapeString($text);
			$state = $this->database->escapeString($state);
			$sql = "insert into examples(text, state) values ('{$text}', '{$state}')";
			return $this->database->query($sql);
		}

		public function updateExample($text, $state){
			$text = $this->database->escapeString($text);
			$state = $this->database->escapeString($state);
			$sql = "update examples set state = '{$state}' where text like '{$text}'";
			return $this->database->query($sql);
		}

		public function getNgramsAndPercent($type, $info){
			$sql = "select ngram,percent from knowledge_base where belongs = '$type' && ngram in ('".implode("','",$info)."')";
			return $this->database->query($sql);
		}

		public function findAllKnowledge(){
			$sql = "select belongs,ngram,repite from knowledge_base";
			return $this->database->query($sql);
		}

		public function findAllTrainingData(){
			$sql = "select * from examples";
			return $this->database->query($sql);
		}

		public function findAllComments(){
			$sql = "select comment_content as text,comment_approved as state from wp_comments";
			return $this->database->query($sql);
		}

		public function updateKnowledge($k, $tipo, $y){
			$sql = "replace knowledge_base values('$k','$tipo','".$y['cant']."','".$y['kmeans']."')";
			return $this->database->query($sql);
		}

		public function createTemporaryTableAndUpdateKnowledge(){
			$sql = "create temporary table opttable as select ngram, count(*) total, min(percent) as nmin, max(percent) as nmax from knowledge_base group by ngram having count(ngram) > 1";
			$this->database->query($sql);
			$sql = "delete from knowledge_base where ngram in (select ngram from opttable where (nmax-nmin) < 0.30)";
			return $this->database->query($sql);
		}

	}