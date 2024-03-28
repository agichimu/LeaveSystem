<?php
session_start();
include 'dbh.inc.php';
include 'functions.inc.php';

getCurrentLeaves($conn);