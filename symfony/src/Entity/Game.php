<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player1;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player2;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $whoseTurn;

    /**
     * @ORM\Column(type="json", nullable=false)
     */
    private $grid;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isOver;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     */
    private $winner;

    public function getId()
    {
        return $this->id;
    }

    public function getPlayer1(): ?Player
    {
        return $this->player1;
    }

    public function setPlayer1(Player $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?Player
    {
        return $this->player2;
    }

    public function setPlayer2(Player $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getWhoseTurn(): ?Player
    {
        return $this->whoseTurn;
    }

    public function setWhoseTurn(Player $whoseTurn): self
    {
        $this->whoseTurn = $whoseTurn;

        return $this;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function setGrid($grid): self
    {
        $this->grid = $grid;

        return $this;
    }

    public function getIsOver(): ?bool
    {
        return $this->isOver;
    }

    public function setIsOver(bool $isOver): self
    {
        $this->isOver = $isOver;

        return $this;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
