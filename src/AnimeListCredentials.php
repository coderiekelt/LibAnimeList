<?php

namespace LibAnimeList;

/**
 * Class AnimeListCredentials
 * @package LibAnimeList
 */
class AnimeListCredentials
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
     * AnimeListCredentials constructor.
     * @param null $username
     * @param null $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function __toString()
    {
        if ($this->username === null || $this->password === null) {
            throw new \DomainException('Username or password may not be null to generate string.');
        }

        return sprintf('%s:%s', $this->username, $this->password);
    }

    /**
     * @param string $username
     * @return AnimeListCredentials
     */
    public function setUsername(string $username): AnimeListCredentials
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $password
     * @return AnimeListCredentials
     */
    public function setPassword(string $password): AnimeListCredentials
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}