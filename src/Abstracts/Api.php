<?php

namespace Mishbah\Diffbot\Abstracts;

/**
 * Class Api
 * @package Mishbah\Diffbot\Abstracts
 */
abstract class Api
{
    /**
     * @var  Diffbot The parent class which spawned this one
     */
    protected $diffbot;

    /**
     * @var int Timeout value in ms - defaults to 30s if empty
     */
    protected $timeout = 30000;

    /**
     * Setting the timeout will define how long Diffbot will keep trying
     * to fetch the API results. A timeout can happen for various reasons, from
     * Diffbot's failure, to the site being crawled being exceptionally slow, and more.
     *
     * @param int|null $timeout Defaults to 30000 even if not set
     *
     * @return $this
     */
    public function setTimeout($timeout = null)
    {
        if ($timeout === null) {
            $timeout = 30000;
        }

        if (!is_int($timeout)) {
            throw new \InvalidArgumentException('Parameter is not an integer');
        }

        if ($timeout < 0) {
            throw new \InvalidArgumentException('Parameter is negative. Only positive timeouts accepted.');
        }

        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Sets the Diffbot instance on the child class
     * Used to later fetch the token, HTTP client, EntityFactory, etc
     * @param Diffbot $d
     * @return $this
     */
    public function registerDiffbot(Diffbot $d) {
        $this->diffbot = $d;

        return $this;
    }
}
