<?php
declare(strict_types=1);

namespace App\Domain\Container;

use JsonSerializable;

class Container implements JsonSerializable
{

    const STATUS_PENDING = 'pending';
    const STATUS_STARTED = 'started';

    /**
     * @var ?int
     */
    private ?string $_id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $image;

    /**
     * @var string
     */
    private string $command;

    /**
     * @var string
     */
    private string $status;


    /**
     * @var array
     */
    private array $options;

    /**
     * @var string
     */
    private string $domain = '';


    /**
     * @param int|null $_id
     * @param string $name
     * @param string $image
     * @param array|object $options
     * @param string $command
     */
    public function __construct(
        string $domain,
        string $name,
        string $image,
        array|object $options,
        string $command,
        ?string $_id = null,
        ?string $status = self::STATUS_PENDING
    ) {
        $this->setId($_id);
        $this->setDomain($domain);
        $this->setName($name);
        $this->setImage($image);
        $this->setOptions((array)$options);
        $this->setCommand($command);
        $this->setStatus($status);
        $this->setDomain($domain);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            '_id'     => $this->_id,
            'domain'  => $this->domain,
            'name'    => $this->name,
            'image'   => $this->image,
            'options' => (array)$this->options,
            'command' => $this->command,
            'status'  => $this->status,
        ];
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->_id;
    }

    /**
     * @param ?string $_id
     *
     * @return Container
     */
    public function setId(?string $_id): Container
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Container
     */
    public function setName(string $name): Container
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Container
     */
    public function setImage(string $image): Container
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     *
     * @return Container
     */
    public function setCommand(string $command): Container
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Container
     */
    public function setOptions(array $options): Container
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Container
     */
    public function setStatus(?string $status): Container
    {
        if ( ! in_array($status, [self::STATUS_PENDING, self::STATUS_STARTED])) {
            $status = self::STATUS_PENDING;
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(?string $domain): void
    {
        $this->domain = $domain;
    }


}

