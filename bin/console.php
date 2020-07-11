#!/usr/bin/env php
<?php
use Core\ConsoleApplication as Application;

// Get application config
$config = include __DIR__.'/../config/application.config.php';
$config = is_array($config) ? $config : [];

// Create Application
$app = new Application();

// Run the application
$app->init($config)->run();
