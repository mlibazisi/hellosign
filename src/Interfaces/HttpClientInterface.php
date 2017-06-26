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
 * The interface for HTTP client wrappers
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
interface HttpClientInterface
{

    /**
     * Submit a GET http request
     *
     * @param string    $url        The url to get
     * @param array     $headers    Optional headers
     *
     * @return mixed
     */
    public function jsonGet( $url, array $headers = [] );

}