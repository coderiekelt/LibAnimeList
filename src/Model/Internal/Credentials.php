<?php

namespace LibAnimeList\Model\Internal;

/**
 * Class Credentials
 * @package LibAnimeList\Model\Internal
 */
class Credentials
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $valid;

    /**
     * Credentials constructor.
     * @param null $username
     * @param null $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s:%s', $this->username, $this->password);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Credentials
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Credentials
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     * @return Credentials
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    }
}