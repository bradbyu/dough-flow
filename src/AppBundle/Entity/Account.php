<?php
/**
 * Dough Flow Budget Forecasting System
 *
 * @author    Brad Neeley
 * @copyright Copyright (c) 2017
 * @license   All rights reserved
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Account
 *
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account
{
    const TYPE_CHECKING    = 'checking';
    const TYPE_SAVINGS     = 'savings';
    const TYPE_CREDIT_CARD = 'credit card';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name = '';

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    protected $type = self::TYPE_CHECKING;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }
}
