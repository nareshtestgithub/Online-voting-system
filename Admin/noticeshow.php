<?php
include_once('inc/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <link rel="stylesheet" href="../cssfolder/optinola.css">
  <style>
    /* CSS for the notice section */
    .popup .overlay {
  position:  fixed;
  top: 0px;
  left:  0px;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.7);
  z-index:1 ;
  display: none;


}
.notice-section{
  margin-top: -100px;
}
.notice-section li {
    cursor: pointer; /* Add this line to set cursor to pointer on hover */
    margin-top: 10px;
    font-size: 20px;
  }
.popup .content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0);
  background: #fff;
  width: 450px;
  z-index: 2;
  text-align: center;
  padding: 20px;
  box-sizing: border-box;
}
.popup .close-btn{
  cursor: pointer;
  position:absolute;
  right: 20px;
  top: 20px;
  width: 30px;
  background: #222;
  color: #fff;
  font-size: 25px;
  line-height: 30px;
  text-align: center;
  border-radius: 50%;

}

.popup.active .overlay{
  display: block;
}

.popup.active .content {
  transition: all 300ms ease-in-out;
  transform: translate(-50%, -50%) scale(1);
}
  </style>
</head>

<body>
  <!-- Top banner -->
  <div class="top-banner">
    <div class="container">
      <div class="small-bold-text banner-text">Cast your vote from anywhere, anytime with our secure and convenient
        online voting system."</div>
    </div>
  </div>
  <!-- Navbar -->
  <nav>
    <div class="container main-nav flex">
      <a href="../hompage/optionalhome.html" class="company-logo">
        <h1>Govote</h1>
      </a>
      <div class="nav-links">
        <ul class="flex">
          <li><a href="../hompage/optionalhome.php" class="hover-links">Home</a></li>
          <li><a href="candidate.php" class="hover-links">Candidates</a></li>
          <li><a href="noticeshow.php" class="hover-links">Notice</a></li>
          <li><a href="../hompage/login_page.php" class="hover-links secondary-btn">Login</a></li>
          <li><a href="../hompage/Register-page.php" class="hover-links primary-btn">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- header section -->
  <header>
    <div class="container header-section flex">
      <div class="header-left">
      <div class="notice-section">
       
      <?php
      $sql = "SELECT * FROM notice";
      $details = $conn->query($sql);
      $totalNotices = mysqli_num_rows($details);
      

      if ($totalNotices > 0) {
        ?>
        
        <p>Avabile Notice are</p>
        <?php
        while ($row = mysqli_fetch_assoc($details)) {
          $popupId = "popup-" . $row['id']; // Assuming 'id' is a unique identifier in your notice table
          ?>
      
       
      
          <li onclick="togglePopup('<?php echo $popupId; ?>')">
            <?php echo $row['Title']; ?>
          </li>
          <div class="popup" id="<?php echo $popupId; ?>">
            <div class="overlay"></div>
            <div class="content">
              <div class="close-btn" onclick="togglePopup('<?php echo $popupId; ?>')">&times;</div>
              <h1><?php echo $row['Title']; ?></h1>
              <p><?php echo $row['content']; ?></p>
            </div>
          </div>
          <?php
        }
      } else {
        ?>
        <p>No notice available.</p>
        <?php
      }
      ?>
    </div>
 
  </div>
      </div>
    </div>
    <div class="custom-shape-divider-bottom-1688894802">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path
          d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
          class="shape-fill"></path>
      </svg>
    </div>
  </header>
  <script>
   function togglePopup() {
      // Toggle the first popup, you may need to adjust this if you have specific requirements
      document.querySelector(".popup").classList.toggle("active");
    }

    function togglePopup(popupId) {
      document.getElementById(popupId).classList.toggle("active");
    }
  </script>
</body>
</html>
