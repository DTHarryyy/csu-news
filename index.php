<?php 
    session_start();
    include('./database/database.php');

    $query = "SELECT id, title, thumbnail_url, content, published_at FROM articles ORDER BY created_at DESC LIMIT 9 OFFSET 1";
    $result = $conn->query($query);

    $latestUpload = $conn->prepare("SELECT id, title, thumbnail_url, content, published_at FROM articles ORDER BY created_at DESC LIMIT 1;");
    $latestUpload->execute();
    $latestRes = $latestUpload->get_result();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>CSUNEWS </title>

        <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet"
        />
        <link rel="stylesheet" href="./assets/css/general.css">
        <link rel="stylesheet" href="./assets/css/heropage.css">
        <link rel="stylesheet" href="./assets/css/nav.css">
        <link rel="stylesheet" href="./assets/css/article_card.css">
        <style>
  </style>
</head>
<body>
    <?php include('./includes/nav.php');?>

    <main class="container">
        <?php if($latest = $latestRes->fetch_assoc()): ?>
            <section class="featured-article" aria-label="Featured article">
            <img src="<?= htmlspecialchars($latest['thumbnail_url'])?>" alt="image not supported" />
            <div class="featured-content">
                <h2><?= htmlspecialchars($latest['title']) ?></h2>
                <p><?= htmlspecialchars(substr(strip_tags($latest['content']), 0, 250)) ?>...</p>
                <a href="viewArticle.php?id=<?= urlencode($latest['id']) ?>" class="btn-read-more">Read More</a>
            </div>
        </section>
        <?php endif?>
        

        <section aria-label="Recent articles">
            <h2 style="margin-bottom: 1rem; color: #2c3e50;">Recent Articles</h2>
            <div class="articles-list">
                <?php while($row = $result->fetch_assoc()): ?>
                    <article class="article-card">
                    <img src="<?= htmlspecialchars($row['thumbnail_url'])?>" alt="image not supported" />
                    <div class="article-content">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><?= htmlspecialchars(substr(strip_tags($row['content']), 0, 100)) ?>...</p>
                        <a href="viewArticle.php?id=<?= urlencode($row['id']) ?>" class="btn-read-more" aria-label="Read more about How to Master JavaScript in 2024">Read More</a>
                    </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <?php include('./includes/footer.php')?>
  
</body>
</html>
<?php
    include('./backend/logout.php');

    
?>