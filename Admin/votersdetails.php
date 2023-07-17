<?php
include "inc/connection.php";

// Retrieve the admin user data
$sel = "SELECT * FROM users WHERE user_role = 'admin'";
$query = mysqli_query($conn, $sel);
$result = mysqli_fetch_assoc($query);

// Retrieve the list of active elections
$fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'active'") or die(mysqli_error($conn));
?>
<?php
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM votings WHERE id = '$id'");
  header('Location: votersdetails.php');
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <!-- For icons -->
  <link rel="stylesheet" href="../cssfolder/voter.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <style>
    .box-btn{
      display: block;
     width: 50%;
   cursor: pointer;
   font-size: 1rem;
   border-radius: .5rem;
   margin-top: 1rem;
   font-size: 1 rem;
   padding:1rem 3rem;
   background: red;
   text-align: center;
    }
  </style>
</head>

<body>
  <div class="grid-container">
    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="class-left">
        <h3>Welcome- <small>
            <?php echo $result['fullname']; ?>
          </small></h3>
      </div>

    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <a href="dashboard.php">
            <span class="material-icons-outlined">how_to_vote</a></span>Go Vote

        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">dashboard</span> Dashboard
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="addelection.php">
            <span class="material-icons-outlined">event_available</span>Elections
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="addcandidate.php">
            <span class="material-icons-outlined">groups</span> Candidates
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="votersdetails.php">
            <span class="material-icons-outlined">groups</span> Voterlist
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="viewresult.php">
            <span class="material-icons-outlined">visibility</span> View Result
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="notify.php">
            <span class="material-icons-outlined">settings</span> Notify
          </a>
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->

    <section class="voting">
      <div class="candidate_list">
        <h3 style="text-align: center;">Voter Details</h3>

        <?php
        while ($activeElection = mysqli_fetch_assoc($fetchingActiveElections)) {
          $election_id = $activeElection['election_id'];
          $fetchingVoteDetails = mysqli_query($conn, "SELECT * FROM votings WHERE election_id = '" . $election_id . "'");
          $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

          if ($number_of_votes > 0) {
            $sno = 1;
        ?>
            <h4 style="text-align: center;">Election: <?php echo $activeElection['election_topic']; ?></h4>
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Voter Name</th>
                  <th>Contact No</th>
                  <th>Voted To</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <?php
              while ($data = mysqli_fetch_assoc($fetchingVoteDetails)) {
                $voters_id = $data['voters_id'];
                $candidate_id = $data['candidate_id'];
                $fetchingUsername = mysqli_query($conn, "SELECT * FROM users WHERE id = '" . $voters_id . "'") or die(mysqli_error($conn));
                $isDataAvailable = mysqli_num_rows($fetchingUsername);
                $userData = mysqli_fetch_assoc($fetchingUsername);
                if ($isDataAvailable > 0) {
                  $username = $userData['fullname'];
                  $contact_no = $userData['phone'];
                } else {
                  $username = "No_Data";
                  $contact_no = $userData['contact_no'];
                }

                $fetchingCandidateName = mysqli_query($conn, "SELECT * FROM candidate_details WHERE id = '" . $candidate_id . "'") or die(mysqli_error($conn));
                $isCandidateAvailable = mysqli_num_rows($fetchingCandidateName);
                $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                if ($isCandidateAvailable > 0) {
                  $candidate_name = $candidateData['candidate_name'];
                } else {
                  $candidate_name = "Not Voted";
                }
              ?>
                <tr>
                  <td><?php echo $sno++; ?></td>
                  <td><?php echo $username; ?></td>
                  <td><?php echo $contact_no; ?></td>
                  <td><?php echo $candidate_name; ?></td>
                  <td><?php echo $data['vote_date']; ?></td>
                  <td><?php echo $data['vote_time']; ?></td>
                  <td>
                  <a href="votersdetails.php?delete=<?php echo $data['id']; ?>" class="box-btn" style="text-decoration: none; color:white;"> delete </a>
                    </td>
                </tr>
              <?php
              }
              ?>
            </table>
        <?php
          } else {
            echo "<p>No any voter detail is available for the election: " . $activeElection['election_topic'] . "!</p>";
          }
        }
        ?>
      </div>
    </section>

    <!-- Rest of your HTML code -->

    <!-- Custom JS -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
  </div>
</body>

</html>
