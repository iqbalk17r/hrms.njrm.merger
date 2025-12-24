<?php

class GeneratePassword
{
    function sidia($vc_jwb, $vl_dcd) {
        $fkt = 1;
        $jwb1 = '';
        $dsc1 = '902451387651497';
        $vc_jwb = substr($vc_jwb . '               ', 0, 15);
        $fkt = (!$vl_dcd ? -1 : $fkt);
        for ($ctr = 0; $ctr < strlen($vc_jwb); $ctr++) {
            $tmp1 = $vc_jwb[$ctr];
            $tmp2 = ord($tmp1) + ((ord($dsc1[$ctr]) - 35) * $fkt);
            $jwb1 .= chr($tmp2);
        }
        return $jwb1;
    }

    /*function hideString($input, $options = array()) {
//      $hiddenStringPartial = hideString($inputString, ['setting' => 'partial', 'length' => 5]);
        $setting = 'partial';
        $length = '5' ;
        switch ($setting) {
            case 'all':
                // Replace all characters with asterisks
                return str_repeat('*', strlen($input));
            case 'partial':
                // Replace only some characters (e.g., first and last) with asterisks
                $length = $length ?? strlen($input);
                if ($length <= 2) {
                    return $input; // Too short to hide anything
                }
                return $input[0] . str_repeat('*', $length - 2) . $input[$length - 1];
            default:
                return $input; // Default: no change
        }
    }*/
}