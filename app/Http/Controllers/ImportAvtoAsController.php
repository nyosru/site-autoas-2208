<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Catalog;
use App\Models\Good;
use App\Models\GoodAnalog;

use Nyos\Msg;

class ImportAvtoAsController extends Controller
{
    /**
     * импорт дата файла
     * @return \Illuminate\Http\Response
     */
    public function import()
    {

        $ee = self::parsingXml();

        $msg = '';

        if (!empty($ee['cats'])) {
            Catalog::truncate();
            Catalog::insert($ee['cats']);
            $msg .= 'Каталогов: ' . sizeof($ee['cats']) . PHP_EOL;
        }
        // $ee2 = Catalog::truncate()->insert($ee['cats']);
        // dd( $ee2,  $ee1 ?? 'x');

        // 'cats' => $cats ?? [],
        // 'items' => $items ?? [],
        // 'analogs' => $analogs ?? [],

        if (!empty($ee['items'])) {
            // echo '<pre>', print_r($ee['items']), '</pre>';
            Good::truncate();
            foreach (array_chunk($ee['items'], 1000) as $t) {
                // DB::table('tsim')->insert($t);
                Good::insert($t);
            }
            // Good::insert($ee['items']);
            $msg .= 'Товаров: ' . sizeof($ee['items']) . PHP_EOL;
        }

        if (!empty($ee['analogs'])) {
            GoodAnalog::truncate();
            // GoodAnalog::insert($ee['analogs']);
            foreach (array_chunk($ee['analogs'], 1000) as $t) {
                // DB::table('tsim')->insert($t);
                GoodAnalog::insert($t);
            }
            $msg .= 'и связей для Аналогов: ' . sizeof($ee['analogs']) . PHP_EOL;
        }

        // 360209578, // я
        // e.push(1022228978)
        // // Денис Авто-СА
        // sendTo.value.push(663501687)

        Msg::$admins_id = [
            1022228978, // AvtoAs
            663501687, //Денис Авто-СА
        ];
        Msg::sendTelegramm('Обработан импорт данных' . PHP_EOL . $msg, null, 2);

        return '<pre>' . 'Обработан импорт данных' . PHP_EOL . $msg . '</pre>';
        // return Storage::exists('import1c/AllCatalog.xml') ? 1 : 2;

        // $file = $_SERVER['DOCUMENT_ROOT'] . '/public/import-1c/files/AllCatalog.xml';
        // return (file_exists($file)) ? 1 : 2 . $_SERVER['DOCUMENT_ROOT'];
    }


    /**
     *
     * @param string $cyr_str
     * @param string $type uri - замена знаков препинания и прочих скобок на пусто и подчёркивание
     * uri2 - значкки в пустои п одчёркивание буквы в транслит
     * cifr - только цифры на выходе
     * cifr2 - только цифры, вместо запятой точка
     * cifr21 - только цифры, вместо запятой точка, округлено до целых в большую сторону
     * иначе просто транслит
     * @return string
     */
    public static function translit($cyr_str = '', $type = false)
    {

        if (empty($cyr_str))
            return '';

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;
            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if ($type == 'uri') {
            $cyr_str = strtolower($cyr_str);
            $tr = array(
                '"' => '',
                '\'' => '',
                '-' => '_',
                '(' => '',
                ')' => '',
                '|' => '',
                '.' => '_',
                ' ' => '_',
                '#' => '',
                '№' => '',
                '”' => ''
            );


            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return strtr($cyr_str, $tr);
        } elseif ($type == 'uri2') {
            //echo $cyr_str.' -- ';
            $cyr = mb_strtolower($cyr_str, 'UTF-8');
            $tr = array(
                '"' => '',
                '\'' => '',
                '/' => '',
                ' ' => '_',
                '-' => '_',
                '[' => '',
                ']' => '',
                ',' => '_',
                '(' => '',
                ')' => '',
                '|' => '',
                '.' => '_',
                '”' => '',
                //'q' => 'q',
                //'a' => 'a',
                //'z' => 'z',
                //'w' => 'w',
                //'s' => 's',
                //'x' => 'x',
                //'e' => 'e',
                //'d' => 'd',
                //'c' => 'c',
                //'r' => 'r',
                //'f' => 'f',
                //'v' => 'v',
                //'t' => 't',
                //'g' => 'g',
                //'b' => 'b',
                //'y' => 'y',
                //'h' => 'h',
                //'n' => 'n',
                //'u' => 'u',
                //'j' => 'j',
                //'m' => 'm',
                //'i' => 'i',
                //'k' => 'k',
                //'o' => 'o',
                //'l' => 'l',
                //'p' => 'p',
                "а" => "a", "б" => "b", "в" => "v", "г" => "g",
                "д" => "d", "е" => "e", "ж" => "zh",
                "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
                "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
                "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
                "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
            );
            //echo $cyr.' == ';
            //echo strtr($cyr,$tr).'<br/>';

            $c = preg_replace('/[^a-zA-Z0-9_]/', '', mb_strtolower(strtr($cyr, $tr)));

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return $c;
        } elseif ($type == 'cifr') {
            //echo $cyr_str.' -- ';

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return preg_replace('/[^0-9]/', '', $cyr_str);
        } elseif ($type == 'cifr2') {
            //echo $cyr_str.' -- ';
            $e = preg_replace('/[^0-9,.]/', '', $cyr_str);

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return str_replace(",", ".", $e);
        } elseif ($type == 'cifr21') {
            //echo $cyr_str.' -- ';
            $e = preg_replace('/[^0-9,.]/', '', $cyr_str);

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return ceil(str_replace(",", ".", $e));
        } elseif ($type == 'uri3') {
            $tr = array(
                ' ' => '', "Ґ" => "G", "Ё" => "YO", "Є" => "E", "Ї" => "YI", "І" => "I", "і" => "i", "ґ" => "g", "ё" => "yo", "№" => "", "є" => "e",
                "ї" => "yi", "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I",
                "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
                "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH", "Ш" => "SH", "Щ" => "SCH", "Ъ" => "'", "Ы" => "YI", "Ь" => "",
                "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "zh",
                "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
                "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
            );

            $c = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', strtr($cyr_str, $tr)));

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return $c;
        } else {
            $tr = array(
                ' ' => '_', "Ґ" => "G", "Ё" => "YO", "Є" => "E", "Ї" => "YI", "І" => "I", "і" => "i", "ґ" => "g", "ё" => "yo", "№" => "#", "є" => "e",
                "ї" => "yi", "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I",
                "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
                "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH", "Ш" => "SH", "Щ" => "SCH", "Ъ" => "'", "Ы" => "YI", "Ь" => "",
                "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "zh",
                "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "'",
                "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
            );

            $c = preg_replace('/[^a-zA-Z0-9_]/', '', strtr(strtolower($cyr_str), $tr));

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return $c;
        }
    }

    public static function parsingXml($file = 'AllCatalog.xml')
    {

        if (!Storage::exists('import1c/' . $file))
            return 'файла данных не обнаружено';

        // $files = Storage::files('import1c');
        $fileImport = Storage::path('import1c/' . $file);
        // dd($files);
        // $contents = Storage::get('file.jpg');


        //     // /**
        //     //  * сканим новый файл данных
        //     //  * @param type $db
        //     //  * @return json
        //     //  */
        //     // public static function scanNewDataFile($db, $folder) {

        //         $sc = DR . DS . 'sites' . DS . (!empty($folder) ? $folder . '/' : '' ) . 'download' . DS . '1c.dump' . DS;

        //         if (!is_dir($sc))
        //             throw new \Exception('нет папки ' . $sc, 1);

        //         $analogs = $cats = $items = [];

        //         $data_file = '';

        //         // сканим папку с файлами и ищем новый
        //         if (1 == 1) {

        //             $sc_scan = scandir($sc);

        //             if (!empty($_REQUEST['show1']))
        //                 \f\pa($sc_scan, 2, '', 'список дата файлов');

        //             $start1 = false;

        //             foreach ($sc_scan as $k => $file) {

        //                 if (strpos($file, '.old.') !== false)
        //                     continue;

        //                 if (strpos($file, '.xml') !== false) {

        $start1 = true;
        // $data_file = $file;
        $data_file = $fileImport;
        $est_xml_file = true;

        $reader = new \XMLReader();

        // if (!$reader->open($sc . $file))
        if (!$reader->open($fileImport))
            // throw new \Exception('Failed to open ' . $sc . $file);
            throw new \Exception('Failed to open ' . $fileImport);

        $d = ['id' => 0, 'parentId' => 0, 'name' => 'head'];
        $d_item = ['id' => 0, 'categoryId' => 0, 'price' => 0, 'in_stock' => 0];

        $analogs = $cats = $items = [];

        while ($reader->read()) {

            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'category') {

                $d1 = [
                    'head' => '',
                    'a_id' => '',
                    'a_parentid' => '',
                ];
                $node = (array) new \SimpleXMLElement($reader->readOuterXML());

                if (!empty($node['@attributes']))
                    foreach ($node['@attributes'] as $k1 => $v1) {
                        if (!empty($v1)) {

                            if ($k1 == 'name') {
                                $d1['head'] = $v1;
                                // echo '<br/>'.$v1;
                            } else {
                                $d1['a_' . strtolower($k1)] = $v1;
                            }
                        }
                    }
                $cats[] = $d1;
            }
            //
            elseif ($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'item') {

                // Insert value list does not match column list: 
                // 1136 Column count doesn't match value count at row 4 (SQL: insert into `mod_021_items` 
                // (`a_arrayimage`, `a_categoryid`, 
                // `a_catnumber`, `a_id`, 
                // `a_in_stock`, `a_price`, 
                // `catnumber_search`, `comment`, 
                // `country`, `head`, 
                // `manufacturer`
                // ) values (
                // PSE10666.jpg, ЦБ002170,
                //  PSE10666, ЦБ000124,
                //   , ,
                //    pse10666, ,
                //     Китай, Сайлентблок нижнего рычага,
                //      Patron
                //     ), (4059253

                $d1 = [
                    // 'a_arrayimage' => '',
                    // 'a_categoryid' => '',
                    // 'a_catnumber' => '',
                    // // 'a_countrymanuf' => '',
                    // 'a_id' => '',
                    // 'catnumber_search' => '',
                    // 'head' => '',
                    // 'manufacturer' => '',
                    // 'country' => '',
                    // 'comment' => '',
                    // // 'id'
                    // 'a_price' => '',
                    // 'a_in_stock' => '',
                    'head' => '',
                    'a_id' => '',
                    'a_categoryid' => '',
                    'a_catnumber' => '',
                    'catnumber_search' => '',
                    'a_price' => '',
                    'a_in_stock' => '',
                    'a_arrayimage' => '',
                    'country' => '',
                    'manufacturer' => '',
                    'comment' => '',
                ];

                $node = (array) new \SimpleXMLElement($reader->readOuterXML());

                if (!empty($node['name'])) {

                    // if (!empty($_REQUEST['show_parse_item'])) {

                    //     if (!isset($nn_show_parse_item)) {
                    //         $nn_show_parse_item = 0;
                    //     } else {
                    //         $nn_show_parse_item++;
                    //     }

                    //     if (
                    //         $nn_show_parse_item <= 50
                    //         // && !empty($node['@attributes']['manufacturer'])
                    //     )
                    //         \f\pa($node, 2, '', 'item перед парсингом');
                    // }

                    $d1['head'] = $node['name'];

                    if (!empty($node['Comment']) && $node['Comment'] != 1) {
                        $d1['comment'] = nl2br($node['Comment']);
                        //\f\pa($d1['comment']);
                        // \f\pa(nl2br ( $node['Comment'] ));
                    }

                    // `mod_021_items` 
                    // (`a_arrayimage`, `a_categoryid`, `a_catnumber`, `a_id`, `a_in_stock`, `a_price`, 
                    // `catnumber_search`, `comment`, `country`, `head`, `manufacturer`) 
                    // values 
                    // (PSE10666.jpg, ЦБ002170, PSE10666, ЦБ000124, , , 
                    // pse10666, , Китай, Сайлентблок нижнего рычага, Patron), 
                    // (4059253.jpg, ЦБ002515, 4059253, ЦБ000125, , , 4059253, , Н/Д, Пружина передняя, ), 

                    if (!empty($node['@attributes'])) {
                        foreach ($node['@attributes'] as $k1 => $v1) {

                            $v1 = trim($v1);
                            $k1 = strtolower($k1);

                            if (!empty($v1) && $v1 != '') {

                                if ($k1 == 'manufacturer') {
                                    $d1['manufacturer'] = $v1;
                                    // continue;
                                } else if ($k1 == 'countrymanuf') {
                                    $d1['country'] = $v1;
                                    // continue;
                                } else if ($k1 == 'catnumber') {
                                    $an_origin = $d1['catnumber_search'] = strtolower(self::translit($v1, 'uri3'));
                                    // continue;
                                } else if ($k1 == 'arrayanalog') {

                                    $an_items = explode(',', $v1);
                                    //\f\pa( [ $node , $an_items ] );
                                    // $analogs[ $node['@attributes']['catNumber'] ?? '' ] = $an_items;

                                    foreach ($an_items as $analog1) {
                                        $analogs[] = [
                                            'art_origin' => $node['@attributes']['catNumber'],
                                            'art_analog' => $analog1
                                        ];
                                    }
                                    // continue;
                                } else {
                                    $d1['a_' . $k1] = $v1;
                                }
                            }
                        }


                        //                                            if( strtolower($k1) == 'arrayanalog' ){
                        //                                                
                        //                                                $list0 = explode( ',', $v1 );
                        //                                                
                        //                                                foreach( $list0 as $a ){
                        //                                                    
                        //                                                $analogs[] = [
                        //                                                    'art_origin' => strtolower(\f\translit(trim($v1),'uri3')),
                        //                                                    'art_analog' => strtolower(\f\translit(trim($v1),'uri3'))
                        //                                                ];
                        //                                                
                        //                                                $d1['catnumber_search' ] = '';
                        //                                                }
                        //                                            }

                    }
                }

                $items[] = $d1;
            }
        }

        // echo '<br/>#' . __LINE__;

        $reader->close();

        // echo '<pre style="max-height: 300px; overflow: auto; display: block;" >', print_r($cats), '</pre>';

        unlink($fileImport);

        // dd([
        //     'file' => $data_file,
        //     'cats' => $cats ?? [],
        //     'items' => $items ?? [],
        //     'analogs' => $analogs ?? [],
        //     // 'time' => \f\timer_stop(789)
        // ]);

        return [
            'file' => $data_file,
            'cats' => $cats ?? [],
            'items' => $items ?? [],
            'analogs' => $analogs ?? [],
            // 'time' => \f\timer_stop(789)
        ];





        // if (empty($_REQUEST['skip_rename']))
        //     rename($sc . $file, $sc . $file . '.old.' . date('Ymd.his') . '.xml');


        // break;
        //                 }
        //             }

        //             if ($start1 === false)
        //                 throw new \Exception('Не обнаружен файл для обработки');

        // //            \f\pa([
        // //                'cats' => $cats,
        // //                    // 'items' => $items 
        // //                    ], 2, '', 'cat items 0');
        // //            \f\pa([
        // //                // 'cats' => $cats, 
        // //                'items' => $items
        // //                    ], 2, '', 'item items' 0);
        //         }

        //         if (!empty($_REQUEST['show1'])) {
        //             \f\pa($data_file, 2, '', 'file какие данные получили из здата файла');
        //             \f\pa($cats ?? [], 2, '', 'cats какие данные получили из здата файла');
        //             \f\pa($items ?? [], 2, '', '$items какие данные получили из здата файла');
        //             \f\pa($analogs ?? [], 2, '', '$analogs какие данные получили из здата файла');
        //         }

        //         return \f\end3('обработ', true,
        //                 [
        //                     'file' => $data_file,
        //                     'cats' => $cats ?? [],
        //                     'items' => $items ?? [],
        //                     'analogs' => $analogs ?? [],
        //                     'time' => \f\timer_stop(789)
        //                 ]
        //         );

    }
}
