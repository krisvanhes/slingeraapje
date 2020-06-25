<?php
// ADMIN DASHBOARD

include 'includes/header.php';

$page = 'pages/';
if (isset($_GET['page'])) { // if get page is set
    $page .= htmlspecialchars($_GET['page']); // page is value from the key
} else {
    $page .= 'dashboard'; // else page is home
}

$page .= '.php';

include $page; ?>

<?php include 'includes/footer.php'; ?>
