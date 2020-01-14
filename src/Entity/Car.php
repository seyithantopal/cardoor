<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $star;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fuel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $doors;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $gearbox;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $abs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $airbag;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bluetooth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carkit;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gps;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $remote_start;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $parking_cameras;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $music;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="cars")
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="car")
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userid;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(?int $star): self
    {
        $this->star = $star;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        //return $this->title;
        // to show the id of the Category in the select
        //return $this->id;
        //return (string)$this->fuel;
        return (string)$this->id;
    }

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(?int $doors): self
    {
        $this->doors = $doors;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(?string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getAbs(): ?bool
    {
        return $this->abs;
    }

    public function setAbs(?bool $abs): self
    {
        $this->abs = $abs;

        return $this;
    }

    public function getAirbag(): ?bool
    {
        return $this->airbag;
    }

    public function setAirbag(?bool $airbag): self
    {
        $this->airbag = $airbag;

        return $this;
    }

    public function getBluetooth(): ?bool
    {
        return $this->bluetooth;
    }

    public function setBluetooth(?bool $bluetooth): self
    {
        $this->bluetooth = $bluetooth;

        return $this;
    }

    public function getCarkit(): ?bool
    {
        return $this->carkit;
    }

    public function setCarkit(?bool $carkit): self
    {
        $this->carkit = $carkit;

        return $this;
    }

    public function getGps(): ?bool
    {
        return $this->gps;
    }

    public function setGps(?bool $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    public function getRemoteStart(): ?bool
    {
        return $this->remote_start;
    }

    public function setRemoteStart(?bool $remote_start): self
    {
        $this->remote_start = $remote_start;

        return $this;
    }

    public function getParkingCameras(): ?bool
    {
        return $this->parking_cameras;
    }

    public function setParkingCameras(?bool $parking_cameras): self
    {
        $this->parking_cameras = $parking_cameras;

        return $this;
    }

    public function getMusic(): ?bool
    {
        return $this->music;
    }

    public function setMusic(?bool $music): self
    {
        $this->music = $music;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getCar() === $this) {
                $image->setCar(null);
            }
        }

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(?int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
