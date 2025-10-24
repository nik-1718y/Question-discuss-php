<div class="container">
  <div class="row">
    <div class="col-8">
      <h1 class="heading">Questions</h1>
      <?php
      include("./common/db.php");

      // Initialize variables safely
      $cid = isset($_GET["c-id"]) ? (int)$_GET["c-id"] : null;
      $uid = isset($_GET["u-id"]) ? (int)$_GET["u-id"] : null;
      $search = isset($_GET["search"]) ? $_GET["search"] : null;

      // Build query safely
      if ($cid) {
        $query = "SELECT * FROM questions WHERE category_id = $cid";
      } elseif ($uid) {
        $query = "SELECT * FROM questions WHERE user_id = $uid";
      } elseif (isset($_GET["latest"])) {
        $query = "SELECT * FROM questions ORDER BY id DESC";
      } elseif ($search) {
        $safeSearch = mysqli_real_escape_string($conn, $search);
        $query = "SELECT * FROM questions WHERE title LIKE '%$safeSearch%'";
      } else {
        $query = "SELECT * FROM questions";
      }

      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) {
        foreach ($result as $row) {
          $title = htmlspecialchars($row['title']);
          $id = $row['id'];
          echo "<div class='row question-list'>
                  <h4 class='my-question'>
                    <a href='?q-id=$id'>$title</a>";

          // Show Delete button only if $uid exists
          if (isset($uid)) {
            echo " <a href='./server/requests.php?delete=$id' class='ms-2 text-danger'>Delete</a>";
          }

          echo "</h4></div>";
        }
      } else {
        echo "<p>No questions found.</p>";
      }
      ?>
    </div>

    <div class="col-4">
      <?php include('categorylist.php'); ?>
    </div>
  </div>
</div>
