<?php
set_time_limit(0);
ini_set('memory_limit','64M');

require_once("../service/spam-service.php");

$spamService = new SpamService();

echo $spamService->trainSystem() ? "the system was successfully trained" : "error in training the system";

?>