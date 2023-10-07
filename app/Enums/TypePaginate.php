<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TypePaginate extends Enum
{
    const FIVE = 5;
    const TEN = 10;
    const FIFFTY = 15;
    const TWENTY = 20;
}
