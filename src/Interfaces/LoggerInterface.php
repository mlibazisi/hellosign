<?php
/*
 * This file is part of the signer package
 *
 * Copyright (c) 2017 Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Interfaces;

/**
 * The interface for error logging wrappers
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
interface LoggerInterface
{

    /**
     * Logs an error
     *
     * @param string $message The message to log
     * @param string $file_path The full file path of the log
     *
     * @return void
     */
    public function log( $message, $file_path = NULL );

}