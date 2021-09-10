<?php
$url = $this->uri->segment(1);
if (!empty($url)) {
    if ($url == 'city') {
?>
        <script>
            var c_img_url = '<?= C_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/pages/city.js"></script>
    <?php
    }
    if ($url == 'places') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/select2.min.js"></script>
        <script src="<?= base_url() ?>public/dist/js/pages/places.js"></script>
    <?php
    }
    if ($url == 'restaurant') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
            var menu_img_url = '<?= MENU_IMG_URL; ?>';
        </script>

        <script src="<?= base_url() ?>public/dist/js/select2.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC_GrO0peF27v5Uf2hgsnkoFGbT4ga9kw&libraries=places"></script>
        <script src="<?= base_url() ?>public/dist/js/pages/restaurant.js?60"></script>
        <script src="<?= base_url() ?>public/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <?php
    }
    if ($url == 'establishment') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/select2.min.js"></script>
        <script src="<?= base_url() ?>public/dist/js/pages/establishment.js"></script>
    <?php
    }
    if ($url == 'cuisine') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/select2.min.js "></script>
        <script src="<?= base_url() ?>public/dist/js/pages/cuisine.js"></script>
    <?php
    }
    if ($url == 'food') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/select2.min.js"></script>
        <script src="<?= base_url() ?>public/dist/js/pages/food.js"></script>
    <?php
    }
    if ($url == 'meal') {
    ?>
        <script>
            var p_img_url = '<?= P_IMG_URL; ?>';
        </script>
        <script src="<?= base_url() ?>public/dist/js/select2.min.js"></script>
        <script src="<?= base_url() ?>public/dist/js/pages/meal.js"></script>
    <?php
    }
    if ($url == 'faq') {
    ?>
        <script src="<?= base_url() ?>public/dist/js/pages/faq.js"></script>
<?php
    }
}
?>