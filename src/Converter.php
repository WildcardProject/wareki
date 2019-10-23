<?php
namespace programming_cat\Wareki;

use Closure;

class Converter
{
    function wareki($src) {
        if (preg_match('/^[1-9][0-9]{3}$/', $src)) {
            $year = $src;

            if ($year < 1869) {
                throw new Exceptions\TooOldYearException("入力値が古すぎます。江戸時代か！");
            }
            elseif ($year >= 2019) {
                $gengo = '令和';
                $wayear = $year - 2018;
                // 令和だけ並列で
                if ($year == 2019) {
                    return "令和元年/平成31年";
                }
            }
            elseif ($year >= 1989) {
                $gengo = '平成';
                $wayear = $year - 1988;
            }
            elseif ($year >= 1926) {
                $gengo = '昭和';
                $wayear = $year - 1925;
            }
            elseif ($year >= 1912) {
                $gengo = '大正';
                $wayear = $year - 1911;
            }
            else {
                $gengo = '明治';
                $wayear = $year - 1868;
            }

            return $gengo . ($wayear==1 ? "元" : $wayear) . "年";
        }
        else {
            $_time = strtotime($src);
            if ($_time === FALSE) {
                throw new Exceptions\InvalidArgumentException("入力値が不正です $src $_time");
            }
            $year = date('Y', $_time);
            $date = date('Ymd', $_time);

            if ($date >= 20190501) {
                $gengo = '令和';
                $wayear = $year - 2018;
            }elseif ($date >= 19890108) {
                $gengo = '平成';
                $wayear = $year - 1988;
            } elseif ($date >= 19261225) {
                $gengo = '昭和';
                $wayear = $year - 1925;
            } elseif ($date >= 19120730) {
                $gengo = '大正';
                $wayear = $year - 1911;
            } else {
                $gengo = '明治';
                $wayear = $year - 1868;
            }

            return $gengo . ($wayear==1 ? "元" : $wayear) . "年" . date('n月j日', $_time);

        }
    }
    function seireki($src, $format="Y/m/d") {
        $a = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $g = mb_substr($src, 0, 2, 'UTF-8');
        array_unshift($a, $g);
        if (($g !== '明治' && $g !== '大正' && $g !== '昭和' && $g !== '平成'&& $g !== '令和') ||
            (str_replace($a, '', $src) !== '年月日' && str_replace($a, '', $src) !== '元年月日')
        ) {
            return false;
        }
        $y = strtok(str_replace($g, '', $src), '年月日');
        $m = strtok('年月日');
        $d = strtok('年月日');
        if (mb_strpos($src, '元年') !== false) {
            $y = 1;
        }
        if ($g === '令和') {
            $y += 2018;
        }
        elseif ($g === '平成') {
            $y += 1988;
        }
        elseif ($g === '昭和') {
            $y += 1925;
        }
        elseif ($g === '大正') {
            $y += 1911;
        }
        elseif ($g === '明治') {
            $y += 1868;
        }
        if (strlen($y) !== 4 || strlen($m) !== 2 || strlen($d) !== 2 || !@checkdate($m, $d, $y)) {
            return false;
        }
        return date($format, mktime(0,0,0, $m, $d, $y));
    }
}
