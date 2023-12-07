	</div><!-- #content -->
	<?php
	$siteLogo = get_field('homepage_logo','option');   
	$partners = get_field("partners","option");
	?>
	<?php get_template_part("parts/footer-text-block"); ?>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrapper">

			<?php if($siteLogo) { ?>
			<div class="footer-logo"><img src="<?php echo $siteLogo['url'] ?>" alt="<?php echo $siteLogo['title'] ?>" /></div>
			<?php } ?>

			<?php if($partners) { ?>
				<div class="footer-partners">
					<div class="footerInner">
					<?php foreach($partners as $p) { 
							$id = $p['ID'];    
							$website = get_field('image_website_url',$id);
							if($website) { ?>
									<a href="<?php echo $website ?>" target="_blank"><img src="<?php echo $p['url']?>" alt="<?php echo $p['title']?>"></a>
							<?php } else {  ?>
									<img src="<?php echo $p['url']?>" alt="<?php echo $p['title']?>">
							<?php } ?>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
			
			<?php if( has_nav_menu('footer') ) { ?>
				<div class="footerNavigation">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu') ); ?>
				</div>
			<?php } ?>

			<?php
				$address = get_field('office_address','option');
				$pobox = get_field('pobox','option');
				$phone = get_field('phone','option');
				$email = get_field('email','option');
				$mail = get_field('mailing_list_link','option');
				$contact_info = '';
				if($address) {
					$contact_info .= '<span class="address"><i class="fa-solid fa-location-dot"></i> '.$address.'</span>';
				}
				if($pobox) {
					$contact_info .= '<span class="pobox"><i class="fa-solid fa-envelope"></i> '.$pobox.'</span>';
				}
				if($phone) {
					$contact_info .= '<span class="phone"><i class="fa-solid fa-phone"></i><a href="tel:'.$phone.'">'.$phone.'</a></span>';
				}
				if($email) {
					$contact_info .= '<span class="email"><a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a></span>';
				}
				if($mail) {
					$target = (isset($mail['target']) && $mail['target']) ? $mail['target'] : '_self';
					$LinkName = (isset($mail['title']) && $mail['title']) ? $mail['title'] : '';
					$url = (isset($mail['url']) && $mail['url']) ? $mail['url'] : '';
					if($LinkName && $url) {
						$contact_info .= '<span class="maillist"><a href="'.$url.'" target="'.$target.'">'.$LinkName.'</a></span>';
					}
				}
				if($contact_info) { ?>
				<div class="footer-contact-info"><div class="footerInner"><?php echo $contact_info ?></div></div>
				<?php } ?>


				<?php
				$social_media = get_social_media();
				if($social_media) { ?>
				<div class="footer-social-media">
					<div class="footerInner">
					<?php foreach ($social_media as $icon) { ?>
					<a href="<?php echo $icon['url'] ?>" target="_blank" arial-label="<?php echo ucwords($icon['type']) ?>"><i class="<?php echo $icon['icon'] ?>"></i></a> 
					<?php } ?>
					</div>
				</div> 
				<?php } ?>

				<?php
				$privacy = get_field('privacy_link','option');
				$footLink = '';
				if($privacy) {
					$target = (isset($privacy['target']) && $privacy['target']) ? $privacy['target'] : '_self';
					$LinkName = (isset($privacy['title']) && $privacy['title']) ? $privacy['title'] : '';
					$url = (isset($privacy['url']) && $privacy['url']) ? $privacy['url'] : '';
					if($LinkName && $url) {
						$footLink .= '<span class="privacy-policy"><a href="'.$url.'" target="'.$target.'">'.$LinkName.'</a></span>';
					}
				}
				$footLink .= '<span class="poweredby"><a href="https://bellaworksweb.com/" target="_blank">Site by Bellaworks</a></span>';
				if($footLink) { ?>
					<div class="footer-privacy">
						<?php echo $footLink; ?>
					</div>
				<?php } ?>

		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
