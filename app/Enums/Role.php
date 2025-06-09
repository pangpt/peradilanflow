<?php

namespace App\Enums;

enum Role: int
{
    case CONTRIBUTOR = 0;
    case EDITOR = 1;
    case ADMIN = 9;
}
