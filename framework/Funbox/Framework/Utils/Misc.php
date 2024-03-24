<?php

namespace Funbox\Framework\Utils;

use Random\Randomizer;

class Misc
{
    public static function makeId(): int
    {
        $dti = new \DateTimeImmutable();
        $ts = $dti->getTimestamp();
        $string = str_split($ts);

        $r = new Randomizer();
        $result = implode('', $r->shuffleArray($string));

        return intval($result);
    }

    public static function jsonToPhpReturnedArray(string $json): string
    {
        $result = '<?php' . PHP_EOL;
        $result .= 'return [' . PHP_EOL;

        $l = mb_strlen($json, 'UTF-8');
        $text = mb_substr($json, 1, $l - 2);

        $text = mb_ereg_replace(': ', ' => ', $text);
        $text = mb_ereg_replace('{', '[', $text);
        $text = mb_ereg_replace('}', ']', $text);
        $text = mb_ereg_replace('\\\/', '/', $text);
        $text = "\t" . trim($text);

        $result .= $text . PHP_EOL;

        $result .= '];' . PHP_EOL;

        return $result;
    }
}