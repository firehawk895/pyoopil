<?php

/**
 * Interface NotifyableInterface
 * All notification implementations will essentially follow this implementation
 * to be used seamlessly across the platform
 */
interface NotifyableInterface {
    public function push($message, $usersList);
}