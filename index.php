<?php

class Player {
    public $name;
    public $coins;

    public function __construct($name, $coins) {
        $this->name = $name;
        $this->coins = $coins;
    }

    public function points(Player $player) {
        $this->coins++;
        $player->coins--;
    }

    public function bankrupt () {
        return $this->coins == 0;
    }

    public function bank() {
        return $this->coins;
    }

    public function  odds ($player){
        return round($this->bank() / ($this->bank() + $player->bank()), 2) * 100 . "%";
    }
}

class Game {
    protected $player1;
    protected $player2;
    private $flips;

    public function __construct($player1, $player2) {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }
    public function start() {


        echo <<<EOT
            {$this->player1->name} chances: {$this->player1->odds($this->player2)}
            {$this->player2->name} chances: {$this->player2->odds($this->player1)}
        
        EOT;

        $this->play();
    }

    public function flip() {
        return rand(0,1) ? "орел" : "решка";

    }

    public function play () {
        while(true) {
            if($this->flip() == "орел") {
                $this->player1->points($this->player2);
            } else {
                $this->player2->points($this->player1);
            }


            if($this->player1->bankrupt() || $this->player2->bankrupt() ) {
                return $this->end();
            }

            $this->flips++;
        }
    }

    public function winner (): Player {
        return $this->player1->bank() > $this->player1->bank() ? $this->player1 : $this->player2;
    }

    public function end () {
        echo <<<EOT
            Game over.     
            {$this->player1->name} : {$this->player1->coins}
            {$this->player2->name} : {$this->player2->coins}
            
            Winner: {$this->winner()->name}
            Total Flips: {$this->flips}
            
        EOT;
    }
}

$game = new Game(
    new Player("Joe", 700),
    new Player("Jane", 50)
);

$game->start();