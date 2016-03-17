<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="<?php echo $this->id_base . '_form-' . $this->number; ?>" method="post">
<?php echo $this->subscribe_errors;?>
<?php
	if ($instance['collect_first']) {
?>
	<p class="input input--cortex"><input type="text" name="<?php echo $this->id_base . '_first_name'; ?>" class="input__field input__field--cortex" /><label class="input__label input__label--cortex input__label--cortex-color-1"><span class="input__label-content--cortex"><?php echo __('Enter first name', 'mailchimp-widget'); ?></span></label></p>
<?php
	}
	if ($instance['collect_last']) {
?>
	<p class="input input--cortex"><input type="text" name="<?php echo $this->id_base . '_last_name'; ?>" class="input__field input__field--cortex" /><label class="input__label input__label--cortex input__label--cortex-color-1"><span class="input__label-content--cortex"><?php echo __('Enter last name', 'mailchimp-widget'); ?></span></label></p>
<?php
	}
?>
	<input type="hidden" name="ns_mc_number" value="<?php echo $this->number; ?>" />
	<p class="input input--cortex"><input id="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>" type="text" name="<?php echo $this->id_base; ?>_email" class="input__field input__field--cortex" />
		<label for="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>" class="input__label input__label--cortex input__label--cortex-color-1"><span class="input__label-content--cortex"><?php echo __('Enter email', 'mailchimp-widget'); ?></span></label></p>
	<input class="button" type="submit" name="<?php echo __($instance['signup_text'], 'mailchimp-widget'); ?>" value="<?php echo __($instance['signup_text'], 'mailchimp-widget'); ?>" />
</form>
	<script>jQuery('#<?php echo $this->id_base; ?>_form-<?php echo $this->number; ?>').ns_mc_widget({"url" : "<?php echo $_SERVER['PHP_SELF']; ?>", "cookie_id" : "<?php echo $this->id_base; ?>-<?php echo $this->number; ?>", "cookie_value" : "<?php echo $this->hash_mailing_list_id(); ?>", "loader_graphic" : "<?php echo $this->default_loader_graphic; ?>"}); </script>
