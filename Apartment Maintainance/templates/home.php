<html>
  <head>
    <title>Home</title>

    <link rel="stylesheet" href="../styling/globals.css" />
    <meta name="viewport" content="width=device-width" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <style>
      body {
        display: flex;

        justify-content: center;
        font-family: "Dancing Script", cursive;
        font-family: "Open Sans", sans-serif;
        font-family: "Source Sans Pro", sans-serif;
      }
      a {
        text-decoration: none;
        font-size: 1.2rem;
      }
      .main {
        line-height: normal;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="main">
      <?php 
        session_start();

        echo $_SESSION['user'];
      ?>

      <h2>Apartment Name</h2>
      <a href="./posts.php">Posts</a><br />
      <a href="../php/PaytmKit/TxnTest.php">Pay Maintenance</a><br />
      <a href="./myDetails.php">My Details</a>
      <br />
      <br />
      <a href="https://wa.me/7013328951" style="color: gray; font-size: 0.7rem">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
        Contact developer
      </a>
    </div>
  </body>
</html>
