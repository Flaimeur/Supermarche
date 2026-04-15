<?php
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=supermarche;charset=utf8', 'root', '');
    $sth = $bdd->prepare('SELECT IdClient, Nom, MotMagique FROM adherent WHERE IdClient IN (5, 6)');
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($data as $row) {
        $mm = $row['MotMagique'];
        echo "ID: " . $row['IdClient'] . " | Nom: " . $row['Nom'] . "\n";
        
        // Brute force de toutes les colonnes possibles pour l'ID 6
        if ($row['IdClient'] == 6) {
            $usersth = $bdd->prepare("SELECT * FROM adherent WHERE IdClient = 6");
            $usersth->execute();
            $fullUser = $usersth->fetch(PDO::FETCH_ASSOC);
            foreach ($fullUser as $k => $v) {
                if ($v !== null && password_verify($v, $mm)) {
                    echo "  -> MATCH trouvé dans colonne '$k' : '$v'\n";
                }
            }
        }
        
        // Tests classiques
        $tests = ['MARKO', 'CLEAN', 'MARKO ', 'CLEAN ', 'marko', 'clean'];
        foreach ($tests as $t) {
            if (password_verify($t, $mm)) {
                echo "  -> Correspond à '$t'\n";
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
