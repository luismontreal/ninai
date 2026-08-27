<?php

namespace App\Enums;

enum ResponseStatus: string
{
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Abandoned = 'abandoned';
}
