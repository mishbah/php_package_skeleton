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
use GuzzleHttp\Client;

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
     * @var Client The HTTP clients to perform requests with
     */
    protected $client;

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

    /**
     * Sets the client to be used for querying the API endpoints
     *
     * @param Client $client
     * @return $this
     */
    public function setHttpClient(Client $client = null)
    {
        if ($client === null) {
            $client = new Client();
        }
        $this->client = $client;
        return $this;
    }

    /**
     * Returns either the instance of the Guzzle client that has been defined, or null
     * @return Client|null
     */
    public function getHttpClient()
    {
        return $this->client;
    }

    /**
     * Creates a Product API interface
     *
     * @param $url string Url to analyze
     * @return Product
     */
    public function createProductAPI($url)
    {
        $api = new Product($url);

        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }

        return $api->registerDiffbot($this);
    }

    /**
     * Creates an Article API interface
     *
     * @param $url string Url to analyze
     * @return Article
     */
    public function createArticleAPI($url)
    {
        $api = new Article($url);

        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }

        return $api->registerDiffbot($this);
    }

    /**
     * Creates an Image API interface
     *
     * @param $url string Url to analyze
     * @return Image
     */
    public function createImageAPI($url)
    {
        $api = new Image($url);

        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }

        return $api->registerDiffbot($this);
    }

    /**
     * Creates an Analyze API interface
     *
     * @param $url string Url to analyze
     * @return Analyze
     */
    public function createAnalyzeAPI($url)
    {
        $api = new Analyze($url);

        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }

        return $api->registerDiffbot($this);
    }
}
