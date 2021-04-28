<?php
/**
 * Language selector displayed in the header.
 *
 * This template is called from lib/custom.php which is hooked to the hub_language_select action defined in templates/header.php
 */

/** @var array $languages Array of enabled languages */
?>

<?php foreach ($languages as $language): ?>
	<?php if(!$language['active']){ ?>
        <a href="<?php echo $language['url']; ?>"><img src="<?php echo $language['country_flag_url']; ?>" alt="<?php echo $language['language_code'];?>"></a>
	<?php } ?>
<?php endforeach; ?>