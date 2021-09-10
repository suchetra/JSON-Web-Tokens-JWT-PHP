<?php
require_once 'includes/config.php';
require_once 'classes/JWT.php';
// on crée le header
// chaine de caractère est un encodage de notre header quand on est sur le site https://jwt.io/
$header = [
    'typ' => 'jWT',
    // algorithme de hachage
    'alg' => 'HS256' 
];

// on crée le contenu (payload)
$payload = [
    'user_id' => 123,
    'roles' => [
        'ROLE_ADMIN',
        'ROLE_USER'
        // SUB pour subject, donnée réservé pour savoir à qui est attribué le token, c'est un ID le plus souvent
        // iat issue at, c'est le time stamp
    ],
    'email' => 'contact@demo.fr'
];

$jwt = new JWT();
$token = $jwt->generate($header, $payload, SECRET);

echo $token;


