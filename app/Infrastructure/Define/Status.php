<?php

namespace App\Infrastructure\Define;

class Status {

    //Medical Registration Form
    const WAITING_FOR_HEALTH_CHECK = "waiting";
    const HEALTH_CHECKING = "checking";
    const COMPLETE_HEALTH_CHECK = "complete";
    const CANCEL_HEALTH_CHECKING = "cancel";
    const UNPAID = "unpaid";
    const PAID = "paid";
}