<?php

namespace App\Service;

/**
 * Class SessionService
 * @package App\Service
 */
class SessionService
{
    /**
     * @var array
     */
    private $credentials;

    /**
     * SessionService constructor.
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param string $username
     * @param string $password
     * @return string | bool $sid
     *
     */
    public function authenticate(string $username, string $password)
    {
        if (!(
            $this->credentials['username'] == $username &&
            $this->credentials['password'] == $password
        )) {
            return false;
        }

        $this->init();
        return $_SESSION['_sid'] = PHP_SAPI !== 'cli' ? session_id() : md5(random_bytes(32));
    }

    /**
     * @param string $sid
     * @return bool
     */
    public function check(string $sid): bool
    {
        $this->init();
        return isset($_SESSION['_sid']) && $_SESSION['_sid'] === $sid;
    }

    /**
     *
     */
    private function init()
    {
        if (PHP_SAPI !== 'cli') {
            session_start([
                'use_cookies'      => false,
                'use_only_cookies' => false,
                'name'             => 'sid'
            ]);
        }
    }
}
