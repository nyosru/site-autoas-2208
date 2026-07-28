<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\Catalog;
use App\Models\Good;
use App\Models\GoodAnalog;

use Nyos\Msg;

class ImportAvtoAsController extends Controller
{

    // public function import2()
    // {
    //     $e = sizeof(Storage::files('public/photo'));
    //     dd($e);
    // }

    /**
     * импорт дата файла
     * @param $file
     * @return string
     * @throws \Exception
     */
    public function import(Request $request, $file = 'AllCatalog.xml')
    {

        if (!Storage::exists('import1c/' . $file))
            return 'файла данных не обнаружено';

        $ee = self::parsingXml($file);

        $msg = '';
        $return = [];

        if (!empty($ee['cats'])) {
            Catalog::truncate();
            Catalog::insert($ee['cats']);
            $msg .= 'Каталогов: ' . sizeof($ee['cats']) . PHP_EOL;
            $return['cats'] = sizeof($ee['cats']);
        }

        if (!empty($ee['items'])) {

            Good::truncate();
            foreach (array_chunk($ee['items'], 1000) as $t) {
                Good::insert($t);
            }

            $msg .= 'Товаров: ' . sizeof($ee['items']) . PHP_EOL;
            $return['items'] = sizeof($ee['items']);

        }

        if (!empty($ee['analogs'])) {
            GoodAnalog::truncate();
            foreach (array_chunk($ee['analogs'], 1000) as $t) {
                GoodAnalog::insert($t);
            }
            $msg .= 'и связей для Аналогов: ' . sizeof($ee['analogs']) . PHP_EOL;
            $return['analogs'] = sizeof($ee['analogs']);
        }

        // 360209578, // я
        $return['photo'] = sizeof(Storage::files('public/photo'));
        $photos = 'Фото: ' . $return['photo'];

        // отмена оповещений
        if (!empty($request->cancel_notification)) {
            Msg::sendTelegramm('Обработан импорт данных' . PHP_EOL . $msg . $photos, null, 1);
        } // если нет "отмены оповещений"
        else {
//            Msg::$admins_id = [
//                1022228978, // AvtoAs
//                663501687, //Денис Авто-СА
//            ];
//            Msg::sendTelegramm('Обработан импорт данных' . PHP_EOL . $msg . $photos, null, 2);

            $messageService = app(\App\Services\VkMessageService::class);
            $listeners = $messageService->getListListeners();
            Log::info('ImportXml: sending to listeners', ['count' => count($listeners)]);
            $secret = env('PHP_CAT_API_SECRET');

            $messageService = app(\App\Services\VkMessageService::class);

            if (!empty($secret)) {

                foreach ($listeners as $vkId) {
                    $notificationResult = $messageService->sendNotification($secret, $vkId, $msg);

                    if ($notificationResult['success']) {
                        Log::info('SendOrder: notification sent to PHP-cat API', ['vk_id' => $vkId]);
                    } else {
                        Log::error('SendOrder: failed to send notification to PHP-cat API', [
                            'vk_id' => $vkId,
                            'error' => $notificationResult['error'] ?? 'unknown',
                        ]);
                    }
                }

                $result = $messageService->sendNotification($secret, 5903492, 'копия' . PHP_EOL . $msg);

                if ($result['success']) {
                    Log::info('SendOrder: copy sent to admin', ['vk_id' => 5903492]);
                } else {
                    Log::error('SendOrder: failed to send copy to admin', [
                        'vk_id' => 5903492,
                        'error' => $result['error'] ?? 'unknown',
                    ]);
                }
            }

        }

        if ($request->return == 'json') {
            return response()->json($return);
        } else {
            die('<pre>' . 'Обработан импорт данных' . PHP_EOL . $msg . $photos . '</pre>');
        }
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
                "а" => "a", "б" => "b", "в" => "v", "г" => "g",
                "д" => "d", "е" => "e", "ж" => "zh",
                "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
                "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
                "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "",
                "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
            );

            $c = preg_replace('/[^a-zA-Z0-9_]/', '', mb_strtolower(strtr($cyr, $tr)));

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return $c;
        } elseif ($type == 'cifr') {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return preg_replace('/[^0-9]/', '', $cyr_str);
        } elseif ($type == 'cifr2') {
            $e = preg_replace('/[^0-9,.]/', '', $cyr_str);

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '</fieldset>';
            }

            return str_replace(",", ".", $e);
        } elseif ($type == 'cifr21') {
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

    public static function parsingXml($file = 'AllCatalog.xml', $dataFileDelete = false)
    {

        $fileImport = Storage::path('import1c/' . $file);

        $start1 = true;
        $data_file = $fileImport;
        $est_xml_file = true;

        $reader = new \XMLReader();

        if (!$reader->open($fileImport)) {
            throw new \Exception('Failed to open ' . $fileImport, 422);
        }

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
                $node = (array)new \SimpleXMLElement($reader->readOuterXML());

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
            } //
            elseif ($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'item') {

                $d1 = [
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

                $node = (array)new \SimpleXMLElement($reader->readOuterXML());

                if (!empty($node['name'])) {

                    $d1['head'] = $node['name'];

                    if (!empty($node['Comment']) && $node['Comment'] != 1) {
                        $d1['comment'] = nl2br($node['Comment']);
                    }

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
                                    $d1['a_catnumber'] = $v1;
                                    $an_origin = $d1['catnumber_search'] = strtolower(self::translit($v1, 'uri3'));
                                    // continue;
                                } else if ($k1 == 'arrayanalog') {

                                    $an_items = explode(',', $v1);

                                    foreach ($an_items as $analog1) {
                                        $analogs[] = [
                                            'art_origin' => $node['@attributes']['catNumber'],
                                            'art_analog' => $analog1
                                        ];
                                    }
                                } else {
                                    $d1['a_' . $k1] = $v1;
                                }
                            }
                        }

                    }
                }

                $items[] = $d1;
            }
        }

        $reader->close();

        if ($dataFileDelete === true) {
            unlink($fileImport);
        }

        return [
            'file' => $data_file,
            'cats' => $cats ?? [],
            'items' => $items ?? [],
            'analogs' => $analogs ?? [],
            // 'time' => \f\timer_stop(789)
        ];

    }
}
