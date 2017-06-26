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
 * The interface for containers
 *
 * @author Mlibazisi Prince Mabandla <mlibazisi@gmail.com>
 */
interface ContainerInterface
{

    /**
     * Fetch item from container
     *
     * @param string $key       The key of the item to fetch
     * @param mixed  $default   Value to return if key is not found
     * @param bool   $required  Required, so throw exception if it is not found
     *
     * @return mixed
     */
    public function get( $key, $default = NULL, $required = TRUE );

    /**
     * Add an item to the container
     *
     * @param string $key       The key of the item
     * @param string $value     The value of the item
     *
     * @return void
     */
    public function set( $key, $value );

}