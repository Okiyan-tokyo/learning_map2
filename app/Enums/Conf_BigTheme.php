<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Conf_BigTheme extends Enum
{
    const html_only = 1;
    const php_only = 2;
    const html_and_php = 3;
    const no_file = 4;

    // 日本語で表示した配列を返す
   static public function jpnDescription(){
        $jpn_descriptions=[
            "HTML",
            "PHP",
            "HTML/PHP両方",
            "作成しない"
        ];
        return $jpn_descriptions;
    }
}
