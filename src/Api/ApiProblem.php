<?php
/**
 * Initial version by: Patrick Luca Fazzi
 * Initial version created on: 29/03/2018
 */

namespace App\Api;

/**
 * Class ApiProblem
 * https://tools.ietf.org/html/draft-ietf-appsawg-http-problem-00#section-3
 * @package App\Api
 */
class ApiProblem
{
    const TYPE_ENTITY_NOT_FOUND = 'entity_not_found';

    private static $titles = array(
        self::TYPE_ENTITY_NOT_FOUND => 'Entity not found'
    );

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $extraData = [];

    /**
     * ApiProblem constructor.
     * @param int $statusCode
     * @param string $type
     */
    public function __construct(int $statusCode, string $type)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;

        if (!isset(self::$titles[$type])) {
            throw new \InvalidArgumentException('No title for type '.$type);
        }

        $this->title = self::$titles[$type];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            $this->extraData,
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ]
        );
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set(string $name, $value)
    {
        $this->extraData[$name] = $value;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

}