<?php
/**
 * Template of the page intro with headline, intro text, call to action and possibly icons.
 *
 * This template is called from base.php
 */

if(!function_exists('get_fields'))
    return;

$pid = get_queried_object_id();

// cache all the fields to limit # of DB queries
$fields = get_fields($pid);

// display default banner if the new intro is not activated
if(!get_field('new_page_intro', $pid)) {
    page_banner();
    return;
}

$colorClass = str_replace('bg-', 'c-', get_field('bgc', $pid));

?>

<style type="text/css">
    main {
        background-image: url('<?= get_field('img_desktop', $pid); ?>');
    }

    .bottom-line,
    .old-intro {
        display: none;
    }

    @media screen and (max-width: 767px) {
        main {
            background-image: url('<?= get_field('img_mobile', $pid); ?>');
            background-position-x: <?= get_field('mobile_align', $pid); ?> !important;
        }
    }
</style>

<div class="page-intro padding-top-bottom-30 text-center container">
    <div class="page-intro-bglayer <?= get_field('bgc', $pid); ?>"></div>

    <div class="contained-row page-headline">
	    <?php if(get_field('tag', $pid)): ?>
            <span class="tag <?= $colorClass ?>">
                <?= get_field('tag', $pid); ?>
            </span>
	    <?php endif; ?>
	    <?php if(get_field('special_tag', $pid)): ?>
            <span class="tag bg-yellow <?= $colorClass ?>">
                <?= get_field('special_tag', $pid); ?>
            </span>
        <?php endif; ?>
        <h1><?= get_field('headline', $pid); ?></h1>

        <?php if($numbers = get_field('numbers')) : ?>
        <div class="highlight-numbers flex-boxes">
            <?php foreach( $numbers as $highlightNumber ) : ?>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <span><?= $highlightNumber['number']; ?></span>
                <?= $highlightNumber['label']; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <p><?= get_field('description', $pid); ?></p>
        <?= get_c2a_button(false, $pid); ?>
    </div>

    <?php if( have_rows('icons', $pid) ): ?>
    <div class="contained-row">
        <div class="icons padding-top-30 flex-boxes overflow-visible">
            <?php while ( have_rows('icons', $pid) ) : the_row(); ?>
            <?php 
            $tooltip = '';
            if (get_sub_field('tooltip')) {
                $tooltip = 'data-tooltip="' . get_sub_field('tooltip') . '"';
            }
            ?>
            <div class="text-icon col-xs-6 col-sm-4 col-md-2" <?= $tooltip ?>>
                <?php if(get_sub_field('link')) : ?>
                <a href="<?= get_sub_field('link'); ?>">
                <?php endif; ?>
                    <i class="<?= get_sub_field('class'); ?>"></i> 
                    <p><?= get_sub_field('label'); ?></p>
                <?php if(get_sub_field('link')) : ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?= get_c2a_button(true, $pid); ?>
    <?php endif; ?>

    <?= !get_field('button_text') ? "<i class=\"fa fa-chevron-down\"></i>" : '' ?>
</div>

<?php if(is_user_logged_in()) : ?>
<?php $colors = get_color_class_options(); ?>
<div id="intro-color-switch">
    <label for="label-selector">Intro color</label>
    <select id="bgcolor-selector">
	    <?php foreach ($colors as $key => $value) : ?>
            <option value="<?= $key ?>" <?= $key == get_field('bgc', $pid) ? 'selected' : ''; ?> >
                <?= $value ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="transparent-switch">Button transparency</label>
    <button id="transparent-switch">Toggle</button>
</div>
<?php endif; ?>

<script type="text/javascript">
    $ = jQuery;
    $(document).ready(function () {
        var $select = $('#intro-color-switch select');
        if(!$select.length) {
            return;
        }
        var colorClass = $select.val();
        var textcolorClass = colorClass.replace('bg-', 'c-');
        console.log(textcolorClass);
        $select.change(function () {
            let newClass = $select.val();
            var newtextClass = newClass.replace('bg-', 'c-');
            $('.page-intro-bglayer').removeClass(colorClass).addClass(newClass);
            $('.page-intro .tag').removeClass(textcolorClass).addClass(newtextClass);
            colorClass = newClass;
            textcolorClass = newtextClass;
        });
        $('#intro-color-switch button').click(function () {
            $('.page-intro .page-button-new').toggleClass('transparent');
        });
    });
</script>

<?php 
function get_c2a_button($isBottom, $pid) {
    $text = get_field('button_text', $pid);
    $link = get_field('button_link', $pid);
    $bottom = get_field('button_bottom', $pid);
    $anec = get_field('anec', $pid);
	$anea = get_field('anea', $pid);

    if($text == '' || $text == null || $bottom != $isBottom)
        return '';

    $target_attr = get_field('button_open_blank', $pid) ? '_blank' : '';
    $transparent_class = get_field('button_transparent', $pid) ? 'transparent' : '';
    $anec_attr = $anec ? "anec=\"$anec\"" : '';
    $anea_attr = ($anec && $anea) ? "anea=\"$anea\"" : '';

    return "<a href=\"$link\" target=\"$target_attr\" class=\"page-button-new $transparent_class\" $anec_attr $anea_attr>$text</a>";
}
?>