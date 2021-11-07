<?php
    require_once('./page_stuff/page_session.php');
    require_once("../../config.php");
    require_once("./page_fnc/fnc_movie.php");
    require("./page_stuff/page_header.php");
?>
    <h2>Filmi info</h2>
    <?php echo list_person_movie_info(); ?>
<?php require_once('./page_stuff/page_footer.php'); ?>