<?php
include 'db.php';

// Fetch all careers
$careers = mysqli_query($conn, "SELECT * FROM careers ORDER BY created_at DESC");
$total = mysqli_num_rows($careers);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Careers - Nirmal</title>
    <link rel="shortcut icon" href="assets/images/logo/fav.png" type="image/x-icon">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link to AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Link to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Link to Swipper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css" />
    <!-- CSS Link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/career.css">
</head>

<body>

    <!-- Navbar Start -->
    <nav>
        <div class="nav-left">
            <div class="logo">
                <a href="index.html"><img src="assets/images/logo/logo.png" alt="Nirmal"></a>
            </div>
            <div class="line"></div>
            <div class="group-logo">
                <img src="assets/images/logo/group-logo.jpg" alt="Group Nirmal">
            </div>
            <div class="menu-btn">
                <button><img src="assets/images/svg/menu.svg" alt="icon"> MENU</button>
            </div>
        </div>
        <div class="nav-right">
            <div class="social-icons">
                <a href="https://www.facebook.com/groupnirmal?mibextid=ZbWKwL" target="_blank"><img src="assets/images/svg/facebook.svg" alt="facebook"></a>
                <a href="https://www.instagram.com/group.nirmal?igsh=MWFxZ3BqZzgzamhibg==" target="_blank"><img src="assets/images/svg/instagram.svg" alt="instagram"></a>
                <a href="https://www.linkedin.com/company/nirmal-wires-private-limited/" target="_blank"><img src="assets/images/svg/linkedin.svg" alt="linkedin"></a>
                <a href="https://youtube.com/@groupnirmal?si=vw5R2dLVZcAu8S32" target="_blank"><img src="assets/images/svg/youtube.svg" alt="youtube"></a>
                <a href="https://x.com/NirmalWires" target="_blank"><img src="assets/images/svg/twitter.svg" alt="twitter"></a>
                <a href="download.html"><img src="assets/images/svg/download.svg" alt="download"></a>
            </div>
            <a href="contact.html"><button>GET IN TOUCH</button></a>
        </div>
        <!-- Menu List -->
        <div class="nav-menu">
            <a href="index.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-01.png" alt="icon">
                <span>Home</span>
            </a>
            <a href="our-story.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-02.png" alt="icon">
                <span>Our Story</span>
            </a>
            <a href="products.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-03.png" alt="icon">
                <span>Products</span>
            </a>
            <a href="quality-assurance.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-04.png" alt="icon">
                <span>Quality Assurance</span>
            </a>
            <a href="trading.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-11.png" alt="icon">
                <span>Trading</span>
            </a>
            <a href=our-presence.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-06.png" alt="icon">
                <span>Our Presence</span>
            </a>
            <a href="csr.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-10.png" alt="icon">
                <span>CSR</span>
            </a>
            <a href="career.php" class="menu">
                <img src="assets/images/menu-icon/menu-icon-07.png" alt="icon">
                <span>Careers</span>
            </a>
            <a href="view-blog.php" class="menu">
                <img src="assets/images/menu-icon/blog.png" alt="icon">
                <span>Blog</span>
            </a>
            <a href="contact.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-08.png" alt="icon">
                <span>Contact Us</span>
            </a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Banner Start -->
    <section class="banner">
        <img src="assets/images/career_banner.png" alt="banner">
        <div class="banner-content">
            <h1 data-aos="fade-up" data-aos-duration="1000">CAREERS</h1>
        </div>
    </section> 
    <!-- Banner End -->
      <!-- Career Start -->
    <div class="jobs-container">
  <div class="jobs-title">Open - Positions (<?= $total ?>)</div>

  <div class="jobs-header">
    <div>Role</div>
    <div>Location</div>
    <div></div>
  </div>

  <?php while ($job = mysqli_fetch_assoc($careers)): ?>
    <div class="job-row">
      <div>
        <div class="job-role-title"><?= htmlspecialchars($job['designation']) ?></div>
      <div class="job-role-details">Experience – <?= htmlspecialchars($job['experience']) ?> years</div>
        <div class="job-posted">
          <?php
            $days = floor((time() - strtotime($job['created_at'])) / 86400);
            echo 'Posted ' . ($days == 0 ? 'today' : $days . ' day' . ($days > 1 ? 's' : '') . ' ago');
          ?>
        </div>
      </div>
      <div><?= htmlspecialchars($job['location']) ?></div>
      <div>
        <a href="view-career.php?id=<?= $job['id'] ?>">
          <button class="job-button">Get job insights</button>
        </a>
      </div>
    </div>
  <?php endwhile; ?>
</div>
 <!-- Career End -->
  <!-- Footer Start -->
    <footer class="px-md-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4 mb-md-0">
                    <img class="img-fluid" src="assets/images/footer-logo.png" alt="Nirmal" width="170">
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="footer-imnner">
                                <h5>COMPANY</h5>
                                <ul class="list-unstyled">
                                    <li><a href="our-story.html" class="text-decoration-none">Our Story</a></li>
                                    <li><a href="products.html" class="text-decoration-none">Products</a></li>
                                    <li><a href="our-presence.html" class="text-decoration-none">Our Presence</a></li>
                                    <li><a href="csr.html" class="text-decoration-none">CSR</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 mt-4 mt-sm-0">
                                <div class="footer-imnner" style="margin-bottom: 2.1rem;">
                                    <!-- <h5 class="text1"><a href="retail.html" class="text-decoration-none">RETAIL</a></h5> -->
                                </div>
                            <div>
                                <ul class="list-unstyled">
                                    <li><a href="trading.html" class="text-decoration-none">Trading</a></li>
                                    <li><a href="quality-assurance.html" class="text-decoration-none">Quality Assurance</a></li>
                                    <li><a href="view-blog.php" class="text-decoration-none">Our Blogs</a></li>
                                    <li><a href="coming-soon.html" class="text-decoration-none">Our Gallery</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-4 mt-md-0">
                            <div class="footer-imnner" style="width: 10rem; position: relative; right: 2rem;">
                                <h5>CONTACT US</h5>
                                <ul class="list-unstyled">
                                    <li><a href="contact.html" class="text-decoration-none">Corporate Office</a></li>
                                    <li><a href="contact.html" class="text-decoration-none">Manufacturing Units</a></li>
                                    <li><a href="career.php" class="text-decoration-none">Careers</a></li>
                                    <li><a href="our-presence.html" class="text-decoration-none">Media</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 d-none d-xl-block text-end" >
                    <h5 class="mb-3">Toll Free No. 1800 309 3876</h5>
                    <div class="social text-end position-relative d-none d-md-block mb-4">
                        <ul class="list-unstyled d-inline-flex mb-0">
                            <li>
                                <a href="https://www.facebook.com/groupnirmal?mibextid=ZbWKwL" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/facebook.svg" alt="Facebook" />
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/group.nirmal?igsh=MWFxZ3BqZzgzamhibg==" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/instagram.svg" alt="Instagram" />
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nirmal-wires-private-limited/" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/linkedin.svg" alt="Linkedin" />
                                </a>
                            </li>
                            <li>
                                <a href="https://youtube.com/@groupnirmal?si=vw5R2dLVZcAu8S32" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/youtube.svg" alt="Youtube" />
                                </a>
                            </li>
                            <li>
                                <a href="https://x.com/NirmalWires" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/twitter.svg" alt="Twitter" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <img class="img-fluid ms-auto" src="assets/images/50-years-2.png" width="75">
                </div>
            </div>
        </div>
    </footer> 
    <!-- Footer End -->
 <!-- WhatsApp Icon Start -->
    <section class="wp">
        <a href="https://wa.me/18003093876" target="_blank">
            <img src="assets/images/svg/whatsapp.svg" alt="WhatsApp">
        </a>
    </section> 
    <!-- WhatsApp Icon End -->


    <!-- -------------------------------------------------------------------------------------------------------------------------------- -->

    <!-- Bootstrap JS Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>

    <!-- Lenis Scroll Link -->
    <script src="https://unpkg.com/lenis@1.1.16/dist/lenis.min.js"></script>
    <script>
        const lenis = new Lenis({
            duration: 0.5, // Adjust the duration for smooth scrolling
            easing: (t) => t * (2 - t),
        });
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    </script>

    <!-- AOS Animation JS Link -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Apps Card Hover Functionality -->
    <script>
        let appsCard = document.querySelectorAll('.apps-card');
        let blueLayer = document.querySelectorAll('.blue-layer');
        appsCard.forEach((card, index) => {
            card.addEventListener('mouseenter', () => {
                blueLayer[index].style.bottom = '0';
            })
            card.addEventListener('mouseleave', () => {
                blueLayer[index].style.bottom = '-100%';
            })
        })
    </script>

    <!-- JS Link -->
    <script src="assets/js/script.js"></script>
<script>
  // Select all divs that directly contain a .job-button
  document.querySelectorAll('div > .job-button').forEach(button => {
    button.parentElement.addEventListener('click', () => {
      window.location.href = 'career2.html';
    });
  });
</script>

</body>

</html>
