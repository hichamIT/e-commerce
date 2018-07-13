<?php 

require_once("../../resources/config.php"); 

session_start();
session_destroy();
redirect('../../public');