<?php

namespace App\Entity;

use App\Repository\MonitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonitorRepository::class)]
class Monitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $short_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip_address = null;

    #[ORM\Column(nullable: true)]
    private ?int $port = null;

    #[ORM\Column(nullable: true)]
    private ?array $acceptedCodes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $interval_time = null;

    #[ORM\Column]
    private ?int $tries = null;

    /**
     * @var Collection<int, MonitorStatus>
     */
    #[ORM\OneToMany(targetEntity: MonitorStatus::class, mappedBy: 'monitor')]
    private Collection $monitorStatuses;

    public function __construct()
    {
        $this->monitorStatuses = new ArrayCollection();
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

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function setIpAddress(?string $ip_address): static
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port): static
    {
        $this->port = $port;

        return $this;
    }

    public function getAcceptedCodes(): ?array
    {
        return $this->acceptedCodes;
    }

    public function setAcceptedCodes(?array $acceptedCodes): static
    {
        $this->acceptedCodes = $acceptedCodes;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

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

    public function getIntervalTime(): ?int
    {
        return $this->interval_time;
    }

    public function setIntervalTime(int $interval_time): static
    {
        $this->interval_time = $interval_time;

        return $this;
    }

    public function getTries(): ?int
    {
        return $this->tries;
    }

    public function setTries(int $tries): static
    {
        $this->tries = $tries;

        return $this;
    }

    /**
     * @return Collection<int, MonitorStatus>
     */
    public function getMonitorStatuses(): Collection
    {
        return $this->monitorStatuses;
    }

    public function addMonitorStatus(MonitorStatus $monitorStatus): static
    {
        if (!$this->monitorStatuses->contains($monitorStatus)) {
            $this->monitorStatuses->add($monitorStatus);
            $monitorStatus->setMonitor($this);
        }

        return $this;
    }

    public function removeMonitorStatus(MonitorStatus $monitorStatus): static
    {
        if ($this->monitorStatuses->removeElement($monitorStatus)) {
            // set the owning side to null (unless already changed)
            if ($monitorStatus->getMonitor() === $this) {
                $monitorStatus->setMonitor(null);
            }
        }

        return $this;
    }
}
