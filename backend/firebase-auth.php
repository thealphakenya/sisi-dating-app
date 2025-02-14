<?php
require_once 'vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('path-to-firebase.json');
$auth = $factory->createAuth();
?>
