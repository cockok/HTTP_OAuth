<?php
/**
 * HTTP_OAuth_Store_Consumer_Interface 
 * 
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */

/**
 * A consumer storage interface for access tokens and request tokens.
 * 
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */
interface HTTP_OAuth_Store_Consumer_Interface
{
    public function setRequestToken($token, $tokenSecret, $providerName, $sessionID);
    public function getRequestToken($providerName, $sessionID);
    public function getAccessToken($consumerUserID, $providerName);
    public function setAccessToken(HTTP_OAuth_Store_Data $data);
    public function removeAccessToken(HTTP_OAuth_Store_Data $data);
}
?>
