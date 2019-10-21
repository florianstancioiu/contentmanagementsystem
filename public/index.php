<?php

error_reporting(E_ALL);
error_log(-1);

// Start the session
session_start();

// Use composer to autoload classes and files
require '../vendor/autoload.php';

// Init Twig Functions
init_twig_extensions();

// Create storage symlink
create_storage_symlink();

// Register web routes
register_routes();
