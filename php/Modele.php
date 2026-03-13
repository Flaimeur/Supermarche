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

    // Vérification des identifiants pour la connexion
    public function verifierClient($id, $mdp) {
        $sql = "SELECT * FROM adherent WHERE IdClient = :id AND MotDePasse = :mdp";
        $sth = $this->bdd->prepare($sql);
        $sth->execute([
            'id' => $id,
            'mdp' => $mdp
        ]);
        return $sth->fetch(PDO::FETCH_OBJ);
    }

    // Récupérer tous les clients (pour l'admin)
    public function getAllClients() {
        $sql = "SELECT * FROM adherent ORDER BY IdClient ASC";
        $sth = $this->bdd->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }

    // Récupérer un client par son ID
    public function getClientById($id) {
        $sql = "SELECT * FROM adherent WHERE IdClient = :id";
        $sth = $this->bdd->prepare($sql);
        $sth->execute(['id' => $id]);
        return $sth->fetch(PDO::FETCH_OBJ);
    }

    // Modifier un client
    public function modifierClient($id, $nom, $prenom, $adresse, $ville, $cp, $point, $estAdmin) {
        $sql = "UPDATE adherent SET 
                Nom = :nom, 
                Prenom = :prenom, 
                Adresse = :adresse, 
                Ville = :ville, 
                CodePostal = :cp, 
                point = :point, 
                EstAdmin = :estAdmin 
                WHERE IdClient = :id";
        $sth = $this->bdd->prepare($sql);
        return $sth->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'cp' => $cp,
            'point' => $point,
            'estAdmin' => $estAdmin
        ]);
    }

    // Supprimer un client (avec ses dépendances)
    public function supprimerClient($idClient) {
        try {
            $this->bdd->beginTransaction();

            // 1. Supprimer le contenu des factures liées à ce client
            $sql1 = "DELETE c FROM contenir c INNER JOIN facture f ON c.NumeroFacture = f.NumeroFacture WHERE f.IdClient = :id";
            $sth1 = $this->bdd->prepare($sql1);
            $sth1->execute(['id' => $idClient]);

            // 2. Supprimer les factures du client
            $sql2 = "DELETE FROM facture WHERE IdClient = :id";
            $sth2 = $this->bdd->prepare($sql2);
            $sth2->execute(['id' => $idClient]);

            // 3. Supprimer le client
            $sql3 = "DELETE FROM adherent WHERE IdClient = :id";
            $sth3 = $this->bdd->prepare($sql3);
            $res = $sth3->execute(['id' => $idClient]);

            $this->bdd->commit();
            return $res;

        } catch (PDOException $e) {
            $this->bdd->rollBack();
            return false;
        }
    }

    // --- GESTION DES PRODUITS (ADMIN) ---
    
    // Récupérer tous les produits avec le nom de leur famille
    public function getAllProduitsWithFamille() {
        $sql = "SELECT p.*, f.NomFamille FROM produit p 
                LEFT JOIN famille f ON p.IdFamille = f.IdFamille 
                ORDER BY p.IdFamille ASC, p.NomProd ASC";
        $sth = $this->bdd->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }

    // Ajouter un produit
    public function ajouterProduit($nom, $prix, $idFamille, $image = 'default.png') {
        $sql = "INSERT INTO produit (NomProd, Prix, IdFamille, Image) VALUES (:nom, :prix, :idFamille, :image)";
        $sth = $this->bdd->prepare($sql);
        return $sth->execute([
            'nom' => $nom,
            'prix' => $prix,
            'idFamille' => $idFamille,
            'image' => $image
        ]);
    }

    // Modifier un produit
    public function modifierProduit($id, $nom, $prix, $idFamille, $image) {
        $sql = "UPDATE produit SET NomProd = :nom, Prix = :prix, IdFamille = :idFamille, Image = :image WHERE IdProduit = :id";
        $sth = $this->bdd->prepare($sql);
        return $sth->execute([
            'id' => $id,
            'nom' => $nom,
            'prix' => $prix,
            'idFamille' => $idFamille,
            'image' => $image
        ]);
    }

    // Supprimer un produit (avec dépendances)
    public function supprimerProduit($idProduit) {
        try {
            $this->bdd->beginTransaction();

            // 1. Supprimer le produit des paniers existants
            $sql1 = "DELETE FROM contenir WHERE IdProduit = :id";
            $sth1 = $this->bdd->prepare($sql1);
            $sth1->execute(['id' => $idProduit]);

            // 2. Supprimer le produit
            $sql2 = "DELETE FROM produit WHERE IdProduit = :id";
            $sth2 = $this->bdd->prepare($sql2);
            $res = $sth2->execute(['id' => $idProduit]);

            $this->bdd->commit();
            return $res;
        } catch (PDOException $e) {
            $this->bdd->rollBack();
            return false;
        }
    }

}
?>