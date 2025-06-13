<header>
    <h1>CSUNEWS</h1>
    <nav>
        <a href="./index.php">Home</a>
        <a href="
            <?php if(isset($_SESSION['id'])): ?>
                ./articles.php
            <?php else: ?>
                ./login.php 
            <?php endif;?>
        ">Articles</a>
        <a href="#">About</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'):?>
            <a href="./managearticle.php">Manage Articles</a>
            <a href="./addArticleForm.php">Add Article</a>
        <?php endif;?>
        <?php if(isset($_SESSION['id'])): ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <button id="logOutBtn" type="submit" name="logout">logout</button>
            </form>
        <?php endif;?>
    </nav>
</header>
<?php 
    include('./backend/logout.php')
?>