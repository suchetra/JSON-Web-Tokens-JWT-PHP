<?php
// header qui nous permet d'utiliser Ajax sur un serveur 
// * pour autoriser toutes les url
header('Access-Control-Allow-Origin: *');

// je renvoie du json
header('Content-Type: application/json');

// je vérifie la méthode utilisée pour accéder au fichier est POST
// on interdit toute méthode qui n'est pas POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);

    echo json_encode(['message' => 'Méthode non autorisée']);

    exit;
}

// on vérifie si on reçoit un token
if(isset($_SERVER['Authorization'])){
    // trim() pour s'assurer que y ait pas d'espace au début et à la fin
    $token = trim($_SERVER['Authorization']);
}elseif(isset($_SERVER['HTTP_AUTHORIZATION'])){
    $token = trim($_SERVER['HTTP_AUTHORIZATION']);
}elseif(function_exists('apache_request_headers')){
    $requestHeaders = apache_request_headers();
    if(isset($requestHeaders['Authorization'])){
        $token = trim($requestHeaders['Authorization']);
    }
}
// on vérifie si il y a un token
// si on a une correspondance qui commence par Bearer suivi d'un espace puis une chaîne de caractères, dans token
if(!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)){
    http_response_code(400);
    // n'importe quel message 'Token introuvable' ou autre
    echo json_encode(['message' => 'Token introuvable']);
    exit;
}

// on extrait le token
$token = str_replace('Bearer ', '', $token);

require_once 'includes/config.php';
require_once 'classes/JWT.php';

$jwt = new JWT();

// on vérifie la validité, on a juste vérifié que c'était une chaîne de caractères
if(!$jwt->isValid($token)){
    http_response_code(400);
    // n'importe quel message 'Token introuvable' ou autre
    echo json_encode(['message' => 'Token invalide']);
    exit;
}

// on vérifie la signature
if(!$jwt->check($token, SECRET)){
    // 403 car on a pas le droit de rentrer
    http_response_code(403);
    // n'importe quel message 'Token introuvable' ou autre
    // en API il faut toujours répondre, et répondre en JSON
    echo json_encode(['message' => 'Le token est invalide']);
    exit;
}

// on vérifie l'expiration
if($jwt->isExpired($token)){
    http_response_code(403);
    // n'importe quel message 'Token introuvable' ou autre
    // en API il faut toujours répondre, et répondre en JSON
    echo json_encode(['message' => 'Le token a expiré']);
    exit;
}

// echo json_encode($jwt->getPayload($token));

// echo $token;