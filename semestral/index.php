<?php
require_once "configuration/DatabaseConnection.php";

$instance = DatabaseConnection::getInstance();
$conn = $instance->getConnection();
