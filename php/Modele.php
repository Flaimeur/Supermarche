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
    
    public function getProduit($idProduit) {
        $sql = "SELECT * FROM produit WHERE IdProduit = :id";
        $sth = $this->bdd->prepare($sql);
        $sth->execute(['id' => $idProduit]);
        return $sth->fetch(PDO::FETCH_OBJ); // On utilise fetch() car on veut une seule ligne
    }
    
    // Inscription d'un nouveau client
    public function ajouterClient($nom, $prenom, $adresse, $ville, $cp, $mdp, $dateNaissance, $motMagique) {
        // On insère le client. 'point' est mis à 0 par défaut.
        $sql = "INSERT INTO adherent (Nom, Prenom, Adresse, Ville, CodePostal, MotDePasse, Date_naissance, point, MotMagique) 
                VALUES (:nom, :prenom, :adresse, :ville, :cp, :mdp, :dateN, 0, :motMagique)";
        
        $sth = $this->bdd->prepare($sql);
        
        return $sth->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'cp' => $cp,
            'mdp' => $mdp,
            'dateN' => $dateNaissance,
            'motMagique' => $motMagique
        ]);
    }
}
?>