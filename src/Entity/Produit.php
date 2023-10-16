<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPaniers"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $nomProduit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Groups(["getPaniers"])]
    private ?string $prixProduit = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $typeProduit = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $imageProduit = null;

    #[ORM\Column]
    #[Groups(["getPaniers"])]
    private ?int $quantiteProduit = null;

    #[ORM\ManyToMany(targetEntity: Panier::class, inversedBy: 'produits')]
    private Collection $Panier;

    public function __construct()
    {
        $this->Panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getPrixProduit(): ?string
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(string $prixProduit): static
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getTypeProduit(): ?string
    {
        return $this->typeProduit;
    }

    public function setTypeProduit(string $typeProduit): static
    {
        $this->typeProduit = $typeProduit;

        return $this;
    }

    public function getImageProduit(): ?string
    {
        return $this->imageProduit;
    }

    public function setImageProduit(string $imageProduit): static
    {
        $this->imageProduit = $imageProduit;

        return $this;
    }

    public function getQuantiteProduit(): ?int
    {
        return $this->quantiteProduit;
    }

    public function setQuantiteProduit(int $quantiteProduit): static
    {
        $this->quantiteProduit = $quantiteProduit;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPanier(): Collection
    {
        return $this->Panier;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->Panier->contains($panier)) {
            $this->Panier->add($panier);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        $this->Panier->removeElement($panier);

        return $this;
    }
}
