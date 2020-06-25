<?php
include 'src/includes/header.php';

$page = 'src/pages/';
if (isset($_GET['page'])) { // if get page is set
    $page .= htmlspecialchars($_GET['page']); // page is value from the key
} else {
    $page .= 'home'; // else page is home
}

$page .= '.php';

include $page; ?>

<?php include 'src/includes/footer.php'; ?>
