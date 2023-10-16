<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPaniers"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Groups(["getPaniers"])]
    private ?string $prixPanier = null;

    #[ORM\OneToOne(mappedBy: 'Panier', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'Panier')]
    #[Groups(["getPaniers"])]
    private Collection $produits;

    #[ORM\OneToOne(mappedBy: 'Panier', cascade: ['persist', 'remove'])]
    #[Groups(["getPaniers"])]
    private ?Paiement $paiement = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $nomProduitPanier = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Groups(["getPaniers"])]
    private ?string $prixProduitPanier = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $typeProduitPanier = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPaniers"])]
    private ?string $imageProduitPanier = null;

    #[ORM\Column]
    #[Groups(["getPaniers"])]
    private ?int $quantiteProduitPanier = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixPanier(): ?string
    {
        return $this->prixPanier;
    }

    public function setPrixPanier(string $prixPanier): static
    {
        $this->prixPanier = $prixPanier;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPanier(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPanier() !== $this) {
            $user->setPanier($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addPanier($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removePanier($this);
        }

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): static
    {
        // unset the owning side of the relation if necessary
        if ($paiement === null && $this->paiement !== null) {
            $this->paiement->setPanier(null);
        }

        // set the owning side of the relation if necessary
        if ($paiement !== null && $paiement->getPanier() !== $this) {
            $paiement->setPanier($this);
        }

        $this->paiement = $paiement;

        return $this;
    }

    public function getNomProduitPanier(): ?string
    {
        return $this->nomProduitPanier;
    }

    public function setNomProduitPanier(string $nomProduitPanier): static
    {
        $this->nomProduitPanier = $nomProduitPanier;

        return $this;
    }

    public function getPrixProduitPanier(): ?string
    {
        return $this->prixProduitPanier;
    }

    public function setPrixProduitPanier(string $prixProduitPanier): static
    {
        $this->prixProduitPanier = $prixProduitPanier;

        return $this;
    }

    public function getTypeProduitPanier(): ?string
    {
        return $this->typeProduitPanier;
    }

    public function setTypeProduitPanier(string $typeProduitPanier): static
    {
        $this->typeProduitPanier = $typeProduitPanier;

        return $this;
    }

    public function getImageProduitPanier(): ?string
    {
        return $this->imageProduitPanier;
    }

    public function setImageProduitPanier(string $imageProduitPanier): static
    {
        $this->imageProduitPanier = $imageProduitPanier;

        return $this;
    }

    public function getQuantiteProduitPanier(): ?int
    {
        return $this->quantiteProduitPanier;
    }

    public function setQuantiteProduitPanier(int $quantiteProduitPanier): static
    {
        $this->quantiteProduitPanier = $quantiteProduitPanier;

        return $this;
    }
}
