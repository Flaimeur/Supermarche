<?php
class Modele {
    private $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=supermarche;charset=utf8', 'root', '');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getFamilles() {
        $sql = "SELECT * FROM famille";
        $sth = $this->bdd->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProduitsParFamille($idFamille) {
        $sql = "SELECT * FROM produit WHERE IdFamille = :id";
        $sth = $this->bdd->prepare($sql);
        // C'est ici qu'on sécurise la variable
        $sth->execute(['id' => $idFamille]);
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
}
?>