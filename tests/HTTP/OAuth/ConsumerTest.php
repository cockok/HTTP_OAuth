<?php
/**
 * HTTP_OAuth
 *
 * Implementation of the OAuth specification
 *
 * PHP version 5.2.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth_Provider
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth_Provider
 */

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'HTTP/OAuth/Consumer.php';

class HTTP_OAuth_ConsumerTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $instance = new HTTP_OAuth_Consumer('key', 'secret');
        $this->assertType('HTTP_OAuth_Consumer', $instance);
        $this->assertEquals('key', $instance->getKey());
        $this->assertEquals('secret', $instance->getSecret());

        $instance = new HTTP_OAuth_Consumer('key', 'secret', 'token', 'tokenSecret');
        $this->assertType('HTTP_OAuth_Consumer', $instance);
        $this->assertEquals('key', $instance->getKey());
        $this->assertEquals('secret', $instance->getSecret());
        $this->assertEquals('token', $instance->getToken());
        $this->assertEquals('tokenSecret', $instance->getTokenSecret());
    }

}

?>