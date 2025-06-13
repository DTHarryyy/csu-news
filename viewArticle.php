<?php
session_start();
include ('./database/database.php');
if(isset($_GET['id'])) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./assets/css/general.css">
    <link rel="stylesheet" href="./assets/css/nav.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/viewArticles.css">
    <title><?= $article ? htmlspecialchars($article['title']) . " - CSUNEWS" : "Article Not Found - CSUNEWS" ?></title>
</head>
<body>
<?php include('./includes/nav.php')?>

<main class="mainViewArticle">
    <?php if ($article): ?>
        <article aria-label="News article">
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <div class="article-meta">
                Published on <?= date("F j, Y", strtotime($article['published_at'])) ?>
            </div>
            <img
                src="<?= htmlspecialchars($article['thumbnail_url']) ?>"
                alt="<?= htmlspecialchars($article['title']) ?>"
                class="hero-image"
            />
            <div class="article-content">
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            </div>
        </article>
    <?php else: ?>
        <p>Sorry, the article you are looking for was not found.</p>
    <?php endif; ?>
</main>

<?php include('./includes/footer.php')?>
</body>
</html>
