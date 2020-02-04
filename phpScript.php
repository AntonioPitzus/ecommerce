<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vendita_orologi";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$value = $_POST["id"];

$sql = "SELECT * FROM orologio WHERE id = $value";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

echo "<p id='qMarca' hidden>".$row["marca"]."</p><p id='qModello' hidden>".$row["modello"]."</p><p id='qSrc' hidden>"
      .$row["immagine"]."</p><p id='qDesc' hidden>".$row["descrizione"]."</p><p id='qPrezzo' hidden>".$row["prezzo"]."</p>";

mysqli_close($conn);

?>
