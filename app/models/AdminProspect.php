<?php


namespace PitouFW\Model;


class AdminProspect {
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_PENDING = 'pending';
    const STATUS_NEGOTIATING = 'negotiating';
    const STATUS_TO_REMIND = 'to_remind';
    CONST STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';

    const STATUS_THEME = [
        'incomplete' => 'secondary',
        'pending' => 'primary',
        'negotiating' => 'info',
        'to_remind' => 'warning',
        'accepted' => 'success',
        'declined' => 'danger'
    ];
    const STATUS_LABEL = [
        'incomplete' => 'Incomplete',
        'pending' => 'Pending',
        'negotiating' => 'Negotiating',
        'to_remind' => 'To remind',
        'accepted' => 'Accepted',
        'declined' => 'Declined'
    ];
}