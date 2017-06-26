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

use Interfaces\ValidatorInterface;

/**
 * A simple validator
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
class ValidatorService implements ValidatorInterface
{

    /**
     * Validate an email
     *
     * @param string $string The string to validate
     *
     * @return bool
     */
    public function email( $string ) {

        return filter_var( $string, FILTER_VALIDATE_EMAIL );

    }

    /**
     * Validate a URL
     *
     * @param string $string The string to validate
     *
     * @return bool
     */
    public function url( $string ) {

        return filter_var( $string, FILTER_SANITIZE_URL );

    }

}