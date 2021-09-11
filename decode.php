<?php
// mon token 1 j
// const TOKEN = 'eyJ0eXAiOiJqV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjb250YWN0QGRlbW8uZnIiLCJpYXQiOjE2MzEzNDE3NTMsImV4cCI6MTYzMTQyODE1M30.Or0XHNE2rEonNoVEMW8pEEhORDgXK2mOXtiy_aIMCeE';

// mon token 60 s
// const TOKEN = 'eyJ0eXAiOiJqV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjb250YWN0QGRlbW8uZnIiLCJpYXQiOjE2MzEzNTI3OTUsImV4cCI6MTYzMTM1Mjg1NX0.ye9U5_kz5BvFASnsDPyzFJXjvxVyjmGtXnRk7G21AfU';

// token exemple 60 s
// const TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjb250YWN0QGRlbW8uZnIiLCJpYXQiOjE2MjM1MDIxMzgsImV4cCI6MTYyMzUwMjE5OH0.fk5_pPeO-gITVsRk9Aijv8h3upq32e3cnpFGCpyi1eY';


// token 20 s test false puis true
const TOKEN = 'eyJ0eXAiOiJqV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjb250YWN0QGRlbW8uZnIiLCJpYXQiOjE2MzEzNTM4NzUsImV4cCI6MTYzMTM1Mzg5NX0.thW0NiFmqiHsN-Ay8R1XGgSowOp3yEXuNnpCOQ3tL10';


require_once 'includes/config.php';
require_once 'classes/JWT.php';

$jwt = new JWT();
// var_dump($jwt->getHeader(TOKEN));
// var_dump($jwt->getPayload(TOKEN));

// var_dump($jwt->check(TOKEN, SECRET));
var_dump($jwt->isExpired(TOKEN));