<?php

namespace LibAnimeList\Model;

/**
 * Class BaseModel
 * @package LibAnimeList\Model
 */
class BaseModel
{
    /**
     * @var string|null
     */
    protected $rootNode;

    /**
     * @var array
     */
    private $parseMissers;

    /**
     * BaseModel constructor.
     * @param string|null $rootNode
     */
    public function __construct($rootNode = null)
    {
        $this->rootNode = $rootNode;
        $this->parseMissers = [];
    }

    /**
     * @param string $xml
     */
    public function fromXml($xml)
    {
        $xmlDocument = simplexml_load_string($xml);

        $misses = [];

        // Loops through all the variables in the XmlObject, an tries to set our properties
        // accordingly to their names, for easy peasy lemon squeezy MyAnimeList parsing
        foreach (get_object_vars($xmlDocument->{$this->rootNode}) as $property) {
            if (in_array($property, get_class_vars(self::class))) {
                $this->{$property} = $xmlDocument->{$this->rootNode}->{$property};

                continue;
            }

            $misses[] = $property;
        }

        $this->parseMissers = $misses;
    }

    /**
     * @param $misser
     * @return bool
     */
    public function hasMisser($misser)
    {
        return in_array($misser, $this->parseMissers);
    }
}