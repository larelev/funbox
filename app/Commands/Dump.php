<?php

namespace App\Commands;

use Funbox\Framework\Caching\Cache;
use Funbox\Framework\Console\Commands\Attributes\Command;
use Funbox\Framework\Console\Commands\CommandInterface;
use Funbox\Framework\Routing\RoutesAggregator;

#[Command(name: "dump")]
#[Command(desc: "Converts a JSON dump to a PHP returned array.")]
class Dump implements CommandInterface
{
    public const CONVERTED_ARRAY_PATH = Cache::CACHE_PATH . 'converted.txt';
    public const COMPOSER_JSON_PATH = Cache::CACHE_PATH . 'composer.json';
    public const BUFFER_PATH = Cache::CACHE_PATH . 'buffer.txt';
    public const DUMP_PATH = Cache::CACHE_PATH . 'dump.txt';
    public const INDENTS_PATH = Cache::CACHE_PATH . 'indents.txt';

    public function execute(array $params = []): int
    {
        // $json = file_get_contents(self::COMPOSER_JSON_PATH);
        $json = file_get_contents(RoutesAggregator::ROUTES_JSON_PATH);
        $array = json_decode($json, JSON_OBJECT_AS_ARRAY);

        $converted = $this->convert($array);

        file_put_contents(self::CONVERTED_ARRAY_PATH, $converted);

        return 0;
    }

    private function convert(mixed $array): string
    {
        $dump = $this->var_dump_r($array);

        $indentsLengths = [];
        $convert = '';

        $re = '/(.*)(\[[\w"-\/\\\\]+\]=>)(\n)( +)/';
        $subst = "$1$2";
        $entries = preg_replace($re, $subst, $dump);
        $buffer = $entries;
        $offset = 0;

        file_put_contents(self::DUMP_PATH, $entries);

        $re = '/^( ?+)+/m';
        preg_match_all($re, $entries, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            $indentsLengths[] = count($match) > 1 ? strlen($match[0]) : 0;
        }

        $l = count($indentsLengths);
        for ($i = 0; $i < $l; $i++) {
            $indentLen = $indentsLengths[$i];
            $indent = $indentLen > 0 ? str_repeat(' ', $indentLen) : '';
            $entryRx = '/( ?+)+(\[([\w"-\/\\\\]+)\]=>)?((array|string|int|float|bool)\(([\w.]+)\) ?(.*)\n)/';
            $closeArrayRx = '/^( ?+)+}/';

            if (preg_match($closeArrayRx, $buffer, $matches)) {
                $convert .= $indent . ']' . ($indent == '' ? '' : ',');
                $convert .= PHP_EOL;
                $stringLen = strlen($matches[0]) + 1;
                $buffer = substr($buffer, $stringLen);
                $offset += $stringLen;
            } else if (preg_match($entryRx, $buffer, $matches)) {
                $convert .= $indent;
                if ($matches[5] == 'array') {
                    $convert .= '[';
                    $stringLen = strlen($matches[0]) + 1;
                    $buffer = substr($buffer, $stringLen);
                    $offset += $stringLen;
                } else if ($matches[5] == 'string') {
                    $len = $matches[6];
                    $token = "string($len)";
                    $lenToken = strlen($token);
                    $posToken = strpos($matches[0], $token);
                    $start = $posToken + $lenToken + 2;

                    $value = substr($entries, $offset + $start, $len);
                    $quote = substr($value, 0, 8) == 'function' ? '' : "'";
                    $value = $quote == '' ? $value : str_replace("\\", "\\\\", $value);

                    if ($j = substr_count($value, PHP_EOL)) {
                        $i += $j;
                        echo print_r($j, true) . PHP_EOL;
                    }
                    if (str_starts_with($matches[3], '"')) {
                        $key = "'" . trim($matches[3], '"') . "'";
                        $key = str_replace("\\", "\\\\", $key);
                        $convert .= $key . " => $quote" . $value . "$quote,";
                    } else {
                        $convert .= "$quote" . $value . "$quote,";
                    }

                    $stringLen = $start + $len + 2;
                    $buffer = substr($buffer, $stringLen);
                    $offset += $stringLen;
                } else {
                    if (str_starts_with($matches[3], '"')) {
                        $key = "'" . trim($matches[3], '"') . "'";
                        $key = str_replace("\\", "\\\\", $key);
                        $convert .= $key . " => " . $matches[6] . ",";
                    } else {
                        $convert .= $matches[6] . ',';
                    }
                    $stringLen = strlen($matches[0]) + 1;
                    $buffer = substr($buffer, $stringLen);
                    $offset += $stringLen;
                }
                $convert .= PHP_EOL;

                file_put_contents(self::CONVERTED_ARRAY_PATH, $convert);
                file_put_contents(self::BUFFER_PATH, $buffer);
                file_put_contents(self::INDENTS_PATH, implode(PHP_EOL, $indentsLengths));

            }
        }

        return $convert;
    }

    private function var_dump_r(mixed $value)
    {
        ob_start();
        var_dump($value);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
