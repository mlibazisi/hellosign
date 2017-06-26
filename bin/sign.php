<?php

define( 'ROOT', realpath( __DIR__ . '/../' ) . '/' );

require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'src/Constants/ServiceConstants.php';

$args = getArgs( $argv );

if ( !$args ) {
    error( "Retry command: php sign.php [name] [email] [file_path]" );
    stop();
}

$config_file = ROOT . 'config/config.ini';
$params_file = ROOT . 'config/parameters.ini';

if ( !file_exists( $config_file )
|| !file_exists( $params_file )) {
    error( "parameters.ini and config.ini are both required in /configs" );
    stop();
}

$container    = new Services\ContainerService();
$config_array = parse_ini_file( $config_file );
$params_array = parse_ini_file( $params_file );

$container->merge( $config_array );
$container->merge( $params_array );

$container->set(
    \Constants\ServiceConstants::HTTP_CLIENT,
    new Services\HttpClientService()
);

$logger = new Services\LoggerService( $container );

$container->set(
    \Constants\ServiceConstants::LOGGER,
    $logger
);

$container->set(
    \Constants\ServiceConstants::VALIDATOR,
    new Services\ValidatorService()
);

$signer = new Services\SignerService( $container );

try {

    $success = $signer->sign( $args['name'], $args['email'], $args['file_path'] );

    if ( !$success ) {
        error( "An error occured. Please check the logs!" );
        stop();
    }

} catch ( \Exceptions\AppException $e ) {

    error( "ERROR: File: {$e->getFile()} | Line: {$e->getLine()} | Message: {$e->getMessage()}" );
    stop();

}

success( 'Signature request successfully sent to ' . $args['email'] );
stop();

function getArgs( array $args ) {

    if ( empty( $args[3] )
        || !empty( $args[4] ) ) {
        return [];
    }

    return [
        'name'      => trim( $args[1] ),
        'email'     => trim( $args[2] ),
        'file_path' => trim( $args[3] )
    ];

}

function error( $error ) {

    echo "\033[31m{$error}\033[00m\r\n";

}

function success( $message ) {

    echo "\033[32m{$message}\033[00m\r\n";

}

function stop() {

    exit;

}

?>