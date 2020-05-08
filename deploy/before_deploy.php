<?php

$env_vars = [
    'PROD_ENV' => 'bool',
    'PROD_HOST' => 'string',
    'LOGGING' => 'bool',

    'DB_ADMIN_HOST' => 'string',
    'DB_ADMIN_NAME' => 'string',
    'DB_ADMIN_USER' => 'string',
    'DB_ADMIN_PASS' => 'string',

    'DB_CORE_HOST' => 'string',
    'DB_CORE_NAME' => 'string',
    'DB_CORE_USER' => 'string',
    'DB_CORE_PASS' => 'string',

    'DB_CONSOLE_HOST' => 'string',
    'DB_CONSOLE_NAME' => 'string',
    'DB_CONSOLE_USER' => 'string',
    'DB_CONSOLE_PASS' => 'string',

    'DB_WEBSITE_HOST' => 'string',
    'DB_WEBSITE_NAME' => 'string',
    'DB_WEBSITE_USER' => 'string',
    'DB_WEBSITE_PASS' => 'string',

    'REDIS_HOST' => 'string',
    'REDIS_PORT' => 'int',
    'REDIS_PASS' => 'string',

    'JAM_API' => 'string',
    'JAM_SECRET' => 'string',

    'JAM_INTERNAL_API_KEY' => 'string',
    'JAM_ALERT_API' => 'string',
    'JAM_STATIC_API' => 'string',
    'JAM_WEBSITE_PAGE_RENDERING_KEY' => 'string',

    'DEPLOYED_REF' => 'CI_COMMIT_REF_NAME',
    'DEPLOYED_COMMIT' => 'CI_COMMIT_SHA',
    'ENV_NAME' => 'ENV_NAME'
];

$env_prefix = getenv('ENV_PREFIX');
$config_output = "<?php \n";
foreach ($env_vars as $KEY => $type){
    switch($type){
        case 'bool':
            $config_output .= "const $KEY = " . (getenv($env_prefix.$KEY) ? 'true':'false'). ";\n";
            break;
        case 'string':
            $config_output .= "const $KEY = '" . addcslashes(getenv($env_prefix.$KEY), "'"). "';\n";
            break;
        case 'int':
            $config_output .= "const $KEY = " . intval(getenv($env_prefix.$KEY)) . ";\n";
            break;
        default:
            $config_output .= "const $KEY = '" . addcslashes(getenv($type), "'") . "';\n";
            break;
    }
}

echo $config_output;