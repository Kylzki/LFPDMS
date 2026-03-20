<?php
include "./includes/dbcon.php";
session_start();

if (!isset($_GET['Id']) || !isset($_GET['TransactionId'])) {
  die("Product ID or Transaction ID is not set in the URL.");
}

$product_id     = (int)$_GET['Id'];
$transaction_id = (string)$_GET['TransactionId'];

$success = isset($_GET['success']) && $_GET['success'] == 1;
$already = isset($_GET['already']) && $_GET['already'] == 1;

// ✅ Block review per (transaction_id + product_id) even for anonymous (no new column)
$checkFeedbackStmt = $conn->prepare("
  SELECT COUNT(*)
  FROM feedback f
  WHERE f.product_id = :product_id
    AND f.comment LIKE :tx
");
$checkFeedbackStmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
$checkFeedbackStmt->bindValue(':tx', "%TransactionId={$transaction_id}%", PDO::PARAM_STR);
$checkFeedbackStmt->execute();
$alreadyCommented = (int)$checkFeedbackStmt->fetchColumn();

// ✅ Get product + seller info
try {
  $query = "
    SELECT *
    FROM products
    INNER JOIN users ON users.userid = products.msme_id
    WHERE products.product_id = :id
  ";
  $statement = $conn->prepare($query);
  $statement->bindValue(':id', $product_id, PDO::PARAM_INT);
  $statement->execute();
  $Data = $statement->fetch(PDO::FETCH_ASSOC);

  if (!$Data) {
    die("No product found for ID: " . htmlspecialchars((string)$product_id));
  }
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}

// ✅ Fetch comments
function getCommentsForProduct($id)
{
  global $conn;
  try {
    $stmt = $conn->prepare("SELECT * FROM feedback WHERE product_id = ? ORDER BY datesubmitted DESC");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    return [];
  }
}

$comments = getCommentsForProduct($product_id);

// ✅ Logged user id optional
$sessionUserId = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Local Food Product Management System - Feedback</title>

  <link href="assets/img/dti.png" rel="icon">
  <link href="assets/img/dti.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .highlight-comment{
      border: 2px solid #22c55e;
      background: #ecfdf5;
      padding: 12px;
      border-radius: 10px;
      animation: pop 0.4s ease;
    }
    @keyframes pop{
      from { transform: scale(0.98); opacity: 0.7; }
      to   { transform: scale(1); opacity: 1; }
    }

    .tag-btn {
      display: inline-block;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 8px 12px;
      margin: 5px;
      font-size: 14px;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .tag-btn:hover { background-color: #0056b3; }
    .tag-btn:active { transform: scale(0.95); }

    #tag-container {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background: #f8f9fa;
    }
  </style>
</head>

<body class="service-details-page">
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/dti.png" alt="">
      <h1 class="sitename" style="color: #1e04a1;">LFPMS</h1>
    </a>
    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="index.php#hero">Home</a></li>
        <li><a href="index.php#about">About</a></li>
        <li><a href="index.php#contact">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
  </div>
</header>

<main class="main" style="margin-top:100px;">
  <div class="container my-5">
    <div class="row shadow-sm border rounded">

      <div class="row">
        <div class="col-md-4 w3-white p-4 text-start">
          <img
            style="height:250px !important; display:block; margin:0 auto;"
            class="img-fluid rounded"
            src="admin/uploaded_img/<?php echo htmlspecialchars($Data['productImage']); ?>"
            alt="Product Image"
          >
        </div>

        <div class="col-md-8 mt-4">
          <a style="float:right;" href="ScanResult.php?Id=<?php echo urlencode($transaction_id); ?>">Back</a>
          <h2 class="fw-bold"><?php echo htmlspecialchars($Data['productName']); ?></h2>
          <h3 class="text-success">&#8369;<?php echo htmlspecialchars($Data['productPrice']); ?></h3>
          <div class="mt-3"><strong>Seller:</strong> <?php echo htmlspecialchars($Data['fname'] . ' ' . $Data['Lname']); ?></div>
          <div><strong>Address:</strong> <?php echo htmlspecialchars($Data['address']); ?></div>
          <div><strong>Product Detail:</strong> <?php echo htmlspecialchars($Data['productDetails']); ?></div>
        </div>
      </div>

      <div class="col-md-12 p-4 w3-white">
        <h4 class="text-left">Leave a Comment / Feedback about the Product</h4>

        <?php if ($already): ?>
          <div class="alert alert-warning">
            You already submitted feedback for this product (this receipt).
          </div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="alert alert-success text-center" id="redirectNotice">
            ✅ Feedback submitted! Returning to transaction in <b id="countdown">3</b> seconds...
          </div>
        <?php endif; ?>

        <div class="comment-box">
          <form action="insert_comment.php" method="post">
            <label for="name">Name (Optional)</label>
            <input type="text" name="name" id="name" class="form-control mb-2" value="">

            <label for="mail">Email (Optional)</label>
            <input type="text" name="mail" id="mail" class="form-control mb-3" value="">

            <hr>

            <input type="hidden" name="product_id" value="<?php echo (int)$Data['product_id']; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo htmlspecialchars($transaction_id); ?>">
            <input type="hidden" name="msme" value="<?php echo htmlspecialchars($Data['fname'] . ' ' . $Data['Lname']); ?>">
            <input type="hidden" name="productName" value="<?php echo htmlspecialchars($Data['productName']); ?>">
            <input type="hidden" name="userid" value="<?php echo (int)$sessionUserId; ?>">

            <div id="tag-container" class="mb-2"><b>Tag:<br></b></div>

            <textarea name="comment" id="comment-textarea" class="form-control" placeholder="Write your comment" required></textarea>

            <div class="text-end mt-3">
              <?php if ($alreadyCommented > 0): ?>
                <button type="submit" class="btn btn-primary" disabled>Submit</button>
                <p class="text-danger mt-2 mb-0">You have already submitted feedback for this product (this receipt).</p>
              <?php else: ?>
                <button type="submit" class="btn btn-primary">Submit</button>
              <?php endif; ?>
            </div>
          </form>
        </div>

        <script>
          function addTag(tagName) {
            const commentTextarea = document.getElementById("comment-textarea");
            commentTextarea.value += tagName + " ";
          }

          document.addEventListener("click", function(event) {
            if (event.target.classList.contains("tag-btn")) {
              addTag(event.target.textContent);
            }
          });

          function createTagButton(tagName) {
            const tagContainer = document.getElementById("tag-container");
            const tagButton = document.createElement("button");
            tagButton.textContent = tagName;
            tagButton.classList.add("tag-btn");
            tagButton.type = "button";
            tagContainer.appendChild(tagButton);
          }

          ["Design","Taste","Quality","Label","Package","Branding","Logo","Flavor"].forEach(createTagButton);
        </script>

        <hr class="my-4">

        <?php if (!empty($comments)): ?>
          <h5><b>Comments</b></h5>
          <div class="comments-container w3-border-top"><br>

            <?php foreach ($comments as $i => $comment): ?>
              <?php
                $fullName = '';
                if (!empty($comment['userid'])) {
                  try {
                    $stmt = $conn->prepare("SELECT fname, Lname FROM users WHERE userid = ?");
                    $stmt->execute([(int)$comment['userid']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $fullName = $user ? $user['fname'] . ' ' . $user['Lname'] : '';
                  } catch (PDOException $e) {}
                }
                $displayName = $fullName ?: ($comment['name'] ?: 'Unknown User');
              ?>

              <div class="comment <?php echo ($success && $i === 0) ? 'highlight-comment' : ''; ?>">
                <div class="text"><b><?php echo htmlspecialchars($displayName); ?></b></div>
                <div class="text">Date Submitted: <?php echo htmlspecialchars($comment['datesubmitted']); ?></div>
                <div class="text">Feedback: <?php echo htmlspecialchars($comment['comment']); ?></div>
              </div>
              <hr>
            <?php endforeach; ?>

          </div>
        <?php else: ?>
          <p>No comments found for this product.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</main>

<footer id="footer" class="footer position-relative">
  <div class="container copyright text-center">
    <p>© <span>Copyright</span>
      <strong class="px-1 sitename">Local Food Product Management System</strong><br>
      <span style="font-weight: bold;">All Rights Reserved | LFPMS</span>
    </p>
  </div>
</footer>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<?php if ($success): ?>
<script>
  let s = 3;
  const cd = document.getElementById("countdown");
  const backUrl = "ScanResult.php?Id=<?php echo urlencode($transaction_id); ?>";

  const timer = setInterval(() => {
    s--;
    if (cd) cd.textContent = s;
    if (s <= 0) {
      clearInterval(timer);
      window.location.href = backUrl;
    }
  }, 1000);
</script>
<?php endif; ?>

</body>
</html>
