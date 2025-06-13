<?php 
    session_start();
    include('./database/database.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $delete_id = intval($_POST['delete_id']);
        $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $query = "SELECT id, title, thumbnail_url, content, published_at FROM articles ORDER BY created_at DESC";
    $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CSUNEWS</title>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/general.css">
    <link rel="stylesheet" href="./assets/css/heropage.css">
    <link rel="stylesheet" href="./assets/css/nav.css">
    <link rel="stylesheet" href="./assets/css/article_card.css">
</head>
<body>
    <?php include('./includes/nav.php'); ?>

    <main class="container">
        <section aria-label="Recent articles">
            <h2 style="margin-bottom: 1rem; color: #2c3e50;">Manage Articles</h2>
            <div class="articles-list">
                <?php while($row = $result->fetch_assoc()): ?>
                    <article class="article-card">
                        <img src="<?= htmlspecialchars($row['thumbnail_url']) ?>" alt="image not supported" />
                        <div class="article-content">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p><?= htmlspecialchars(substr(strip_tags($row['content']), 0, 100)) ?>...</p>
                            <div style="display: flex; gap:10px; align-items:center;">
                                <a href="viewArticle.php?id=<?= urlencode($row['id']) ?>" class="btn-read-more" aria-label="Read more">Read More</a>
                                <form method="POST" class="btn-read-more" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <?php include('./includes/footer.php') ?>
</body>
</html>
