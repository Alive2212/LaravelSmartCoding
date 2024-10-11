<?php

namespace Alive2212\LaravelSmartCoding;

use Carbon\Carbon;

class LaravelSmartCoding
{
    /**
     * @param int $randomLen
     * @return int
     */
    public static function timeStampCode(int $randomLen = 8): int
    {
        return (Carbon::now()->timestamp * 10000) + rand(pow(10, $randomLen - 1), pow(10, $randomLen) - 1);
    }

    /**
     * @param int $input
     * @return string
     */
    public static function encodeToBase32(int $input): string
    {
        return base_convert($input, 10, 32);
    }

    /**
     * @param string $input
     * @return int
     */
    public static function decodeToBase32(string $input): int
    {
        return base_convert($input, 32, 10);
    }

    /**
     * @param int $randomByteLength
     * @return string
     */
    public static function hexUuid(int $randomByteLength = 3): string
    {
        // Get Timestamp ns
        $currentNanoSecond = (int)(microtime(true) * 1000000000);
        $currentNanoSecondHex = decHex($currentNanoSecond);
        $randomHex = substr(
            str_repeat('0',($randomByteLength * 2)-1) . dechex(mt_rand(0, pow(2, $randomByteLength*8)-1)),
            -($randomByteLength * 2)
        );
        $secondaryUuidHex = $currentNanoSecondHex . $randomHex;
        $checkSumHex = self::getChecksumFromHex($secondaryUuidHex);
        return $secondaryUuidHex . $checkSumHex;
//        return "0x" . $secondaryUuidHex . $checkSumHex;
    }

    /**
     * @param $str
     * @param int $fromBase
     * @param int $toBase
     * @return int|string
     */
    public static function str_baseConvert($str, $fromBase=10, $toBase=36) {
        $str = trim($str);
        if (intval($fromBase) != 10) {
            $len = strlen($str);
            $q = 0;
            for ($i=0; $i<$len; $i++) {
                $r = base_convert($str[$i], $fromBase, 10);
                $q = bcadd(bcmul($q, $fromBase), $r);
            }
        }
        else $q = $str;

        if (intval($toBase) != 10) {
            $s = '';
            while (bccomp($q, '0', 0) > 0) {
                $r = intval(bcmod($q, $toBase));
                $s = base_convert($r, 10, $toBase) . $s;
                $q = bcdiv($q, $toBase, 0);
            }
        }
        else $s = $q;

        return $s;
    }

    /**
     * @param string $secondaryUuidHex
     * @return string
     */
    public static function getChecksumFromHex(string $secondaryUuidHex): string
    {
        $summation = 0;
        for ($index = 0; $index < strlen($secondaryUuidHex); $index++) {
            $tmp = $secondaryUuidHex[$index];
            $summation += hexdec($tmp);
        }
        $summationSplit = $summation & 0xFFFF;
        return dechex($summationSplit ^ 0xFFFF);
    }
}
