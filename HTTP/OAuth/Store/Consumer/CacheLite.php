<?php
/**
 * HTTP_OAuth_Store_CacheLite 
 * 
 * @uses      HTTP_OAuth_Store_Consumer_Interface
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */

require_once 'HTTP/OAuth/Store/Data.php';
require_once 'HTTP/OAuth/Store/Consumer/Interface.php';
require_once 'Cache/Lite.php';

/**
 * Cache_Lite driver for HTTP_OAuth_Store_Consumer_Interface
 * 
 * @uses      HTTP_OAuth_Store_Consumer_Interface
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */
class HTTP_OAuth_Store_CacheLite implements HTTP_OAuth_Store_Consumer_Interface
{
    const TYPE_REQUEST = 'requestTokens';
    const TYPE_ACESS   = 'accessTokens';
    const REQUEST_TOKEN_LIFETIME = 300;

    /**
     * Instance of Cache_Lite
     * 
     * @var Cache_Lite|null
     */
    protected $cache = null;

    /**
     * Default options for Cache_Lite
     * 
     * @var array
     */
    protected $defaultOptions = array(
        'cacheDir'             => '/tmp',
        'lifeTime'             => 300,
        'hashedDirectoryLevel' => 2
    );


    /**
     * Instantiate Cache_Lite.  Allows for options to be passed to Cache_Lite.  
     * 
     * @param array $options Options for Cache_Lite constructor
     * 
     * @return void
     */
    public function __construct(array $options = array())
    {
        $options     = array_merge($this->defaultOptions, $options);
        $this->cache = new Cache_Lite($options);
    }

    public function setRequestToken($token, $tokenSecret, $providerName, $sessionID)
    {
        $this->setOptions(self::TYPE_REQUEST, self::REQUEST_TOKEN_LIFETIME);
        $data = array(
            'token'        => $token,
            'tokenSecret'  => $tokenSecret,
            'providerName' => $providerName,
            'sessionID'    => $sessionID
        );

        return $this->cache->save(serialize($data),
                                  $this->consumerGetRequestTokenKey($providerName,
                                                                    $sessionID));
    }

    public function getRequestToken($providerName, $sessionID)
    {
        $this->setOptions(self::TYPE_REQUEST, self::REQUEST_TOKEN_LIFETIME);
        return unserialize($this->cache->get($this->consumerGetRequestTokenKey($providerName, $sessionID)));
    }

    protected function getRequestTokeKey($providerName, $sessionID)
    {
        return md5($providerName . ':' . $sessionID);
    }

    public function getAccessToken($consumerUserID, $providerName)
    {
        $this->setOptions(self::TYPE_ACCESS);
    }

    public function setAccessToken(HTTP_OAuth_Store_Data $data)
    {
        $this->setOptions(self::TYPE_ACCESS);
    }

    public function removeAccessToken(HTTP_OAuth_Store_Data $data)
    {
        $this->setOptions(self::TYPE_ACCESS);
    }

    /**
     * Sets options for Cache_Lite based on the needs of the current method.
     * Options set include the subdirectory to be used, and the expiration.
     * 
     * @param string $key    The sub-directory of the cacheDir
     * @param string $expire The cache lifetime (expire) to be used
     * 
     * @return void
     */
    protected function setOptions($key, $expire = null)
    {
        $cacheDir  = $this->defaultOptions['cacheDir'] . '/oauth/';
        $cacheDir .= rtrim($this->storeDirectories[$key], '/') . '/';

        $this->ensureDirectoryExists($cacheDir);

        $this->cache->setOption('cacheDir', $cacheDir);
        $this->cache->setOption('lifeTime', $expire);
    }

    /**
     * Make sure the given sub directory exists.  If not, create it.
     * 
     * @param string $dir The full path to the sub director we plan to write to
     * 
     * @return void
     */
    protected function ensureDirectoryExists($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}
?>
