<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/articleForm.css">
    <link rel="stylesheet" href="./assets/css/general.css">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <title>Document</title>
</head>
<body class="displayAllCenter addFormCon" style="height: 100vh;">
    <a href="./index.php">
      <i class="ri-arrow-left-line"></i>
    </a>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data" class="form-container">
      <h2>Add New Article</h2>

      <label for="title">Title</label>
      <input type="text" id="title" name="title" required>

      <label for="category">Category</label>
      <select id="category" name="category_id">
        <option value="">-- Select Category --</option>
        <option value="1">World</option>
        <option value="2">Tech</option>
        <option value="3">Sports</option>
      </select>

      <label for="content">Content</label>
      <textarea id="content" name="content" rows="8" required></textarea>

      <label for="thumbnail">Thumbnail Image</label>
      <input type="file" id="thumbnail" name="thumbnail">

    
    <button type="submit">Submit Article</button>
  </form>

</body>
</html>


<?php
  session_start();
  include('./database/database.php');

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
    $content = $_POST['content'];
    $thumbnail_url = null;
    $user_id = $_SESSION['id'];
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = basename($_FILES['thumbnail']['name']);
        $targetPath = $uploadDir . time() . '_' . $filename;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath);
        $thumbnail_url = $targetPath;
    }

    $stmt = $conn->prepare("INSERT INTO articles 
        (user_id, category_id, title, content, thumbnail_url) 
        VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "iisss",
        $user_id,
        $category_id,
        $title,
        $content,
        $thumbnail_url
    );
    if ($stmt->execute()) {
      echo "<script>alert('Article added successf ully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('failed to add article');</script>";
    }

    $stmt->close();
  }
?>
