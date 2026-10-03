<?php
header('Content-Type: application/json');
echo json_encode([
    'REQUEST_URI'  => $_SERVER['REQUEST_URI'] ?? null,
    'PATH_INFO'    => $_SERVER['PATH_INFO'] ?? null,
    'SCRIPT_NAME'  => $_SERVER['SCRIPT_NAME'] ?? null,
    'QUERY_STRING' => $_SERVER['QUERY_STRING'] ?? null,
    'HTTP_HOST'    => $_SERVER['HTTP_HOST'] ?? null,
]);