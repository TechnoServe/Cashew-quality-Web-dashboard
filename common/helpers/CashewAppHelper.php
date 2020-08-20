<?php


namespace common\helpers;


use DateTime;
use kartik\mpdf\Pdf;
use Yii;
use function GuzzleHttp\Psr7\str;

class CashewAppHelper
{

    /**
     * Calculate date period from two dates
     * Groups by period
     * @param $startDate
     * @param $endDate
     */
    public static function getDatePeriodToFetch($startDate, $endDate){

        $daysDifference =  self::dateDiffInDays($startDate, $endDate);

        $daysGrouping = 0;
        if($daysDifference <= 31) {
            $daysGrouping = "day";
        }

        if($daysDifference  > 31 && $daysDifference <= 180) {
            $daysGrouping = "week";
        }

        if($daysDifference  > 180 && $daysDifference <= 1080) {
            $daysGrouping = "month";
        }

        if($daysDifference  > 1080) {
            $daysGrouping = "year";
        }

        return self::groupDateByPeriod($startDate, $endDate, $daysGrouping);

    }


    public static function groupDateByPeriod($startDate, $endDate, $daysGrouping){
        $rows = [];
        while (strtotime($startDate) <= strtotime($endDate)) {

            $next = date ("Y-m-d", strtotime("+1 ".$daysGrouping, strtotime($startDate)));

            $row = [
                "startDate" => $startDate,
                "endDate" => strtotime($startDate) <= strtotime($endDate) ? date ("Y-m-d", strtotime("-1 day", strtotime($next))) : $endDate,
                "groupedBy" => $daysGrouping == "day" ? Yii::t("app", "Day") :
                    ($daysGrouping == "week" ? Yii::t("app", "Week") :
                        ($daysGrouping == "month"  ? Yii::t("app", "Month") : Yii::t("app", "Year")))
            ];

            $row ["generic"] = $daysGrouping == "day" ? date ("d M,y", strtotime($row["startDate"])) : date ("d M,y", strtotime($row["startDate"])) . " - ".date ("d M,y", strtotime($row["endDate"]));;
            array_push($rows, $row);

            $startDate = $next;
        }
        return $rows;
    }

    /**
     * Calculate the date difference in days
     * @param $date1
     * @param $date2
     * @return float|int
     */
    public static function dateDiffInDays($date1, $date2)
    {
        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400)) + 1;
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @param null $predefinedPeriod
     * @return array|mixed
     */
    public static function calculateStartDateAndEndDateForAnalytics($startDate = null, $endDate = null, $predefinedPeriod=null){

        if(!$startDate   && $predefinedPeriod == 1)
            return self::calculateThisWeekDatePeriod();

        if(!$startDate   && $predefinedPeriod == 2)
            return self::calculateThisMonthDatePeriod();

        if(!$startDate && $predefinedPeriod == 3)
            return self::calculateThisQuarterDatePeriod();

        if(!$startDate && $predefinedPeriod == 4)
            return self::calculateThisYearDatePeriod();

        if($startDate && !$endDate)
            return [$startDate, date("Y-m-d", strtotime("now"))];

        if($startDate && $endDate)
            return  [$startDate, $endDate];

        // Weekly is default
        return self::calculateThisWeekDatePeriod();
    }


    /**
     * @return mixed
     */
    public static function calculateThisWeekDatePeriod(){
        $dto = new DateTime();
        $dto->setISODate(date("Y", strtotime('now')), date("W", strtotime('now')));
        $ret[0] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret[1] = $dto->format('Y-m-d');
        return $ret;

    }

    /**
     * @return array
     */
    public static function calculateThisMonthDatePeriod(){
        $currentMonth = date ("m", strtotime("now"));
        $currentYear = date ("Y", strtotime("now"));
        return [
            date("Y-m-d", strtotime($currentYear . "-" .$currentMonth . "-01")),
            date("Y-m-t", strtotime($currentYear . "-" .$currentMonth . "-01"))
        ];
    }

    /**
     * @return array
     */
    public static function calculateThisQuarterDatePeriod(){
        $currentMonth = date ("m", strtotime("now"));
        $currentYear = date ("Y", strtotime("now"));
        $yearQuarter = ceil($currentMonth / 3);

        $firstMonthOfTheQuarter = ($yearQuarter * 3 - 3) + 1;

        return  [
            date("Y-m-d", strtotime($currentYear . "-". $firstMonthOfTheQuarter ."-01")),
            date("Y-m-t", strtotime($currentYear . "-" .($firstMonthOfTheQuarter+2). "-01"))
        ];
    }

    /**
     * @return array
     */
    public static function calculateThisYearDatePeriod(){
        $currentYear = date ("Y", strtotime("now"));
        return [
            date("Y-m-d", strtotime($currentYear . "-01-01")),
            date("Y-m-t", strtotime($currentYear . "-12-01"))
        ];
    }

    public static function createFolderIfNotExist($path)
    {
        if ( ! file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }


    public static function groupAssArrayBy($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


   public static function searchForValueInArray($key, $array) {
        foreach ($array as $measurement) {
            if ($measurement["key"] == $key) {
                return $measurement;
            }
        }
        return null;
    }


    /**
     * Used to render pdf and send as downloadable in browser
     * @param $content
     * @param string $format
     * @param string $orientation
     * @param null $css
     * @param null $marginOptions
     * @param null $filename
     *
     * @return mixed
     */
    public static function renderPDF($content, $format = Pdf::FORMAT_A4, $orientation = Pdf::ORIENT_LANDSCAPE, $css = null, $marginOptions = null, $filename = null) {
        error_reporting(0);
        $options = [
            'mode' => Pdf::MODE_UTF8,
            'filename' => $filename,
            'format' => $format,
            'orientation' => $orientation,
            'destination' => Pdf::DEST_DOWNLOAD,
            'content' => $content,
            'cssFile' => '@backend/web/css/pdf.css',
            'cssInline' => $css,
            'methods' => [
                'SetFooter' => ['{PAGENO}'],
            ],
            'options' => [
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
            ],
        ];

        if (is_array($marginOptions)) {
            $options = array_merge($options, $marginOptions);
        }

        $pdf = new Pdf($options);

        return $pdf->render();
    }

    /**
     * Return list of countries
     * @return string[]
     */
    public static function getListOfCountries(){
        return [
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        ];
    }
}