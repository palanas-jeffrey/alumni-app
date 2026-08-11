@php
    function numberToLetters($number) {
        $result = '';
        while ($number > 0) {
            $number--;
            $result = chr(65 + ($number % 26)) . $result;
            $number = intval($number / 26);
        }
        return strtolower($result);
    }
@endphp