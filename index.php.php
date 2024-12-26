<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pddrcs";

// Création de la connexion
$conn = new mysqli($servername, $username, $password);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Création de la base de données
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de données créée avec succès<br>";
} else {
    echo "Erreur de création de la base de données: " . $conn->error . "<br>";
}

// Sélectionner la base de données
$conn->select_db($dbname);

// Création d'une table exemple
$sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'utilisateurs' créée avec succès<br>";
} else {
    echo "Erreur de création de la table: " . $conn->error . "<br>";
}

// Fermeture de la connexion
$conn->close();
?>
<?php
// Paramètres de connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pddrcs";

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$email = $_POST['email'];

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Préparer la requête d'insertion
$sql = "INSERT INTO utilisateurs (nom, email) VALUES ('$nom', '$email')";

// Exécuter la requête
if ($conn->query($sql) === TRUE) {
    echo "Nouvel utilisateur ajouté avec succès<br>";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error . "<br>";
}

// Fermer la connexion
$conn->close();
?>
<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pddrcs";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire et valider
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);

    // Validation basique des données
    if (empty($nom) || empty($email)) {
        echo "Tous les champs doivent être remplis.";
        exit;
    }

    // Valider l'email avec une expression régulière
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'email fourni n'est pas valide.";
        exit;
    }

    // Créer une connexion sécurisée
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Préparer une requête SQL avec des paramètres liés pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email) VALUES (?, ?)");
    
    // Vérifier si la préparation a réussi
    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres à la requête préparée
    $stmt->bind_param("ss", $nom, $email); // "ss" signifie que les deux paramètres sont des chaînes de caractères

    // Exécuter la requête préparée
    if ($stmt->execute()) {
        echo "Nouvel utilisateur ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $stmt->error;
    }

    // Fermer la connexion et la requête préparée
    $stmt->close();
    $conn->close();
}
?>
