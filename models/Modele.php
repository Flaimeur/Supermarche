<?php
class Modele {
    private $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO('mysql:host=127.0.0.1;dbname=supermarche;charset=utf8', 'root', '');
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
        // Hachage des identifiants sensibles
        $mdpHache = password_hash($mdp, PASSWORD_BCRYPT);
        $mmHache = password_hash($motMagique, PASSWORD_BCRYPT);

        $sql = "INSERT INTO adherent (Nom, Prenom, Adresse, Ville, CodePostal, MotDePasse, Date_naissance, point, MotMagique, role) 
                VALUES (:nom, :prenom, :adresse, :ville, :cp, :mdp, :dateN, 0, :mm, 'client')";
        
        $sth = $this->bdd->prepare($sql);
        
        return $sth->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'cp' => $cp,
            'mdp' => $mdpHache,
            'dateN' => $dateNaissance,
            'mm' => $mmHache
        ]);
    }

    // Vérification des identifiants pour la connexion
    public function verifierClient($id, $mdp) {
        $sql = "SELECT * FROM adherent WHERE IdClient = :id";
        $sth = $this->bdd->prepare($sql);
        $sth->execute(['id' => $id]);
        $user = $sth->fetch(PDO::FETCH_OBJ);

        if ($user && password_verify($mdp, $user->MotDePasse)) {
            return $user;
        }
        return false;
    }

    // Vérifier si un client existe et son mot magique
    public function verifyMagicWord($id, $magicWord) {
        $sql = "SELECT MotMagique FROM adherent WHERE IdClient = :id";
        $sth = $this->bdd->prepare($sql);
        $sth->execute(['id' => $id]);
        $user = $sth->fetch(PDO::FETCH_OBJ);

        if ($user && password_verify($magicWord, $user->MotMagique)) {
            return true;
        }
        return false;
    }

    // Mettre à jour le mot de passe
    public function updatePassword($id, $newMdp) {
        $mdpHache = password_hash($newMdp, PASSWORD_BCRYPT);
        $sql = "UPDATE adherent SET MotDePasse = :mdp WHERE IdClient = :id";
        $sth = $this->bdd->prepare($sql);
        return $sth->execute([
            'id' => $id,
            'mdp' => $mdpHache
        ]);
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
    public function modifierClient($id, $nom, $prenom, $adresse, $ville, $cp, $point, $role) {
        $sql = "UPDATE adherent SET 
                Nom = :nom, 
                Prenom = :prenom, 
                Adresse = :adresse, 
                Ville = :ville, 
                CodePostal = :cp, 
                point = :point, 
                role = :role 
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
            'role' => $role
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