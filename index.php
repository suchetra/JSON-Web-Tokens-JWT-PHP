<?php
require_once 'includes/config.php';
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
    ]
];

// on transforme le header et payload en chaine de caractères comme à gauche sur le site, on dit que :
// on encode le header/payload en base64
// on utilise json_encode() car $header est un tableau
$base64Header = base64_encode(json_encode($header));
$base64Payload = base64_encode(json_encode($payload));

// echo $base64Header;
// echo $base64Payload;

// on "nettoie" les valeurs encodées
// on retire les +, / et =
// sinon erreur "Invalid Signature" à gauche
$base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
$base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

// la 3e partie vérifie que les 2 premières ont bien été générés par mon serveur, sinon l'authentification se fait quand même et le token ne sert plus a rien ; la 3e partie vérifie l'authenticité du token

$secret = base64_encode(SECRET); 
// c'est le "secret base64 encoded" à droite du site, qu'on ne doit jamais communiquer/se faire voler
// echo $secret;

// on génère la signature en lui passant $base64Header et $base64Payload
// hash_hmac() fonction de génération de hash
// sha256 pour générer ce hash
$signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

$signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

// echo $signature;

// ou pour voir l'étape intermédiaire juste avant la ligne précédente :
// $base64Signature = base64_encode($signature);
// $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
// echo $base64Signature;

// on crée le token
$jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

echo $jwt;


