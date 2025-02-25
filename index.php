<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smartphone Store</title>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f5f5f5;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }


    /* Home Section */
    .home__content {
      padding: 9rem 0 2rem;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 4rem;
      align-items: center;
    }

    .home__group {
      position: relative;
      padding-top: 2rem;
    }

    .home__img {
      width: 100%;
      height: 420px;
      object-fit: contain;
      border-radius: 1rem;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .home__img:hover {
      transform: translateY(-5px);
    }

    .home__data {
      position: relative;
    }

    .home__subtitle {
      font-size: 1.2rem;
      color: #2563eb;
      margin-bottom: 1rem;
    }

    .home__title {
      font-size: 3rem;
      color: #2a2a2a;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .home__description {
      color: #666;
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    .cta-button {
      display: inline-block;
      padding: 1rem 2rem;
      background: #2563eb;
      color: #fff;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
      box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
    }

    .cta-button:hover {
      background: #1d4ed8;
      transform: translateY(-2px);
    }

    /* Swiper Customization */
    .swiper-pagination-bullet {
      background: #fff !important;
      opacity: 0.5 !important;
    }

    .swiper-pagination-bullet-active {
      background: #2563eb !important;
      opacity: 1 !important;
    }

    @media (max-width: 768px) {
      .home__content {
        grid-template-columns: 1fr;
        padding: 7rem 0 2rem;
        text-align: center;
      }

      .home__title {
        font-size: 2rem;
      }

      .nav__list {
        display: none;
      }
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <main class=" container">
    <div class="swiper home-swiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <section class="swiper-slide">
          <div class="home__content grid">
            <div class="home__group">
              <img src="image/home.jpg" alt="Smartphone" class="home__img">
            </div>
            <div class="home__data">
              <h4 class="home__subtitle">PREMIUM SMARTPHONES</h4>
              <h3 class="home__title">Experience Next-Level Technology</h3>
              <p class="home__description">
                Discover our curated collection of cutting-edge smartphones with
                revolutionary features and unbeatable performance.
              </p>
              <a href="samsung.php" class="cta-button">Shop Now</a>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>


  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
  <script src="js/JavaScript.js"></script>

</body>

</html>