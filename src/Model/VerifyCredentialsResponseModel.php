<?php

namespace LibAnimeList\Model;

/**
 * Class VerifyCredentialsResponseModel
 * @package LibAnimeList\Model
 */
class VerifyCredentialsResponseModel extends BaseModel
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * VerifyCredentialsResponseModel constructor.
     * @param null $rootNode
     */
    public function __construct($rootNode = null)
    {
        $rootNode = 'user';

        parent::__construct($rootNode);
    }
}