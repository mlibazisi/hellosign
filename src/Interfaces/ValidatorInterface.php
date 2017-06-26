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
 * The interface for validation
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
interface ValidatorInterface
{

    /**
     * Validate an email
     *
     * @param string $string The string to validate
     *
     * @return bool
     */
    public function email( $string );

    /**
     * Validate a URL
     *
     * @param string $string The string to validate
     *
     * @return bool
     */
    public function url( $string );

}