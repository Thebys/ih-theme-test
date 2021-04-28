<?php
/**
 * This file defines all modal form confirmations.
 *
 * The correct template can be picked based on various attributes as deined below.
 *
 * This file is called from lib/gravity-forms-ga-confirmations.php
 */

/** @var string $formAnea Slug of the form that was successfully submitted */
/** @var string $formSender E-mail address of the form sender */
/** @var string $formLocation Impact Hub Location to which the submission is related */
/** @var string $formID ID of the submitted form */
?>

<?php if($formAnea == 'meeting' && $formLocation == 'd10'): ?>
	<?php log_form_message("Printing D10 meeting confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme se na vás v Impact Hubu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Co nevidět se vám ozveme</span>, abychom domluvili podrobnosti schůzky a případně zodpověděli vaše dotazy. Zároveň nás můžete kdykoli kontaktovat v pracovní dny od 8:30 - 18:30.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Na viděnou!", "notifikace-modal") ?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že se u nás pořádá řada veřejných akcí?", "notifikace-modal")?></p>
						<?=__("<a href='/kalendar' class='page-button-new kalendar-modal'>Do kalendáře</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'meeting' && $formLocation == 'k10'): ?>
	<?php log_form_message("Printing K10 meeting confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme se na vás v Impact Hubu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Co nevidět se vám ozveme</span>, abychom domluvili podrobnosti schůzky a případně zodpověděli vaše dotazy. Zároveň nás můžete kdykoli kontaktovat v pracovní dny od 8:00 - 21:00.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Na viděnou!", "notifikace-modal") ?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že se u nás pořádá řada veřejných akcí?", "notifikace-modal")?></p>
						<?=__("<a href='/kalendar' class='page-button-new kalendar-modal'>Do kalendáře</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'office_inquiry' && $formLocation == 'k10'): ?>
	<?php log_form_message("Printing K10 office confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme se na vás v Impact Hubu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Vaše poptávka je úspěšně odeslána.</span> Obratem se ozveme, abychom si řekli více o našich službách a možné prohlídce. Zároveň nás můžete kdykoli kontaktovat v pracovní dny od&nbsp;8:00&nbsp;-&nbsp;21:00.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Na viděnou!", "notifikace-modal") ?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že se u nás pořádá řada veřejných akcí?", "notifikace-modal")?></p>
						<?=__("<a href='/kalendar' class='page-button-new kalendar-modal'>Do kalendáře</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'office_inquiry' && $formLocation == 'd10'): ?>
	<?php log_form_message("Printing D10 office confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme se na vás v Impact Hubu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Vaše poptávka je úspěšně odeslána.</span> Obratem se ozveme, abychom si řekli více o našich službách a možné prohlídce. Zároveň nás můžete kdykoli kontaktovat v pracovní dny od&nbsp;8:30&nbsp;-&nbsp;18:30.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Na viděnou!", "notifikace-modal") ?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že se u nás pořádá řada veřejných akcí?", "notifikace-modal")?></p>
						<?=__("<a href='/kalendar' class='page-button-new kalendar-modal'>Do kalendáře</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'book_space' || $formAnea == 'book_meeting_room'): ?>
	<?php log_form_message("Printing spaces confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">
                    </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme se na vás v Impact Hubu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Děkujeme za vaši poptávku.</span> Co nevidět se vám ozveme, abychom probrali všechny náležitosti vašeho pronájmu.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Přejeme hezký den a těšíme se na viděnou.", "notifikace-modal") ?></p>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'signup_project'): ?>
	<?php log_form_message("Printing project signup confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/meeting.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">
                    </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Díky, teď víme i o&nbsp;vašem projektu", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Děkujeme za&nbsp;váš zájem.</span> Informace o&nbsp;projektu máme zaznamenané a co nejdříve se vám ozveme, abychom se domluvili, kam se váš projekt nejvíce hodí.", "notifikace-modal")?></p>
                        <p class="text-center font-size-reset"><?=__("Přejeme hezký den.", "notifikace-modal") ?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že u&nbsp;nás můžete váš projekt nejen prezentovat, ale i rozvíjet v&nbsp;jednom z&nbsp;našich akceleračních programů?", "notifikace-modal")?></p>
						<?=__("<a href='/akcelerace/' class='page-button-new kalendar-modal'>Prohlédnout programy</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'acceleration'): ?>
	<?php log_form_message("Printing Acceleration Form confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/acceleration.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Těšíme na spolupráci", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Co nevidět se vám ozveme</span>, abychom domluvili podrobnosti a případně zodpověděli vaše dotazy. Pokud potřebujete vědět cokoliv dalšího, můžete v&nbsp;pracovní dny zavolat přímo akcelerační koordinátorce Báře na&nbsp;čísle <a href='tel:+420776543044'>+420 776 543 044</a>.", "notifikace-modal")?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Víte, že se u nás pořádá řada veřejných akcí?", "notifikace-modal")?></p>
						<?=__("<a href='/kalendar/' class='page-button-new kalendar-modal'>Do&nbsp;kalendáře</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'become_mentor'): ?>
	<?php log_form_message("Printing Become Mentor form confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/acceleration.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Děkujeme za&nbsp;váš zájem o&nbsp;mentorství", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Co nevidět se vám ozveme</span>, abychom domluvili podrobnosti a případně zodpověděli vaše dotazy.", "notifikace-modal")?></p>
                        <hr>
                        <p class="text-center margin-bottom-20 text-italic font-size-reset"><?=__("Znáte naše akcelerační programy? Ročně jimi projde přes 100 firem, startupů i neziskovek.", "notifikace-modal")?></p>
						<?=__("<a href='/akcelerace/' class='page-button-new kalendar-modal'>Prohlédnout programy</a>", "notifikace-modal")?>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>

<?php if($formAnea == 'stream_studio'): ?>
	<?php log_form_message("Printing Become Mentor form confirmation."); ?>
    <div class="modal fade in" id="thank-you-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <div class="image">
                        <img width="600" height="250" src="/wp-content/themes/impacthub/assets/img/confirmations/studio.jpg" class="attachment-mobile-square size-mobile-square wp-post-image" alt="">                  </div>
                    <div class="media-body">
                        <h4 class='media-heading text-center'><?=__("Děkujeme za vaši poptávku", "notifikace-modal") ?></h4>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("<span class='text-strong'>Co nevidět se vám ozveme</span>, abychom doladili detaily vašeho pronájmu.", "notifikace-modal")?></p>
                        <hr>
                        <p class="text-center line-height-15em font-size-reset"><?=__("Přejeme příjemný den, eventový tým Impact Hub Praha ", "notifikace-modal")?></p>
                        <hr>
                    </div>
                </div><!-- modal-body-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php endif; ?>
