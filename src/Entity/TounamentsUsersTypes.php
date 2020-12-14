<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TounamentsUsersTypes
 *
 * @ORM\Table(name="tounaments_users_types")
 * @ORM\Entity
 */
class TounamentsUsersTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_owner_types", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOwnerTypes;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    public function getIdOwnerTypes(): ?int
    {
        return $this->idOwnerTypes;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
