<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']);

    $query = "SELECT id, title, thumbnail_url, content, published_at FROM articles WHERE id = $article_id LIMIT 1";
    $result = $conn->query($query);

    if ($result && $article = $result->fetch_assoc()) {
        
    } else {
        $article = null;
    }
} else {
    $article = null;
}
?>''