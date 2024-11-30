<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">

<?php
if(isset($_SESSION['title']) && $_SESSION['title'] !='')
{
    ?>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['title']; ?>",
            icon: "<?php echo $_SESSION['icon']; ?>",
            confirmButtonText: "OK"
        });
    </script>
    <?php
    unset($_SESSION['title']);
}
?>