<?php 
require "functions.php";
require "Database.php";
$config = require ("config.php");
echo "<link rel='stylesheet' href='style.css'>";
echo"woaw<br>";

$db= new Database($config["database"]);

$comments = $db->query('SELECT * FROM comments')->fetchAll();
//$posts = $db->query('SELECT * FROM post');
//$user = $db->query('SELECT * FROM users WHERE user_id = $id');
//dabut bloga ierakstus
//Searchbar:
//
//Next shit is important casue i needed a search bar in the same file though it didnt work to make it here
// Search form
echo "<form method='GET' action=''>";
echo "<input type='text' name='search_query'/>"; 
echo "<button type='submit'>Search</button>";
echo "</form>";

$comments = $db->query('SELECT * FROM comments')->fetchAll(); // Original comments
$search_results = [];

if (isset($_GET["search_query"]) && $_GET["search_query"] != ""){
     //TODO 
//$comments = $db->query("SELECT * FROM comments WHERE content LIKE ". $_GET["search_query"]);
$search_query = htmlspecialchars($_GET["search_query"]);
$query = "SELECT * FROM comments WHERE content LIKE :search";
$stmt = $db->pdo->prepare($query);
$stmt->execute(['search' => '%' . $search_query . '%']);
$search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<ul>";
if (!empty($search_results)) {
    foreach ($search_results as $post) {
        // Sanitize output to prevent XSS vulnerabilities
        echo "<li><strong>ID:</strong> " . htmlspecialchars($post['ID']) . // **ADDED**
             "<br><strong>Content:</strong> " . htmlspecialchars($post['Content']) . "</li>"; // **ADDED**
    }
} else {
    echo "<li>No results found.</li>";
}
}

echo "<ul>";
foreach ($comments as $post) {
    echo " <li> ID: " . $post['ID'] . "<br> Content: " . $post['Content'] . "</li>";
}
dd($comments);
echo "</ul>";
//meklesanas forma
//ec
