<?php

// Helper function to generate the opening hours string
function hz_get_opening_hours_string()
{
    $settings = get_option('hz_opening_time_settings');
    $weekdays = array(
        'mon' => __('Mo', 'hz-opening-time'),
        'tue' => __('Di', 'hz-opening-time'),
        'wed' => __('Mi', 'hz-opening-time'),
        'thu' => __('Do', 'hz-opening-time'),
        'fri' => __('Fr', 'hz-opening-time'),
        'sat' => __('Sa', 'hz-opening-time'),
        'sun' => __('So', 'hz-opening-time'),
    );
    $output = array();
    $current_group = array();
    $previous_day = '';

    foreach ($weekdays as $key => $day) {
        $closed = isset($settings[$key . '_closed']) ? $settings[$key . '_closed'] : false;
        $open_time = isset($settings[$key . '_open']) ? $settings[$key . '_open'] : '';
        $close_time = isset($settings[$key . '_close']) ? $settings[$key . '_close'] : '';

        if ($closed || !$open_time || !$close_time) {
            if ($current_group) {
                $output[] = hz_format_opening_hours_group($previous_day, $current_group);
                $current_group = array();
            }
            continue;
        }

        if ($settings[$key . '_closed'] || !$settings[$key . '_open'] || !$settings[$key . '_close']) {
            if ($current_group) {
                $output[] = hz_format_opening_hours_group($previous_day, $current_group);
                $current_group = array();
            }
            continue;
        }

        if ($current_group && (end($current_group)['open'] !== $settings[$key . '_open'] || end($current_group)['close'] !== $settings[$key . '_close'])) {
            $output[] = hz_format_opening_hours_group($previous_day, $current_group);
            $current_group = array();
        }

        $current_group[] = array(
            'day' => $day,
            'open' => $settings[$key . '_open'],
            'close' => $settings[$key . '_close'],
        );
        $previous_day = $key;
    }

    if ($current_group) {
        $output[] = hz_format_opening_hours_group($previous_day, $current_group);
    }

    return implode(', ', $output);
}

// Helper function to format opening hours group
function hz_format_opening_hours_group($previous_day, $group)
{
    $start_day = reset($group)['day'];
    $end_day = end($group)['day'];
    $range = count($group) > 1 ? $start_day . '-' . $end_day : $start_day;
    return $range . ' ' . reset($group)['open'] . '-' . reset($group)['close'] . ' Uhr';
}

// Helper function to generate the opening status string based on current Vienna time
function hz_get_opening_status_string()
{
    $settings = get_option('hz_opening_time_settings');
    date_default_timezone_set('Europe/Vienna');
    $current_time = time();
    $current_weekday = strtolower(date('D', $current_time));
    $current_hour = date('H:i', $current_time);

    if ($settings[$current_weekday . '_closed'] || !$settings[$current_weekday . '_open'] || !$settings[$current_weekday . '_close']) {
        return "<div class='openingtime_now closed_now'>" . __('geschlossen', 'hz-opening-time') . "</div>";
    }

    $open_time = strtotime($settings[$current_weekday . '_open']);
    $close_time = strtotime($settings[$current_weekday . '_close']);

    if ($current_time >= $open_time && $current_time <= $close_time) {
        return "<div class='openingtime_now open_now'>" . __('jetzt geöffnet', 'hz-opening-time') . "</div>";
    } elseif ($current_time >= $open_time - 3600 && $current_time < $open_time) {
        return "<div class='openingtime_now open_soon'>" . __('öffnet demnächst', 'hz-opening-time') . "</div>";
    } elseif (
        $current_time > $close_time - 3600 &&
        $current_time <= $close_time
    ) {
        return "<div class='openingtime_now closed_soon'>" . __('schließt demnächst', 'hz-opening-time') . "</div>";
    } else {
        return "<div class='openingtime_now closed_now'>" . __('geschlossen', 'hz-opening-time') . "</div>";
    }
}