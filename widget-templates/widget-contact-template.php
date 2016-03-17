<?php
/*
 * Template for the output of the Cortex Contact Widget
 * Override by placing a file called widget-contact-template.php in your active theme in a directory called widgets
 */

/* Output
	title text
	street
	city
	state
	postal code
	country
	contact phone
	contact email
*/
extract($instance);

echo '<!-- contact widget -->
<aside id="widget-cortex-contact" class="widget widget-cortex-contact">
<header>';

echo '<h3 class="widget-title">';
if ( isset( $instance['title_text'] ) ) {
	echo $instance['title_text'];
}
echo '</h3>';
echo '</header>';
?>

<div id="cortex-contact" class="vcard widget-cortex-contact-body">
 <a class="url fn n" href="<?php get_site_url(); ?>"> <div class="org hide"><?php echo bloginfo('name'); ?></div></a>
 <?php if (!empty($contact_email)) { ?><span class="email obfuscate">
 <?php
	$contact_email = sanitize_email($contact_email);
	echo '<a href="mailto:'.antispambot($contact_email,1).'" title="'.esc_html__( 'Contact', 'cortex' ).'">'.antispambot($contact_email).'</a>'; ?>
	 </span><?php } ?>
 <div class="adr">
  <div class="street-address"><?php echo $street; ?></div>
  <span class="locality"><?php echo $city; ?>, </span>
  <span class="region"><?php echo $state; ?></span>
  <span class="postal-code"><?php echo $postal_code; ?></span>

  <span class="country-name"><?php echo $country; ?></span>

 </div>
 <?php if (!empty($contact_phone)) { ?><div class="tel"><?php echo $contact_phone; ?></div><?php } ?>
</div>
<?php
echo '</aside>';
?>
