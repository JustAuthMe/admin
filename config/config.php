<?php

if(file_exists(__DIR__ . '/config.dist.php')){
    require_once __DIR__ . '/config.dist.php';
}else{
    require_once __DIR__ . '/config.dev.php';
}

const DATA_LIST = ['email', 'firstname', 'lastname', 'birthdate', 'avatar'];
const RELEASE_NAME = DEPLOYED_REF . '-' . DEPLOYED_COMMIT;