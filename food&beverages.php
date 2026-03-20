<?php
include "includes/dbcon.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Local Food Product Development Monitoring System - All Products</title>
  <link href="assets/img/dti.png" rel="icon">
  <link href="assets/img/dti.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    .card-title, .card-text { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.3rem; height: 2.6rem; }
    .card-body { flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .product-price { color: green; }
    .product-card img { width: 100%; height: 200px; object-fit: cover; }
    .card-footer { margin-top: auto; }
    .card-footer a { width: 100%; text-align: center; }
  
  </style>
</head>

<body class="service-details-page">
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/dti.png" alt="">
        <h1 class="sitename" style="color: #1e04a1;">LFPDMS</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="index.php#about">About</a></li>
          <li><a href="index.php#contact">Contact</a></li>
          <li><a href="scanner.php">Scan QR <i style="font-size:20px;" class="fa-solid fa-expand"></i></a></li>
          <li><a href="login/login.php">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section mt-4">
      <div class="hero-bg">
        <img src="assets/img/bg12.png" alt="">
      </div>
    </section>

    <section id="service-details" class="service-details section">
      <div class="container">
        <div class="row gy-5">
          <div class="col-lg-12 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
            <div class="card p-4 shadow-lg">
              <h1 class="text-center font-weight-bold mb-4" style="font-size: 50px; color: #333;">LOCAL FOOD PRODUCTS</h1>
              <input type="text" id="searchQuery" class="form-control" placeholder="Search for Products / Address..." style="width: 100%;"> 

              <form id="searchForm" class="d-flex justify-content-center align-items-center mb-4">
                <button type="button" id="clearSearch" class="btn btn-secondary ml-2" style="display: none;">Clear</button>
                <div class="ml-2 mt-4">
                  <h1>All Products</h1>
                </div>
              </form>
              <div class="container my-4">
                <div class="row" id="productResults">
                  <?php
                    $products_per_page = 30;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $products_per_page;
                    $select_products = $conn->prepare("SELECT * FROM products INNER JOIN users ON users.userid = products.msme_id LIMIT :limit OFFSET :offset");
                    $select_products->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
                    $select_products->bindValue(':offset', $offset, PDO::PARAM_INT);
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

  echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">';
  echo '<a href="comment.php?id=' . htmlspecialchars($fetch_products['product_id']) . '" class="text-decoration-none">';
  echo '<div class="card product-card h-100 d-flex flex-column">';

  $img     = $fetch_products['productImage'] ?? '';
  $imgFile = __DIR__ . "/admin/uploaded_img/" . $img;

  $src = (!empty($img) && file_exists($imgFile))
    ? "admin/uploaded_img/" . rawurlencode($img)
    : "assets/img/no-image.png";

  echo '<img src="' . htmlspecialchars($src) . '" class="card-img-top product-img" alt="Product Image">';

  echo '<div class="card-body d-flex flex-column">';
  echo '<h5 class="card-title">' . htmlspecialchars($fetch_products['productName']) . '</h5>';
  echo '<p class="product-price">&#8369;' . htmlspecialchars($fetch_products['productPrice']) . '</p>';
  echo '<p class="card-text">' . htmlspecialchars($fetch_products['address']) . '</p>';
  echo '</div>';

  echo '<div class="card-footer mt-auto">';
  echo '<button class="btn btn-primary w-100" style="background:#71afe5;color:black; border-color:#71afe5;">View Details</button>';
  echo '</div>';

  echo '</div></a></div>';
}

                    } else {
                      echo '<div class="col-12"><div class="alert alert-warning text-center">No products found.</div></div>';
                    }
                    $total_products_query = $conn->query("SELECT COUNT(*) FROM products");
                    $total_products = $total_products_query->fetchColumn();
                    $total_pages = ceil($total_products / $products_per_page);
                  ?>
                </div>
                <div class="pagination mt-4 d-flex justify-content-center">
                  <nav>
                    <ul class="pagination">
                      <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a></li>
                      <?php endif; ?>
                      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                          <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                      <?php endfor; ?>
                      <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>">Next</a></li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer position-relative">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center">
            <span class="sitename">LFPDMS</span>
          </a>
          <div class="footer-contact pt-3">
            <p>DTI Building,</p>
            <p>Corner J.M. Basa and General M.</p>
            <p>Peralta Streets,</p>
            <p>Iloilo City Proper,</p>
            <p>Iloilo City, 5000 Iloilo</p>
            <p class="mt-3"><strong>Phone:</strong> <span>(033) 335-0548 / 335-1980</span></p>
            <p><strong>Email:</strong> <span> r06@dti.gov.ph</span></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
          <li><a href="index.php#about">About us</a></li>
          <li><a href="index.php#featured-services">Services</a></li>
          <li><a href="feedback.php">Feedback</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-4 footer-links">
          <h4>Follow Us</h4>
          <ul>
            <li><a href="https://x.com/DtiPhilippines"><i class="bi bi-twitter-x"></i> Twitter</a></li>
            <li><a href="https://www.facebook.com/DTI.Iloilo/"><i class="bi bi-facebook"></i> Facebook</a></li>
            <li><a href="https://www.instagram.com/dti.philippines/"><i class="bi bi-instagram"></i> Instagram</a></li>
            <li><a href="https://ph.linkedin.com/company/dtiphilippines"><i class="bi bi-linkedin"></i> LinkedIn</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container copyright text-center">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Local Food Product Development Monitoring System</strong><br><span style="font-weight: bold;">All Rights Reserved | LFPDMS</span></p>
    </div>
  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>

  <!-- Include jQuery Library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Real-Time Search Script -->
<script>
  $(document).ready(function () {
    let typingTimer;
    const delay = 250;

    function loadAllProducts() {
      location.reload(); 
      // simplest way since you already render all products via PHP
      // later we can make an AJAX "load all" if you want.
    }

    $('#searchQuery').on('input', function () {
      clearTimeout(typingTimer);

      const query = $(this).val().trim();

      typingTimer = setTimeout(function () {
        if (query.length > 0) {
          $.ajax({
            url: 'search.php',
            method: 'POST',
            data: { search_query: query },
            success: function (data) {
              // ✅ Replace the "All Products" grid instead
              $('#productResults').html(data);
            }
          });
        } else {
          // if empty, show all products again
          loadAllProducts();
        }
      }, delay);
    });

    // optional clear button
    $('#clearSearch').on('click', function () {
      $('#searchQuery').val('');
      loadAllProducts();
    });
  });
</script>

</body>
</html>
