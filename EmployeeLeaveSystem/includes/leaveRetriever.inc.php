<?php

// Connect to the database using PDO
global $db;
$dsn = 'mysql:host=localhost;dbname=phpleaveproject';
$username = 'root';
$password = '';
$options = array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
try {
    $db = new PDO($dsn, $username, $password, $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, return an error response
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//debugging
    $response = array('success' => false, 'message' => 'Database connection failed.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Insert the data into the database using a prepared statement
$sql = 'SELECT * FROM leave_application ORDER BY id DESC';
$stmt = $db->prepare($sql);
$stmt->execute();
//fetch every thing on the primary key
$leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);


