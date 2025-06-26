<?php

use Carbon\Carbon;

if (! function_exists('swap')) {
    function swap($first, $second, $callback)
    {
        if ($callback($first, $second)) {
            return [$second, $first];
        }

        return [$first, $second];
    }
}

if (! function_exists('convertToBytes')) {

    function convertToBytes($string)
    {
        $string = trim($string);
        $lastChar = strtolower($string[strlen($string) - 1]);
        $base = (int) $string;

        switch ($lastChar) {
            case 'g':
                $base *= 1024;
            case 'm':
                $base *= 1024;
            case 'k':
                $base *= 1024;
        }

        return $base;
    }
}

if (! function_exists('generate_unique_id')) {
    function generate_unique_id($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $uniqueId = Carbon::now()->format('ymd');
        for ($i = 0; $i < $length; $i++) {
            $uniqueId .= $characters[rand(0, $charactersLength - 1)];
        }

        return $uniqueId;
    }
}

if (! function_exists('getBrowserInfo')) {
    function getBrowserInfo($userAgent)
    {
        $name = 'Unknown';
        $version = 'Unknown';

        if (strpos($userAgent, 'Chrome') !== false) {
            $name = 'Chrome';
            preg_match('/Chrome\/(\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $name = 'Firefox';
            preg_match('/Firefox\/(\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $name = 'Safari';
            preg_match('/Safari\/(\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'Edg') !== false) {
            $name = 'Edge';
            preg_match('/Edg\/(\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'MSIE') !== false) {
            $name = 'IE';
            preg_match('/MSIE (\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'Trident') !== false) {
            $name = 'IE';
            preg_match('/rv:(\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        }

        return [
            'name' => $name,
            'version' => $version,
        ];
    }
}

if (! function_exists('getOSinfo')) {
    function getOSinfo($userAgent)
    {
        $name = 'Unknown';
        $version = 'Unknown';

        if (strpos($userAgent, 'Win') !== false) {
            $name = 'Windows';
            preg_match('/Windows NT (\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $name = 'MacOS';
            preg_match('/Mac OS X (\d+_\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = str_replace('_', '.', $matches[1]);
            }
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $name = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $name = 'Android';
            preg_match('/Android (\d+\.\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = $matches[1];
            }
        } elseif (strpos($userAgent, 'like Mac') !== false) {
            $name = 'iOS';
            preg_match('/CPU iPhone OS (\d+_\d+)/', $userAgent, $matches);
            if (isset($matches[1])) {
                $version = str_replace('_', '.', $matches[1]);
            }
        }

        return ['name' => $name, 'version' => $version];
    }
}

if (! function_exists('calculate_percentage_amount')) {
    function calculate_percentage_amount($amount, $percentage)
    {
        if (! is_numeric($amount) || ! is_numeric($percentage)) {
            return null;
        }
        $percentageAmount = ($amount * $percentage) / 100;

        return $percentageAmount;
    }
}

if (! function_exists('calculate_price')) {
    function calculate_price($price, $adminCommissionRate)
    {
        $price['admin_commission'] = calculate_percentage_amount($price['unit_amount'], $adminCommissionRate);
        if ($price['is_affiliate_percent']) {
            $price['affiliate_commission'] = calculate_percentage_amount(($price['unit_amount'] - $price['admin_commission']), $price['affiliate_commission']);
        }

        $price['seller_amount'] = $price['unit_amount'] - $price['admin_commission'];

        return $price;
    }
}


if (! function_exists('get_last_twelve_month_names')) {
    function get_last_twelve_month_names(?string $date = null, $format = 'M')
    {
        $date = $date ?? now();
        Carbon::setlocale(config('app.locale'));
        $month_names = [
            ucfirst((new Carbon($date))->translatedFormat($format)),
        ];
        for ($i = 1; $i <= 11; $i++) {
            $month_names[$i] = ucfirst((new Carbon($date))->subMonths($i)->translatedFormat($format));
        }

        return array_reverse($month_names);
    }
}

if (! function_exists('get_last_n_date')) {
    function get_last_n_date(?string $date = null, int $n = 30, string $format = 'd')
    {
        $date = $date ?? now();
        Carbon::setLocale(config('app.locale'));
        $dates = [
            (new Carbon($date))->format($format),
        ];

        for ($i = 1; $i < $n; $i++) {
            $dates[$i] = (new Carbon($date))->subDays($i)->format($format);
        }

        return array_reverse($dates);
    }
}
