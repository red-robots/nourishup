<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
$homepageLogo = get_field('homepage_logo','option');
$subPageLogo = get_field('subpage_logo','option');
?>
<script>
const homepageLogo = '<?php echo ($homepageLogo) ? $homepageLogo['url']:''?>';
const subpageLogo = '<?php echo ($subPageLogo) ? $subPageLogo['url']:''?>';
const siteName = '<?php echo get_bloginfo('name') ?>';
var assetsDir = '<?php echo get_stylesheet_directory_uri() ?>/assets/img';
var siteURL = '<?php echo get_site_url() ?>';
const currentPageId = <?php echo (is_page()) ? get_the_ID():'' ?>;
</script>