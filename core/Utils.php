<?php

class Utils {

    // name      : defineLanguage
    // params    : array $__GET
    // desc      : Verify index 'lang' on $__GET and sets a $_SESSSION for it.
    public static function defineLanguage($__GET) {
        $lang = "pt";

        session_start();
        if (isset($_SESSION['lang'])) {
            $lang = $_SESSION['lang'];
        }

        if (array_key_exists("lang", $__GET)) {
            $lang = $__GET['lang'];

            if ($lang != "es" && $lang != "pt") {
                $lang = "pt";
            }
            
            $_SESSION['lang'] = $lang;
        }

        return $lang;
    }

    // name      : brFormat2SQLTimestamp
    // params    : string $str
    // desc      : Formats 'd/m/Y H:i:s' for 'Y-m-d H:i:s'
    public static function brFormat2SQLTimestamp($str) {
        $day = substr($str, 0, 2);
        $month = substr($str, 3, 2);
        $year = substr($str, 6, 4);

        $hour = substr($str, 11, 2);
        $minute = substr($str, 14, 2);
        $second = substr($str, 17, 2);

        return $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;
    }

    // name      : brFormat2SQLTimestamp
    // params    : string $str
    // desc      : Formats 'd/m/Y' for 'Y-m-d'
    public static function brFormat2SQLDate($str) {
        $str = self::brFormat2SQLTimestamp($str);

        return substr($str, 0, 10);
    }

    // name      : sqlTimestamp2BrFormat
    // params    : string $str
    // desc      : Formats 'Y-m-d H:i:s' for 'd/m/Y H:i:s'
    public static function sqlTimestamp2BrFormat($str) {
        $year = substr($str, 0, 4);
        $month = substr($str, 5, 2);
        $day = substr($str, 8, 2);

        $hour = substr($str, 11, 2);
        $minute = substr($str, 14, 2);
        $second = substr($str, 17, 2);

        return $day."/".$month."/".$year.' '.$hour.':'.$minute.':'.$second;
    }

    // name      : sqlDate2SimpleDate
    // params    : string $str
    // desc      : Formats 'Y-m-d H:i:s' for 'd/m/Y H:i:s' and cuts only the date.
    public static function sqlDate2SimpleDate($str) {
        $result = static::sqlTimestamp2BrFormat($str);

        return substr($result, 0, 10);
    }

    // name      : cleanString
    // params    : string $string
    // desc      : Remove non-letters and non-numbers caracters from a string.
    public static function cleanString($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
   
    }

    // name      : getBrazilStateName
    // params    : string $shortname
    // desc      : Returns full name of a Brazilian state by its shortname
    public static function getBrazilStateName($shortname) {
        switch($shortname) {
            case "AC": return "Acre";
            case "AL": return "Alagoas";
            case "AP": return "Amapá";
            case "AM": return "Amazonas";
            case "BA": return "Bahia";
            case "CE": return "Ceará";
            case "DF": return "Distrito Federal";
            case "ES": return "Espírito Santo";
            case "GO": return "Goiás";
            case "MA": return "Maranhão";
            case "MT": return "Mato Grosso";
            case "MS": return "Mato Grosso do Sul";
            case "MG": return "Minas Gerais";
            case "PA": return "Pará";
            case "PB": return "Paraíba";
            case "PR": return "Paraná";
            case "PE": return "Pernambuco";
            case "PI": return "Piauí";
            case "RJ": return "Rio de Janeiro";
            case "RN": return "Rio Grande do Norte";
            case "RS": return "Rio Grande do Sul";
            case "RO": return "Rondônia";
            case "RR": return "Roraima";
            case "SC": return "Santa Catarina";
            case "SP": return "São Paulo";
            case "SE": return "Sergipe";
            case "TO": return "Tocantins";
            case "ES": return "Estrangeiro";
        }

        return false;
    }

    // name      : getCountryName
    // params    : string $shortname
    // desc      : Returns full name of a country by its shortname (in English).
    public static function getCountryName($shortname) {

        switch ($shortname) {
            case "AF": return "Afghanistan";
            case "AL": return "Albania";
            case "DZ": return "Algeria";
            case "AS": return "American Samoa";
            case "AD": return "Andorra";
            case "AG": return "Angola";
            case "AI": return "Anguilla";
            case "AG": return "Antigua &amp; Barbuda";
            case "AR": return "Argentina";
            case "AA": return "Armenia";
            case "AW": return "Aruba";
            case "AU": return "Australia";
            case "AT": return "Austria";
            case "AZ": return "Azerbaijan";
            case "BS": return "Bahamas";
            case "BH": return "Bahrain";
            case "BD": return "Bangladesh";
            case "BB": return "Barbados";
            case "BY": return "Belarus";
            case "BE": return "Belgium";
            case "BZ": return "Belize";
            case "BJ": return "Benin";
            case "BM": return "Bermuda";
            case "BT": return "Bhutan";
            case "BO": return "Bolivia";
            case "BL": return "Bonaire";
            case "BA": return "Bosnia &amp; Herzegovina";
            case "BW": return "Botswana";
            case "BR": return "Brazil";
            case "BC": return "British Indian Ocean Ter";
            case "BN": return "Brunei";
            case "BG": return "Bulgaria";
            case "BF": return "Burkina Faso";
            case "BI": return "Burundi";
            case "KH": return "Cambodia";
            case "CM": return "Cameroon";
            case "CA": return "Canada";
            case "IC": return "Canary Islands";
            case "CV": return "Cape Verde";
            case "KY": return "Cayman Islands";
            case "CF": return "Central African Republic";
            case "TD": return "Chad";
            case "CD": return "Channel Islands";
            case "CL": return "Chile";
            case "CN": return "China";
            case "CI": return "Christmas Island";
            case "CS": return "Cocos Island";
            case "CO": return "Colombia";
            case "CC": return "Comoros";
            case "CG": return "Congo";
            case "CK": return "Cook Islands";
            case "CR": return "Costa Rica";
            case "CT": return "Cote D'Ivoire";
            case "HR": return "Croatia";
            case "CU": return "Cuba";
            case "CB": return "Curacao";
            case "CY": return "Cyprus";
            case "CZ": return "Czech Republic";
            case "DK": return "Denmark";
            case "DJ": return "Djibouti";
            case "DM": return "Dominica";
            case "DO": return "Dominican Republic";
            case "TM": return "East Timor";
            case "EC": return "Ecuador";
            case "EG": return "Egypt";
            case "SV": return "El Salvador";
            case "GQ": return "Equatorial Guinea";
            case "ER": return "Eritrea";
            case "EE": return "Estonia";
            case "ET": return "Ethiopia";
            case "FA": return "Falkland Islands";
            case "FO": return "Faroe Islands";
            case "FJ": return "Fiji";
            case "FI": return "Finland";
            case "FR": return "France";
            case "GF": return "French Guiana";
            case "PF": return "French Polynesia";
            case "FS": return "French Southern Ter";
            case "GA": return "Gabon";
            case "GM": return "Gambia";
            case "GE": return "Georgia";
            case "DE": return "Germany";
            case "GH": return "Ghana";
            case "GI": return "Gibraltar";
            case "GB": return "Great Britain";
            case "GR": return "Greece";
            case "GL": return "Greenland";
            case "GD": return "Grenada";
            case "GP": return "Guadeloupe";
            case "GU": return "Guam";
            case "GT": return "Guatemala";
            case "GN": return "Guinea";
            case "GY": return "Guyana";
            case "HT": return "Haiti";
            case "HW": return "Hawaii";
            case "HN": return "Honduras";
            case "HK": return "Hong Kong";
            case "HU": return "Hungary";
            case "IS": return "Iceland";
            case "IN": return "India";
            case "ID": return "Indonesia";
            case "IA": return "Iran";
            case "IQ": return "Iraq";
            case "IR": return "Ireland";
            case "IM": return "Isle of Man";
            case "IL": return "Israel";
            case "IT": return "Italy";
            case "JM": return "Jamaica";
            case "JP": return "Japan";
            case "JO": return "Jordan";
            case "KZ": return "Kazakhstan";
            case "KE": return "Kenya";
            case "KI": return "Kiribati";
            case "NK": return "Korea North";
            case "KS": return "Korea South";
            case "KW": return "Kuwait";
            case "KG": return "Kyrgyzstan";
            case "LA": return "Laos";
            case "LV": return "Latvia";
            case "LB": return "Lebanon";
            case "LS": return "Lesotho";
            case "LR": return "Liberia";
            case "LY": return "Libya";
            case "LI": return "Liechtenstein";
            case "LT": return "Lithuania";
            case "LU": return "Luxembourg";
            case "MO": return "Macau";
            case "MK": return "Macedonia";
            case "MG": return "Madagascar";
            case "MY": return "Malaysia";
            case "MW": return "Malawi";
            case "MV": return "Maldives";
            case "ML": return "Mali";
            case "MT": return "Malta";
            case "MH": return "Marshall Islands";
            case "MQ": return "Martinique";
            case "MR": return "Mauritania";
            case "MU": return "Mauritius";
            case "ME": return "Mayotte";
            case "MX": return "Mexico";
            case "MI": return "Midway Islands";
            case "MD": return "Moldova";
            case "MC": return "Monaco";
            case "MN": return "Mongolia";
            case "MS": return "Montserrat";
            case "MA": return "Morocco";
            case "MZ": return "Mozambique";
            case "MM": return "Myanmar";
            case "NA": return "Nambia";
            case "NU": return "Nauru";
            case "NP": return "Nepal";
            case "AN": return "Netherland Antilles";
            case "NL": return "Netherlands (Holland, Europe)";
            case "NV": return "Nevis";
            case "NC": return "New Caledonia";
            case "NZ": return "New Zealand";
            case "NI": return "Nicaragua";
            case "NE": return "Niger";
            case "NG": return "Nigeria";
            case "NW": return "Niue";
            case "NF": return "Norfolk Island";
            case "NO": return "Norway";
            case "OM": return "Oman";
            case "PK": return "Pakistan";
            case "PW": return "Palau Island";
            case "PS": return "Palestine";
            case "PA": return "Panama";
            case "PG": return "Papua New Guinea";
            case "PY": return "Paraguay";
            case "PE": return "Peru";
            case "PH": return "Philippines";
            case "PO": return "Pitcairn Island";
            case "PL": return "Poland";
            case "PT": return "Portugal";
            case "PR": return "Puerto Rico";
            case "QA": return "Qatar";
            case "ME": return "Republic of Montenegro";
            case "RS": return "Republic of Serbia";
            case "RE": return "Reunion";
            case "RO": return "Romania";
            case "RU": return "Russia";
            case "RW": return "Rwanda";
            case "NT": return "St Barthelemy";
            case "EU": return "St Eustatius";
            case "HE": return "St Helena";
            case "KN": return "St Kitts-Nevis";
            case "LC": return "St Lucia";
            case "MB": return "St Maarten";
            case "PM": return "St Pierre &amp; Miquelon";
            case "VC": return "St Vincent &amp; Grenadines";
            case "SP": return "Saipan";
            case "SO": return "Samoa";
            case "AS": return "Samoa American";
            case "SM": return "San Marino";
            case "ST": return "Sao Tome &amp; Principe";
            case "SA": return "Saudi Arabia";
            case "SN": return "Senegal";
            case "RS": return "Serbia";
            case "SC": return "Seychelles";
            case "SL": return "Sierra Leone";
            case "SG": return "Singapore";
            case "SK": return "Slovakia";
            case "SI": return "Slovenia";
            case "SB": return "Solomon Islands";
            case "OI": return "Somalia";
            case "ZA": return "South Africa";
            case "ES": return "Spain";
            case "LK": return "Sri Lanka";
            case "SD": return "Sudan";
            case "SR": return "Suriname";
            case "SZ": return "Swaziland";
            case "SE": return "Sweden";
            case "CH": return "Switzerland";
            case "SY": return "Syria";
            case "TA": return "Tahiti";
            case "TW": return "Taiwan";
            case "TJ": return "Tajikistan";
            case "TZ": return "Tanzania";
            case "TH": return "Thailand";
            case "TG": return "Togo";
            case "TK": return "Tokelau";
            case "TO": return "Tonga";
            case "TT": return "Trinidad &amp; Tobago";
            case "TN": return "Tunisia";
            case "TR": return "Turkey";
            case "TU": return "Turkmenistan";
            case "TC": return "Turks &amp; Caicos Is";
            case "TV": return "Tuvalu";
            case "UG": return "Uganda";
            case "UA": return "Ukraine";
            case "AE": return "United Arab Emirates";
            case "GB": return "United Kingdom";
            case "US": return "United States of America";
            case "UY": return "Uruguay";
            case "UZ": return "Uzbekistan";
            case "VU": return "Vanuatu";
            case "VS": return "Vatican City State";
            case "VE": return "Venezuela";
            case "VN": return "Vietnam";
            case "VB": return "Virgin Islands (Brit)";
            case "VA": return "Virgin Islands (USA)";
            case "WK": return "Wake Island";
            case "WF": return "Wallis &amp; Futana Is";
            case "YE": return "Yemen";
            case "ZR": return "Zaire";
            case "ZM": return "Zambia";
            case "ZW": return "Zimbabwe";
        }

        return false;
    }

    // name      : getImageResized
    // params    : string $imageFileName, int $width, int $height
    // desc      : Resizes and crop a image to the specified size, writes it
    //             on images folder and returns its URL.
    public static function getImageResized($imageFileName, $width, $height) {
        $originalImageFileName = $imageFileName;

        if (strlen($originalImageFileName) == 0 || $originalImageFileName == FILES_URL) {
            return "";
        }

        $file_headers = @get_headers($originalImageFileName);
        if($file_headers[0] == 'HTTP/1.0 404 Not Found') {
            return $originalImageFileName;
        }

        $imageFileName = substr($imageFileName, (strrpos($imageFileName, "/") + 1), strlen($imageFileName));

        $resizedImageFileName = $width."_".$height."-".$imageFileName;
        $resizedImagePath = FILES_DIR.$resizedImageFileName;

        if (file_exists($resizedImagePath)) {
            return FILES_URL.$resizedImageFileName;
        } else {
            // resize Image
            $im = false;
            $ini_filename = FILES_URL.$imageFileName;

            $file_exists = true;
            $file_headers = @get_headers($ini_filename);

            if ($file_headers[0] == 'HTTP/1.0 404 Not Found' || 
                $file_headers[0] == 'HTTP/1.1 404 Not Found') {
               $file_exists = false;
            }

            if ($file_exists && strlen($originalImageFileName) > 0) {
                $what = getimagesize($ini_filename);
                switch(strtolower($what['mime'])) {
                    case 'image/png':
                        $im = imagecreatefrompng($ini_filename);
                        break;
                    case 'image/jpeg':
                        $im = imagecreatefromjpeg($ini_filename);
                        break;
                    case 'image/gif':
                        $im = imagecreatefromgif($ini_filename);
                        break;
                    default: die();
                }

                if (!$im) {
                    return FILES_URL.$imageFileName;
                }
                $imageSize = getimagesize($ini_filename);
                if (!$imageSize) {
                    return FILES_URL.$imageFileName;
                }

                $ini_x_size = $imageSize[0];
                $ini_y_size = $imageSize[1];

                if ($ini_y_size < $height || $ini_x_size < $width) {
                    return FILES_URL.$imageFileName;
                }

                $heightRatio = $ini_y_size / $height;
                $widthRatio  = $ini_x_size /  $width;
             
                if ($heightRatio < $widthRatio) {
                    $optimalRatio = $heightRatio;
                } else {
                    $optimalRatio = $widthRatio;
                }

                $newHeight = $ini_y_size / $optimalRatio;
                $newWidth  = $ini_x_size  / $optimalRatio;

                $newIm = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresized($newIm, $im, 0, 0, 0, 0, $newWidth, $newHeight, $ini_x_size, $ini_y_size);

                $to_crop_array = array('x' =>0 , 'y' => 0, 'width' => $width, 'height'=> $height);
                $thumb_im = imagecrop($newIm, $to_crop_array);
                $result = imagejpeg($thumb_im, "uploads/".$resizedImageFileName, 100);

                return FILES_URL.$resizedImageFileName;
            } else {
                return FILES_URL.$imageFileName;
            }
        }
    }
}
