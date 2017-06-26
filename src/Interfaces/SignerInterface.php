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
 * The interface for signer wrappers
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
interface SignerInterface
{

    /**
     * Submit a signature request
     *
     * @param string $name      Signer name
     * @param string $email     Signer email address
     * @param string $file_path File for the signature request.
     *
     * @return void
     */
    public function sign( $name, $email, $file_path );

}