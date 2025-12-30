<?php
session_start();
require 'db.php';

/* PROTECT PAGE */
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Medivesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Welcome Admin</h3>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

    <!-- COUNT CARDS -->
    <div class="row g-4">

        <?php
        $tables = [
            'contact_messages' => 'Contact Messages',
            'career_applications' => 'Career Applications',
            'subscribers' => 'Subscribers'
        ];

        foreach ($tables as $table => $label) {
            $count = $conn->query("SELECT COUNT(*) AS total FROM $table")->fetch_assoc()['total'];
            echo "
            <div class='col-md-4'>
                <div class='card shadow-sm'>
                    <div class='card-body text-center'>
                        <h5>$label</h5>
                        <p class='display-6'>$count</p>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>

    <!-- BUTTONS -->
    <div class="text-center my-4">
        <button class="btn btn-primary mx-1" onclick="showTable('contactTable')">📨 Contact Messages</button>
        <button class="btn btn-success mx-1" onclick="showTable('careerTable')">📄 Career Applications</button>
        <button class="btn btn-warning mx-1" onclick="showTable('subscriberTable')">📧 Subscribers</button>
    </div>

    <!-- ================= CONTACT TABLE ================= -->
    <div id="contactTable" class="data-table" style="display:none;">
        <h4 class="mb-3">📨 Contact Messages</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM contact_messages ORDER BY id DESC";
                    $result = $conn->query($sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$i}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['subject']}</td>
                                <td style='max-width:300px; white-space:pre-wrap;'>{$row['message']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No messages found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= CAREER TABLE ================= -->
    <div id="careerTable" class="data-table" style="display:none;">
        <h4 class="mb-3">📄 Career Applications</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Position</th>
                        <th>Message</th>
                        <th>CV</th>
                        <th>Applied On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM career_applications ORDER BY id DESC";
                    $result = $conn->query($sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $cvPath = "uploads/cv/" . $row['cv_filename'];
                            $cvLink = $row['cv_filename']
                                ? "<a href='$cvPath' target='_blank' class='btn btn-sm btn-primary'>View CV</a>"
                                : "<span class='text-muted'>No CV</span>";

                            echo "
                            <tr>
                                <td>{$i}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['position']}</td>
                                <td style='max-width:300px; white-space:pre-wrap;'>{$row['message']}</td>
                                <td>$cvLink</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No career applications found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= SUBSCRIBERS TABLE ================= -->
    <div id="subscriberTable" class="data-table" style="display:none;">
        <h4 class="mb-3">📧 Newsletter Subscribers</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Subscribed On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM subscribers ORDER BY created_at DESC";
                    $result = $conn->query($sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$i}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No subscribers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- JS -->
<script>
function showTable(id) {
    document.querySelectorAll('.data-table').forEach(el => el.style.display = 'none');
    document.getElementById(id).style.display = 'block';
    document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
}

// default view
showTable('contactTable');
</script>

</body>
</html>
