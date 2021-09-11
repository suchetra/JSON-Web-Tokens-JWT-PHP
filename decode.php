<?php
const TOKEN = 'eyJ0eXAiOiJqV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjb250YWN0QGRlbW8uZnIiLCJpYXQiOjE2MzEzNDE3NTMsImV4cCI6MTYzMTQyODE1M30.Or0XHNE2rEonNoVEMW8pEEhORDgXK2mOXtiy_aIMCeE';

require_once 'includes/config.php';
require_once 'classes/JWT.php';

$jwt = new JWT();
// var_dump($jwt->getHeader(TOKEN));
// var_dump($jwt->getPayload(TOKEN));

var_dump($jwt->check(TOKEN, SECRET));