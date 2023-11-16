<!-- Mettre des commentaires dans le code qui explique tout 

Lien du repo GIT par message en MP vendredi avant minuit

- nom
- prénom
- classe
- école

Détail : 

> *Tous les choix à faire son Random, pas de saisie même pour le bonus*
> 

### Game

- Créer héros
- Créer enemy
- Gérer les rencontres
- Lancer les combats
- Rejouer
- Choix du héros
- Choix de la difficulté

### Character

- name
- nombre billes
- gagner
- perdre 

### Hero extend Character

- bonus
- malus
- tricher (bonus) (public)
- Choisir Even or Odd (public)
- checkOddEven (private)

### Enemy extend Character

- âge

### Utils (abstract)

- generateRandomNumber(min, max) {};

utils::functiunname -->




<?php

// On definit la classe Character
class Character { // On crée un personnage avec un nom et un nombre de billes
    public $name;
    public $billes;

    public function __construct($name, $billes) { // utilisation de __construct qui est une methode magique qui permet d'initialiser les attributs de la classe
        $this->name = $name;
        $this->billes = $billes;
    }

    public function getName() {
        return $this->name;
    }

    public function getBilles() {
        return $this->billes;
    }

    public function lose($quantite) { // les quanttés perdus de billes
        $this->billes -= $quantite;
    }

    public function win($quantite) { // les quanttés gagnés de billes
        $this->billes += $quantite;
    }
}





// On definit la classe Hero qui herite de la classe Character
class Hero extends Character {  // On crée un hero avec un nom, un nombre de billes, un bonus et un malus
    public $bonus;
    public $malus;

    public function __construct($name, $billes, $bonus, $malus) {
        parent::__construct($name, $billes);
        $this->bonus = $bonus;
        $this->malus = $malus;
    }

    public function getBonus() { // On recupere le bonus
        return $this->bonus;
    }

    public function getMalus() { // On recupere le malus
        return $this->malus;
    }

    public function tricher() { // ça triche ça triche
        $this->billes += $this->bonus;
    }

    public function choisirPairOuImpair() { // On choisi pair ou impair
        $random = rand(0, 1);
        return $random == 0 ? 'pair' : 'impair';
    }

    private function checkImpairPair($number) { // On verifie si le nombre est pair ou impair
        return $number % 2 == 0 ? 'pair' : 'impair';
    }
}







// On definit la classe Ennemi qui herite de la classe Character
class Ennemi extends Character {
    public $age;

    public function __construct($name, $billes, $age) { // On crée un ennemi avec un nom, un nombre de billes et un age. utilisation de nom simpes pour les ennemis
        parent::__construct($name, $billes);
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }
}







// On definit la classe Game
class Game {
    private $hero;
    private $ennemis;
    private $difficulty;

    public function __construct() { // On crée le hero, les ennemis et la difficulté
        $this->Hero();
        $this->Ennemis();
        $this->Difficulty();
    }

    private function Hero() {
        $heroes = [
            new Hero('Seong Gi-hun', 15, 1, 2), // name, billes, bonus, malus
            new Hero('Kang Sae-byeok', 25, 2, 1),
            new Hero('Cho Sang-woo', 35, 3, 0)
        ];
        $this->hero = $heroes[rand(0, 2)]; // On choisi un hero au hasard
    }

    private function Ennemis() {
        $enemies = [];
        for ($i = 1; $i <= 20; $i++) { // On crée 20 ennemis
            $name = 'Ennemi ' . $i;
            $billes = rand(1, 20);
            $age = rand(18, 99);
            $ennemis[] = new Ennemi($name, $billes, $age);
        }
        $this->ennemis = $ennemis; // On stock les ennemis dans la variable ennemis
    }

    private function Difficulty() { // On choisi la difficulté
        $difficulties = [
            'easy' => 5,
            'hard' => 10,
            'impossible' => 20
        ];
        $this->difficulty = array_rand($difficulties);
    }









    // Lancemant du jeu

    public function start() {
        $rounds = $this->difficulty == 'easy' ? 5 : ($this->difficulty == 'hard' ? 10 : 20);
        $currentRound = 1; // On initialise le round à 1

        while ($currentRound <= $rounds && $this->hero->getBilles() > 0) {
            echo "<br>Round $currentRound<br>";
            $enemy = $this->ennemis[array_rand($this->ennemis)];
            echo "Tu joue le hero " . $this->hero->getName() . " qui a " . $this->hero->getBilles() . " billes.<br>";
            echo "Tu affrontes l'" . $enemy->getName() . " qui a " . $enemy->getAge() . " ans et qui a " . $enemy->getBilles() . " billes.<br>";
            $heroChoice = $this->hero->choisirPairOuImpair();
            $enemyChoice = $enemy->getBilles() % 2 == 0 ? 'pair' : 'impair';
            echo "Tu es $heroChoice et ton ennemi  $enemyChoice.<br>";
            if ($heroChoice == $enemyChoice) {
                echo "Tu as gagné sah ! Tu obtiens " . ($enemy->getBilles() + $this->hero->getBonus()) . " billes.<br>";
                $this->hero->win($enemy->getBilles() + $this->hero->getBonus());
                echo "Tu as desormais " . $this->hero->getBilles() . " billes.<br>";
                unset($this->ennemis[array_search($enemy, $this->ennemis)]);
            } else {
                echo "T'as perdu mskn, tu perds donc " . ($enemy->getBilles() + $this->hero->getMalus()) . " billes.<br><br>";
                $this->hero->lose($enemy->getBilles() + $this->hero->getMalus());
                echo "Tu as desormais " . $this->hero->getBilles() . " billes.<br><br>";
            }
            $currentRound++;
        }
        if ($this->hero->getBilles() > 0) {
            echo "<br>Psartek ! Tu as gagné la partie ainsi que 45,6 milliards de won sud-coréens.<br>";
        } else {
            echo "Mon gars c'est perdu je crois, tu n'as plus de billes .<br>";
        }
    }
}

$game = new Game(); // On crée une nouvelle partie
$game->start(); // On lance la partie
?>
