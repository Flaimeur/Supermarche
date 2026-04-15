<?php
// Script temporaire de migration des mots de passe
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=supermarche;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT IdClient, MotDePasse, MotMagique FROM adherent";
    $sth = $bdd->prepare($sql);
    $sth->execute();
    $users = $sth->fetchAll(PDO::FETCH_OBJ);

    $count = 0;
    foreach ($users as $u) {
        $update = [];
        $params = ['id' => $u->IdClient];

        // On hache le MDP s'il n'est pas déjà haché
        if (strpos($u->MotDePasse, '$2y$') !== 0) {
            $update[] = "MotDePasse = :mdp";
            $params['mdp'] = password_hash($u->MotDePasse, PASSWORD_BCRYPT);
        }

        // On hache le Mot Magique s'il n'est pas déjà haché
        if ($u->MotMagique && strpos($u->MotMagique, '$2y$') !== 0) {
            $update[] = "MotMagique = :mm";
            $params['mm'] = password_hash($u->MotMagique, PASSWORD_BCRYPT);
        }

        if (!empty($update)) {
            $sqlUp = "UPDATE adherent SET " . implode(", ", $update) . " WHERE IdClient = :id";
            $sthUp = $bdd->prepare($sqlUp);
            $sthUp->execute($params);
            $count++;
        }
    }

    echo "Migration terminée. $count utilisateurs mis à jour.\n";

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>
