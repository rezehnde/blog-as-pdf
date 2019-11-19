<?php
/*
Plugin Name: Blog as PDF
Plugin URI: https://rezehnde.com/
Description: Export posts from your wordpress blog as PDF. Choose some
or download all posts into a single PDF file.
Version: 1.2
Author: Marcos Rezende
Author URI: https://www.linkedin.com/in/rezehnde/
*/

/**
 * Blog_As_Pdf_page
 *
 * @return void
 */
function Blog_As_Pdf_page() { ?>
<div class="wrap">
    <h2><?php _e('Blog as PDF') ?></h2>
    by <strong><a href="https://www.linkedin.com/in/rezehnde/">Marcos Rezende</a></strong>
    <hr>
    <div style="float:left; width: 400px; background-color:white;padding: 0px 10px 10px 10px;margin-right:15px;border: 1px solid #ddd;">
    <img src="<?php echo get_option('siteurl') ?>/wp-content/plugins/blog-as-pdf/images/pdf.png" alt="Download PDF" style="float:left; margin-right: 5px;" /><h3>Proceed to download</h3>
    <p>Are you ready to get your entire blog or some posts from specific categories as PDF? So, click on these links bellow to download your posts in a single PDF file.</p>
        <ul style="font-weight: bold;">By Category:
    <?php
    global $wpdb;
    $query = "SELECT DISTINCT T.term_id, T.name
                FROM ".$wpdb->terms." T
                INNER JOIN ".$wpdb->term_taxonomy." TT ON TT.term_id = T.term_id
                WHERE TT.taxonomy =  'category' ORDER BY T.name ASC";
    $categories = $wpdb->get_results($query);
    foreach ($categories as $cat) {
        ?>
            <li style="font-weight: normal;">
                <a href="<?php echo get_option('siteurl') ?>/wp-content/plugins/blog-as-pdf/generate.php?category_id=<?php echo $cat->term_id; ?>">
                <span style="padding-top: 10px;">
                    <?php echo $cat->name; ?>
                </span>
                </a>
            </li>
        <?php
    }
    ?>
    </ul>
    <p><a href="<?php echo get_option('siteurl') ?>/wp-content/plugins/blog-as-pdf/generate.php"><span style="padding-top: 10px; font-weight: bold;">Or download this entire blog as PDF</span></a></p>
    </div>
</div>
<?php }
/**
 * Blog_As_Pdf_Configure_pages
 *
 * @return void
 */
function Blog_As_Pdf_Configure_pages() {
    add_options_page('Blog as PDF', 'Blog as PDF', 8, __FILE__, 'Blog_As_Pdf_page');
}
add_action('admin_menu', 'Blog_As_Pdf_Configure_pages');
?>
