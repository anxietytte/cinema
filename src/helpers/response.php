<?php

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function e_nl($text) {
    return nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}

function jsonResponse($data, $status = 200, $message = '') {
    http_response_code($status);
    
    header('Content-Type: application/json; charset=utf-8');
    
    $response = [
        'status' => $status,
        'success' => ($status >= 200 && $status < 300),
        'data' => $data
    ];
    
    if (!empty($message)) {
        $response['message'] = $message;
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

function jsonSuccess($data, $message = '') {
    jsonResponse($data, 200, $message);
}

function jsonError($message, $status = 400) {
    jsonResponse(null, $status, $message);
}
