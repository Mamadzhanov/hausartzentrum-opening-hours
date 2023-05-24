<?php
// Prevent direct access to the file
defined('ABSPATH') or die('No script kiddies, please!');

$settings = get_option('hz_opening_time_settings');
$weekdays = array(
    'mon' => __('Montag', 'hz-opening-time'),
    'tue' => __('Dienstag', 'hz-opening-time'),
    'wed' => __('Mittwoch', 'hz-opening-time'),
    'thu' => __('Donnerstag', 'hz-opening-time'),
    'fri' => __('Freitag', 'hz-opening-time'),
    'sat' => __('Samstag', 'hz-opening-time'),
    'sun' => __('Sonntag', 'hz-opening-time'),
);

foreach ($weekdays as $key => $value) {
    ?>

    <div class="hz-opening-time-row">
        <div class="hz-opening-time-weekday">
            <label for="hz_opening_time_settings[<?php echo $key; ?>_closed]"><?php echo $value; ?></label>
        </div>
        <div class="hz-opening-time-closed timepicker form-control">
            <input class="timepicker form-control" type="checkbox" id="hz_opening_time_settings[<?php echo $key; ?>_closed]"
                name="hz_opening_time_settings[<?php echo $key; ?>_closed]" <?php checked(1, isset($settings[$key . '_closed']) ? $settings[$key . '_closed'] : 0, true); ?> value="1" />
            <label for="hz_opening_time_settings[<?php echo $key; ?>_closed]"><?php _e('Geschlossen', 'hz-opening-time'); ?></label>
        </div>
        <div class="hz-opening-time-hours timepicker form-control">
            <input class="timepicker form-control" type="time" id="hz_opening_time_settings[<?php echo $key; ?>_open]"
                name="hz_opening_time_settings[<?php echo $key; ?>_open]"
                value="<?php echo isset($settings[$key . '_open']) ? $settings[$key . '_open'] : ''; ?>" />
            <span> - </span>
            <input type="time" id="hz_opening_time_settings[<?php echo $key; ?>_close]"
                name="hz_opening_time_settings[<?php echo $key; ?>_close]"
                value="<?php echo isset($settings[$key . '_close']) ? $settings[$key . '_close'] : ''; ?>" />
        </div>
    </div>
    <?php
}
?>