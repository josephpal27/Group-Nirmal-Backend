<?php
include 'db.php';

if (isset($_GET['title'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['title']);
    $jobQuery = "SELECT * FROM careers WHERE slug = '$slug' LIMIT 1";
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    // Optional: Redirect from ?id=... to ?title=...
    $res = mysqli_query($conn, "SELECT slug FROM careers WHERE id = $id LIMIT 1");
    $row = mysqli_fetch_assoc($res);
    if ($row && !empty($row['slug'])) {
        header("Location: view-career.php?title=" . urlencode($row['slug']));
        exit();
    } else {
        echo "<h3>Career not found.</h3>";
        exit();
    }
} else {
    echo "<h3>Invalid or missing career identifier.</h3>";
    exit();
}

$jobResult = mysqli_query($conn, $jobQuery);

if (!$jobResult || mysqli_num_rows($jobResult) === 0) {
    echo "<h3>Career not found.</h3>";
    exit();
}

$job = mysqli_fetch_assoc($jobResult);

// Fetch other jobs
$jobId = (int)$job['id'];
$otherJobsQuery = "SELECT * FROM careers WHERE id != $jobId ORDER BY created_at DESC LIMIT 4";
$otherJobsResult = mysqli_query($conn, $otherJobsQuery);
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
    <link rel="stylesheet" href="assets/css/career2.css">
</head>

<body>

    <!-- Navbar Start -->
    <nav>
        <div class="nav-left">
            <div class="logo">
                <a href="index.html"><img src="assets/images/logo/logo.png" alt="Nirmal" loading="lazy"></a>
            </div>
            <div class="line"></div>
            <div class="group-logo">
                <img src="assets/images/logo/group-logo.jpg" alt="Group Nirmal" loading="lazy">
            </div>
            <div class="menu-btn">
                <button><img src="assets/images/svg/menu.svg" alt="icon" loading="lazy"> MENU</button>
            </div>
        </div>
        <div class="nav-right">
            <div class="social-icons">
                <a href="https://www.facebook.com/groupnirmal?mibextid=ZbWKwL" target="_blank"><img src="assets/images/svg/facebook.svg" alt="facebook" loading="lazy"></a>
                <a href="https://www.instagram.com/group.nirmal?igsh=MWFxZ3BqZzgzamhibg==" target="_blank"><img src="assets/images/svg/instagram.svg" alt="instagram" loading="lazy"></a>
                <a href="https://www.linkedin.com/company/nirmal-wires-private-limited/" target="_blank"><img src="assets/images/svg/linkedin.svg" alt="linkedin" loading="lazy"></a>
                <a href="https://youtube.com/@groupnirmal?si=vw5R2dLVZcAu8S32" target="_blank"><img src="assets/images/svg/youtube.svg" alt="youtube" loading="lazy"></a>
                <a href="https://x.com/NirmalWires" target="_blank"><img src="assets/images/svg/twitter.svg" alt="twitter" loading="lazy"></a>
                <a href="download.html"><img src="assets/images/svg/download.svg" alt="download" loading="lazy"></a>
            </div>
        </div>
        <!-- Menu List -->
        <div class="nav-menu">
            <a href="index.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-01.png" alt="icon" loading="lazy">
                <span>Home</span>
            </a>
            <a href="our-story.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-02.png" alt="icon" loading="lazy">
                <span>Our Story</span>
            </a>
            <a href="products.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-03.png" alt="icon" loading="lazy">
                <span>Products</span>
            </a>
            <a href="quality-assurance.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-04.png" alt="icon" loading="lazy">
                <span>Quality Assurance</span>
            </a>
            <a href="trading.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-11.png" alt="icon" loading="lazy">
                <span>Trading</span>
            </a>
            <a href="our-presence.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-06.png" alt="icon" loading="lazy">
                <span>Our Presence</span>
            </a>
            <a href="csr.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-10.png" alt="icon" loading="lazy">
                <span>CSR</span>
            </a>
            <a href="career.php" class="menu">
                <img src="assets/images/menu-icon/menu-icon-07.png" alt="icon" loading="lazy">
                <span>Careers</span>
            </a>
            <a href="view-blog.php" class="menu">
                <img src="assets/images/menu-icon/blog.png" alt="icon" loading="lazy">
                <span>Blog</span>
            </a>
            <a href="contact.html" class="menu">
                <img src="assets/images/menu-icon/menu-icon-08.png" alt="icon" loading="lazy">
                <span>Contact Us</span>
            </a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Banner Start -->
    <section class="banner">
        <img src="assets/images/career-banner.webp" alt="banner" loading="lazy">
        <div class="banner-content">
            <h1 data-aos="fade-up" data-aos-duration="1000">CAREERS</h1>
        </div>
    </section>
    <!-- Banner End -->
    <!-- Career Start -->
    <!-- Main Section -->
    <div class="job-page-container">
        <a href="careers.php" class="back-link">← Back to Other Positions</a>

        <div class="job-main-section">
            <!-- Job Description -->
            <div class="job-description-card">
                <div class="job-tags">
                    <div class="job-tags-left">
                        <span>Full Time</span>
                        <span>On Site</span>
                    </div>
                    <span class="job-tags-right">Posted on <?= date('M Y', strtotime($job['created_at'])) ?></span>
                </div>

                <h2 class="job-title"><?= htmlspecialchars($job['designation']) ?></h2>
                <div class="job-subtitle"><?= $job['job_description'] ?></div>

                <hr class="divider">

                <h4 class="job-section-title">Roles & Responsibilities</h4>
                <div class="job-body"><?= $job['roles_responsibilities'] ?></div>

                <h4 class="job-section-title">Qualifications & Skills</h4>
                <div class="job-body"><?= $job['qualifications_skills'] ?></div>

                <h4 class="job-section-title">Experience</h4>
                <p class="job-body"><?= htmlspecialchars($job['experience']) ?> years</p>

                <h4 class="job-section-title">Location</h4>
                <p class="job-body"><?= htmlspecialchars($job['location']) ?></p>


            </div>


            <!-- Apply Card -->
            <div class="apply-card">
                <div class="apply-icon">
                    <img src="./assets/images/16249207.png" alt="Apply Icon" loading="lazy" />
                </div>
                <div class="apply-text">
                    <h3>Apply for this job</h3>
                    <p>Submit your application and resume now.</p>
                    <button class="apply-btn" onclick="openForm(<?= $job['id'] ?>)">Apply Now</button>
                </div>
            </div>


            <!-- Popup Overlay -->
            <div id="popupOverlay" class="popup-overlay"></div>

            <!-- Popup Form -->
            <div class="popup-form" id="popupForm" tabindex="0">
                <span class="close-btn" onclick="closeForm()" aria-label="Close popup">&times;</span>
                <h2>Job Application Form</h2>
                <form enctype="multipart/form-data" method="POST" action="submit-application.php">
                    <input type="hidden" name="career_id" value="<?= $job['id'] ?>">
                    <div class="form-row">
                        <label>First Name *<input type="text" name="first_name" required /></label>
                        <label>Last Name *<input type="text" name="last_name" required /></label>
                    </div>
                    <div class="form-row">
                        <label>Phone Number *<input type="tel" name="phone" required /></label>
                        <label>Current Organization *<input type="text" name="organization" required /></label>
                    </div>
                    <div class="form-row">
                        <label>Current Industry *<input type="text" name="industry" required /></label>
                        <label>Experience *<input type="text" name="experience" required /></label>
                    </div>
                    <div class="form-row">
                        <label>Current CTC *<input type="text" name="current_ctc" required /></label>
                        <label>Expected CTC *<input type="text" name="expected_ctc" required /></label>
                    </div>
                    <div class="form-row">
                        <label>Notice Period *<input type="text" name="notice_period" required /></label>
                        <label>Upload Resume *<input type="file" name="resume" accept=".pdf" required /></label>
                    </div>
                    <button type="submit" class="submit-btn">Upload</button>
                </form>
            </div>
        </div>

        <!-- Other Jobs -->
        <h3 class="section-heading">Other Positions</h3>
        <div class="other-positions">
            <?php
            include 'db.php';

            // Fetch exactly 2 jobs from the database
            $query = "SELECT id, designation, job_description FROM careers ORDER BY created_at DESC LIMIT 2";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)):
            ?>
                <div class="job-card">
                    <h4><?= htmlspecialchars($row['designation']) ?></h4>
                    <p><?= htmlspecialchars(mb_strimwidth($row['job_description'], 0, 100, '...')) ?></p>

                    <div class="job-divider"></div>

                    <div class="job-meta-apply">
                        <div class="job-meta">
                            <span>Full Time</span> | <span>On Site</span>
                        </div>
                        <a href="view-career.php?id=<?= $row['id'] ?>" class="text-link">Apply now</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="browse-all">
            <a href="career.php"><button class="browse-btn">Browse all Job Positions</button></a>
        </div>
    </div>

    <!-- Footer Start -->
    <footer class="px-md-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4 mb-md-0">
                    <img class="img-fluid" src="assets/images/footer-logo.png" alt="Nirmal" width="170" loading="lazy">
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
                                    <li><a href="our-presence.html" class="text-decoration-none">Our Gallery</a></li>
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
                <div class="col-xl-3 d-none d-xl-block text-end">
                    <h5 class="mb-3">Toll Free No. 1800 309 3876</h5>
                    <div class="social text-end position-relative d-none d-md-block mb-4">
                        <ul class="list-unstyled d-inline-flex mb-0">
                            <li>
                                <a href="https://www.facebook.com/groupnirmal?mibextid=ZbWKwL" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/facebook.svg" alt="Facebook" loading="lazy" />
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/group.nirmal?igsh=MWFxZ3BqZzgzamhibg==" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/instagram.svg" alt="Instagram" loading="lazy" />
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nirmal-wires-private-limited/" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/linkedin.svg" alt="Linkedin" loading="lazy" />
                                </a>
                            </li>
                            <li>
                                <a href="https://youtube.com/@groupnirmal?si=vw5R2dLVZcAu8S32" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/youtube.svg" alt="Youtube" loading="lazy" />
                                </a>
                            </li>
                            <li>
                                <a href="https://x.com/NirmalWires" target="_blank">
                                    <img class="img-fluid" src="assets/images/svg/twitter.svg" alt="Twitter" loading="lazy" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <img class="img-fluid ms-auto" src="assets/images/50-years-2.png" width="75" loading="lazy">
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->
    <!-- WhatsApp Icon Start -->
    <section class="wp">
        <a href="https://wa.me/18003093876" target="_blank">
            <img src="assets/images/svg/whatsapp.svg" alt="WhatsApp" loading="lazy">
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
    <!-- JS for popup -->
    <script>
        const popupForm = document.getElementById('popupForm');
        const popupOverlay = document.getElementById('popupOverlay');
        let scrollPosition = 0;

        function openForm() {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            popupForm.style.display = 'block';
            popupOverlay.style.display = 'block';
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollPosition}px`;
            popupForm.focus();
        }

        function closeForm() {
            popupForm.style.display = 'none';
            popupOverlay.style.display = 'none';
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollPosition);
        }

        popupOverlay.addEventListener('click', closeForm);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && popupForm.style.display === 'block') {
                closeForm();
            }
        });

        function openForm(jobId) {
            document.getElementById("popupOverlay").style.display = "block";
            document.getElementById("popupForm").style.display = "block";
            document.getElementById("careerIdInput").value = jobId;
        }

        function closeForm() {
            document.getElementById("popupOverlay").style.display = "none";
            document.getElementById("popupForm").style.display = "none";
        }
    </script>

</body>

</html>