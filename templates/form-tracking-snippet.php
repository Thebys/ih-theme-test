<?php
/**
 * This file defines javascript snippet which is used after a form was submitted.
 *
 * The functions called from this snippet need to be set as global so the snippet can access them.
 *
 * This file is called from lib/gravity-forms-ga-confirmations.php
 */

/** @var string $formAnea Slug of the form that was successfully submitted */
/** @var string $formSender E-mail address of the form sender */
?>
<script type="text/javascript">
    $=jQuery;
    $(document).ready(function() {
        sendGA('form_submit_completed', '<?= $formAnea ?>', '<?= $formSender ?>');
        if($('#thank-you-modal').length > 0)
            openThankYouModal();
    });
	<?php log_form_message("Printing tracking code. form_ga_anea: $formAnea, form_ga_sender: $formSender"); ?>
</script>