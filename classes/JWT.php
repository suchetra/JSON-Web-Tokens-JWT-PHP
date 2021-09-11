<?php
class JWT
{
    public function generate(array $header, array $payload, string $secret, int $validity = 86400): string
    {

        if($validity > 0){
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

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

        return $jwt;
    }

    public function check(string $token, string $secret): bool
    {
        // on récupère le header
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // on génère un token de vérification
        // 0 car on ne veut pas ajouter des dates à la fonction generate qui en a déjà... sinon le token sera différent
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }

    public function getHeader(string $token)
    {
        // démontage token
        $array = explode('.', $token);

        // on décode le header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;

    }

    public function getPayload(string $token)
    {
        // démontage token
        $array = explode('.', $token);

        // on décode le header
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    /**
     * Vérification de l'expiration
     * @param string $token Token à vérifier
     * @return bool Vérifié ou non
     */
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $nowWhenChecked = new DateTime();

        return $payload['exp'] < $nowWhenChecked->getTimestamp();
    }
}