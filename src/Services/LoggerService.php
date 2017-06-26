<?php
/*
 * This file is part of the signer package
 *
 * Copyright (c) 2017 Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Services;

use Constants\ConfigConstants;
use Interfaces\ContainerInterface;
use Interfaces\LoggerInterface;
use Exceptions\AppException;

/**
 * A wrapper for PHP error_log
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
class LoggerService implements LoggerInterface
{

    use \Helpers\Traits\FunctionTrait;

    /**
     * Container
     *
     * @var ContainerInterface
     *
     */
    private $_container;

    /**
     * SignerService constructor
     *
     * @param ContainerInterface $container
     *
     */
    public function __construct( ContainerInterface $container ) {

        $this->_container = $container;

    }

    /**
     * Logs an error
     *
     * @param string $message The message to log
     * @param string $file_path The full file path of the log
     *
     * @throws AppException
     *
     * @return bool
     */
    public function log( $message, $file_path = NULL )
    {

        if ( !$file_path ) {

            $file_path = $this->_container->get(
                ConfigConstants::LOG_FILE
            );

            $file_path = ROOT . '/' . ltrim( $file_path, '/' );
        }

        return $this->errorLog( $message . "\n", $file_path );

    }

}