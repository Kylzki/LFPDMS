<?php
include "includes/dbcon.php";

$q = trim($_POST['search_query'] ?? '');

$stmt = $conn->prepare("
  SELECT * FROM products 
  INNER JOIN users ON users.userid = products.msme_id
  WHERE productName LIKE :q OR address LIKE :q
  LIMIT 30
");
$stmt->execute([':q' => "%$q%"]);

if ($stmt->rowCount() > 0) {
  while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $img = $p['productImage'] ?? '';
    $imgFile = __DIR__ . "/admin/uploaded_img/" . $img;

    $src = (!empty($img) && file_exists($imgFile))
      ? "admin/uploaded_img/" . rawurlencode($img)
      : "assets/img/no-image.png";

    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">';
    echo '<a href="comment.php?id=' . htmlspecialchars($p['product_id']) . '" class="text-decoration-none">';
    echo '<div class="card product-card h-100 d-flex flex-column">';
    echo '<img src="' . htmlspecialchars($src) . '" class="card-img-top product-img" alt="Product Image">';
    echo '<div class="card-body d-flex flex-column">';
    echo '<h5 class="card-title">' . htmlspecialchars($p['productName']) . '</h5>';
    echo '<p class="product-price">&#8369;' . htmlspecialchars($p['productPrice']) . '</p>';
    echo '<p class="card-text">' . htmlspecialchars($p['address']) . '</p>';
    echo '</div>';
    echo '<div class="card-footer mt-auto">';
    echo '<button class="btn btn-primary w-100" style="background:#71afe5;color:black; border-color:#71afe5;">View Details</button>';
    echo '</div>';
    echo '</div></a></div>';
  }
} else {
  echo '<div class="col-12"><div class="alert alert-warning text-center">No results found.</div></div>';
}
