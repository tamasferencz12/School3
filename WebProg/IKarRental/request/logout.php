<?php
require_once '../support/fuggvenyek.php';

session_start();
session_unset();
session_destroy();
atiranyit('../index.php');
