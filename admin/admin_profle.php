<?php 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

require_once 'admin_common/admin_header.php';

?>

<h1>Hello vviek</h1>

<?php 
require_once 'admin_common/admin_footer.php';
?>



