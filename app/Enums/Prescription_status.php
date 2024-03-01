<?php

namespace App\Enums;

enum Prescription_status: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

}

