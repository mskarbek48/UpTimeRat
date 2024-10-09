<?php

namespace App\Entity;

use App\Repository\NotificationSettingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationSettingsRepository::class)]
class NotificationSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private array $data = [];

    /**
     * @var Collection<int, Monitor>
     */
    #[ORM\ManyToMany(targetEntity: Monitor::class, mappedBy: 'notifications')]
    private Collection $monitors;

    public function __construct()
    {
        $this->monitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Collection<int, Monitor>
     */
    public function getMonitors(): Collection
    {
        return $this->monitors;
    }

    public function addMonitor(Monitor $monitor): static
    {
        if (!$this->monitors->contains($monitor)) {
            $this->monitors->add($monitor);
            $monitor->addNotification($this);
        }

        return $this;
    }

    public function removeMonitor(Monitor $monitor): static
    {
        if ($this->monitors->removeElement($monitor)) {
            $monitor->removeNotification($this);
        }

        return $this;
    }
}
