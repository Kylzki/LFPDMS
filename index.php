<!DOCTYPE php>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Local Food Product Development Monitoring System - Landing Page</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/dti.png" rel="icon">
  <link href="assets/img/dti.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/dti.png" alt="">
        <h1 class="sitename" style="color: #1e04a1;">LFPDMS</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#lfpms" class="">Home</a></li>
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

    <!-- Hero Section -->
    <section id="lfpms" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/bg12.png" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center mt-4">
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="food&beverages.php" class="btn-get-started">Get Started</a>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Promoting Local Food Quality & Safety</a></h4>
                <p class="description">Our mission is to enhance the quality and safety standards of locally produced food items across different municipalities in the Province of Iloilo.</p>
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Utilizing NLP</a></h4>
                <p class="description">Our system uses NLP algorithms to process consumer reviews, social media posts, and other textual data. This enables us to gain insights into consumer preferences, identify emerging trends, and address any quality issues promptly.</p>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Empowering MSME's</a></h4>
                <p class="description">We empower Micro, Small, and Medium Enterprises (MSMEs) by providing them with user-friendly tools. These tools allow MSMEs to understand consumer needs effectively, make informed decisions, and respond proactively to market demands.</p>
              </div>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p class="who-we-are" style="font-size: 35px;">About</p>
            <h3 style="text-align: justify;">"Empowering MSMEs in Iloilo with innovative technology. Our platform offers a seamless solution to secure the quality and safety standards of locally produced food items across different municipalities in the Province of Iloilo.</h3>
            <p class="fst-italic">
              The Local Food Product Development Monitoring System aims to enhance the quality and safety standards of locally produced food items across different municipalities in the Province of Iloilo. By leveraging Natural Language Processing (NLP), we analyze consumer feedback to improve product development and ensure compliance with industry standards.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Utilizing NLP</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Empowering MSMEs</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Deliver the Ultimate Food Product Experience</span></li>
            </ul>
            
          </div>

          <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-lg-6">
                <img src="assets/img/About/2.png" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <img src="assets/img/About/3.png" class="img-fluid" alt="">
              </div>
              
              <div class="col-lg-12 mx-auto">
                <div class="row gy-4">
                  <div class="col-lg-6">
                    <img src="assets/img/About/4.png" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-6">
                    <img src="assets/img/About/5.png" class="img-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section><!-- /About Section -->


    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>What is Local Food Product Development Monitoring System (LFPDMS) ?</h3>
                <div class="faq-content">
                  <p>This system is a digital platform designed to help monitor, evaluate, and improve local food products. It collects customer feedback and uses sentiment analysis to determine how consumers feel about a product, helping businesses make data-driven decisions.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How does LFPDMS work?</h3>
                <div class="faq-content">
                  <p>The system gathers customer comments or reviews about a local food product. These feedback entries are processed using a rule-based sentiment analysis algorithm to classify sentiments as positive, negative, or neutral. The system then provides insights that assist in product development and enhancement.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How is LFPDMS different from traditional product assessment and development methods?</h3>
                <div class="faq-content">
                  <p>Unlike the manual, step-by-step process of meetings, forms, prototypes, and multiple assessments, LFPDMS automates the collection and evaluation of customer feedback using rule-based sentiment analysis, providing faster, data-driven insights for product improvement and reducing reliance on time-consuming in-person assessments.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How will this system benefit DTI and MSMEs? </h3>
                <div class="faq-content">
                  <p>The system will enhance DTI’s ability to monitor MSME products, reduce manual work, and generate real-time insights through sentiment analysis. For MSMEs, it provides a structured process for improvement and collaboration, leading to better-designed, market-ready products. </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How does LFPDMS support business opportunities?</h3>
                <div class="faq-content">
                  <p>The LFPDMS supports business opportunities by providing actionable insights derived from customer feedback. By analyzing sentiments on local food products, the system helps businesses identify strengths and weaknesses in their offerings, uncover emerging trends, and understand consumer preferences. This information enables product developers and entrepreneurs to make informed decisions, tailor products to market demands, and improve customer satisfaction. </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->
  

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Drop us a message via our contact form, shoot us an email, or give us a call. We're here and ready to assist you.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              <p>2F DTI Building Arsenal Aduana Sts., Iloilo City, Philippines</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>(033) 335-0548 / 335-1980</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>r06@dti.gov.ph</p>
            </div>
          </div><!-- End Info Item -->

        </div>

        <div class="row gy-4 mt-1">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3920.530788490082!2d122.56971737504071!3d10.693481589450359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aee57b2079704f%3A0x8347d832661aee4c!2sDepartment%20of%20Trade%20and%20Industry%20-%20Iloilo%20Provincial%20Office!5e0!3m2!1sen!2sph!4v1766414181328!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div><!-- End Google Maps -->

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer position-relative">
    <div class="container footer-top">
      <div class="row">
        <div class="col-lg-4 col-md-4 footer-about">
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

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>