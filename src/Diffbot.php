<?php
/**
 * Class Diffbot
 *
 * The main class for API consumption
 *
 * PHP version 5.6
 *
 * @category File
 * @package  Mishbah\Diffboot
 * @author   mishbah <misbah.qadri@gmail.com>
 * @license  LICENSE.md MIT License
 * @link     http://google.com
 */

namespace Mishbah\Diffbot;

use Mishbah\Diffbot\Exceptions\DiffbotException;

/**
 * Class Diffbot
 *
 * The main class for API consumption
 *
 * @category Class
 * @package  Mishbah\Diffboot
 * @author   mishbah <misbah.qadri@gmail.com>
 * @license  LICENSE.md MIT License
 * @link     http://google.com
 */
class Diffbot
{
    /**
     * Token for access API
     *
     * @var string The API access token
    */
    protected static $token = null;

    /**
     * Set instance Token
     *
     * @var string The instance token, settable once per new instance
    */
    protected $instanceToken;

    /**
     * Create a new Diffbot Instance
     *
     * @param string|null $token The API access token
     *
     * @throws DiffbotException When no token is provided
     */
    public function __construct($token = null)
    {
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot ';
                $msg .= 'class with a $token parameter.';
                throw new DiffbotException($msg);
            }
        } else {
            self::validateToken($token);
            $this->instanceToken = $token;
        }
    }

    /**
     * Sets the token for all future new instances
     *
     * @param string $token The API access token, as obtained on diffbot.com/dev
     *
     * @return void
     */
    public static function setToken($token)
    {
        self::validateToken($token);
        self::$token = $token;
    }

    /**
     * Validate token
     *
     * @param string $token The API access token
     *
     * @throws InvalidArgumentException When no token is provided
     *
     * @return boolean
     */
    protected static function validateToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token is not a string.');
        }
        if (strlen($token) < 4) {
            $tokenToShort = 'Token "' . $token . '" is too short, and thus invalid.';
            throw new \InvalidArgumentException($tokenToShort);
        }
        return true;
    }
}
