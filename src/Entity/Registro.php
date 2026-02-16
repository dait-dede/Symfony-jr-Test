<?php

namespace App\Entity;

use App\Repository\RegistroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistroRepository::class)]
class Registro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $usuarioId = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $origen = null;

    #[ORM\Column(length: 50)]
    private ?string $estatus = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $FechaRegistro = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): static
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getOrigen(): ?string
    {
        return $this->origen;
    }

    public function setOrigen(?string $origen): static
    {
        $this->origen = $origen;

        return $this;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function setEstatus(string $estatus): static
    {
        $this->estatus = $estatus;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeImmutable
    {
        return $this->FechaRegistro;
    }

    public function setFechaRegistro(\DateTimeImmutable $FechaRegistro): static
    {
        $this->FechaRegistro = $FechaRegistro;

        return $this;
    }
}
