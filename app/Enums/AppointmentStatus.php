<?php 

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AppointmentStatus extends Enum
{
    const SCHEDULED = 1;
    const CONFIRMED = 2;
    const CANCELLED = 3;

    public function color(): string
    {
        return match ($this->value) {
            AppointmentStatus::SCHEDULED => 'primary',
            AppointmentStatus::CONFIRMED => 'success',
            AppointmentStatus::CANCELLED => 'danger',
        };
    }
}

