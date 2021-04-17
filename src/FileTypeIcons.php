<?php

/**
 * @link https://s-denis.ru/
 * @copyright Copyright (c) 2020 S-Denis LLC
 * @license https://s-denis.ru/license/
 */

namespace denisok94\plugin;

use Yii;
use yii\helpers\Html;
use denisok94\plugin\svg;

/**
 * Иконка под тип файла.
 *
 * Выдаст название иконкии в соответствии с расширению файла.
 * 
 * @author Denisok94 <denis@s-denis.ru>
 * @since 0.2
 */
class FileTypeIcons extends svg
{
    private static $tupe_list = [
        'image' => [
            'ico' => 'image',
            'ext' => ['png', 'jpg', 'jpeg', 'bmp', 'psd', 'icon', 'gif', 'ico', 'svg', 'webp'],
        ],
        'video' => [
            'ico' => 'video',
            'ext' =>  ['mp4', 'avi', 'webm', 'mkv', '3gp', 'f4v', 'flv', 'moov', 'mov', 'mpeg', 'mpg'],
        ],
        'audio' =>  [
            'ico' => 'audio',
            'ext' => ['mp3', 'mpa', 'weba', 'wav', 'wma', 'wave', 'ogg', 'm4a', 'mid', 'midi', 'aac'],
        ],
        'word' => [
            'ico' => 'word',
            'ext' =>  ['doc', 'docm', 'docx', 'dot', 'dotm', 'dotx', 'odt', 'rtf', 'dotx'],
        ],
        'excel' => [
            'ico' => 'excel',
            'ext' =>  ['xml', 'xls', 'xlsx', 'xlsm', 'xlt', 'csv'],
        ],
        'powerpoint' => [
            'ico' => 'powerpoint',
            'ext' =>  ['ppa', 'ppt', 'pptx', 'pptm', 'xps', 'pot', 'potx', 'potm', 'pps', 'ppsx', 'ppsm'],
        ],
        'archive' => [
            'ico' => 'archive',
            'ext' =>  ['zip', 'rar', '7z', 'gzip'],
        ],
        'js' => [
            'ico' => 'code',
            'ext' =>  ['js'],
        ],
        'css' => [
            'ico' => 'code',
            'ext' =>  ['css'],
        ],
        'php' => [
            'ico' => 'code',
            'ext' =>  ['php'],
        ],
        'html' => [
            'ico' => 'code',
            'ext' =>  ['html', 'htm', 'mht'],
        ],
        'python' => [
            'ico' => 'code',
            'ext' =>  ['py'],
        ],
        'txt' => [
            'ico' => 'text',
            'ext' =>  ['txt'],
        ],
        'pdf' => [
            'ico' => 'pdf',
            'ext' =>  ['pdf'],
        ],
    ];
    private static $extensions = [];
    private static $extsvg = [];

    public function __construct($tupe = null, $svg = null)
    {
        self::$extensions = ($tupe) ? ($tupe) : (self::$tupe_list);
        self::$extsvg = ($svg) ? ($svg) : (self::$svg_list);
    }

    /**
     * Получить расширение файла
     * @param string $file файл,
     * @return string расширение файла
     */
    public static function ext($file)
    {
        $fname = basename($file); // берём имя файла (name.ext)
        $filetupe = pathinfo($fname); // берём о нём инфу 
        $filename = $filetupe['filename']; // filename - имя файла
        $extension = isset($filetupe['extension']) ? $filetupe['extension'] : ''; // extension - расширение файла
        return strtolower($extension); // нижний регистр (PNG → png)
    }

    /**
     * поиск
     */
    private static function search($ext)
    {
        if (!self::$extensions) self::$extensions = self::$tupe_list;
        foreach (self::$extensions as $key => $value) {
            $index = array_search($ext, $value['ext']);
            if ($index !== FALSE) return [$key, $value['ico']];
        }
        return false;
    }
    // 
    /**
     * Получить название иконки font-awesome
     * @param string $file файл,
     * @param bool $pro
     * @return string
     * 
     * $file = 'name.ext';
     * 
     * $fa = FileTypeIcons::fa($file);
     * return &#60;i class="fa fa-$fa">&#60;/i>
     */
    public static function fa($file, $pro = false)
    {
        $ext = self::ext($file); // расширение файла
        $fa = 'file'; // базавая иконка
        $search = $ext ? self::search($ext) : false;
        if ($search) $fa = $search[1];
        return (($fa != 'file') ? ('file-' . $fa) : ($fa)) . ((!$pro) ? ('-o') : (''));
    }

    /**
     * Получить тип файла
     * @param string $file файл,
     * @return string тип файла
     */
    public static function type($file)
    {
        $ext = self::ext($file);  // расширение файла
        $type = 'file'; // базавая информация
        $search = $ext ? self::search($ext) : false;
        if ($search) $type = $search[0];
        return $type;
    }

    /**
     * Полная информация
     * 
     * @param string $file файл,
     * @return array type,ico,ext
     */
    public static function full($file)
    {
        $ext = self::ext($file);  // расширение файла
        // базавая информация
        $row = [
            'type' => 'file',
            'ico' => 'file',
            'ext' => $ext,
        ];
        $search = $ext ? self::search($ext) : false;
        if ($search) {
            $row['ico'] = $search[1];
            $row['type'] = $search[0];
        }
        return $row;
    }

    /**
     * svg тег согласно расширению файла
     * @param string $file файл,
     * @return string svg
     */
    public static function svg($file)
    {
        $ext = self::ext($file);  // расширение файла
        if (!self::$extsvg) self::$extsvg = self::$svg_list;
        $type = 'file'; // базавая информация
        $svg = ''; // 
        $search = $ext ? self::search($ext) : false;
        if ($search) {
            $type = $search[0];
            if (isset(self::$extsvg[$type])) $svg = self::$extsvg[$type]['svg'];
        };
        if (!$svg) {
            $svg = self::$extsvg['file']['svg'];
        }
        return $svg;
    }

    /**
     * Вставить свой svg в background
     * 
     * @param string $svg 
     * url/data
     * @param array|null $options
     * ['style' => array|string,'class' => string,'tag' => string,'id' => string,'txt' => string]
     * 
     * @return string
     */
    public static function svgBg($svg, $options = [])
    {
        $w = '60px';
        $h = '60px';
        $tag = 'i';
        $id = null;
        $class = null;
        $txt = null;
        $style = '';
        $param = [];
        if ($options) {
            if (isset($options['style'])) {
                if (!is_array($options['style'])) {
                    $params = explode(";", $options['style']);
                    foreach ($params as $values) {
                        $valuez = explode(":", $values);
                        if (isset($valuez[1])) {
                            $key_0 = str_replace(['   ', '  ', ' '], '', $valuez[0]);
                            $value_0 = str_replace(['   ', '  ', ' '], '', $valuez[1]);
                            $param[$key_0] = $value_0;
                        }
                    }
                } else {
                    $param = $options['style'];
                }
                foreach ($param as $key => $value) {
                    $style .= "$key: $value; ";
                    switch ($key) {
                        case 'width':
                            $w = $value;
                            break;
                        case 'height':
                            $h = $value;
                            break;
                    }
                }
            } else {
                $style = "height: $h; width: $w;";
            }
            if (isset($options['id'])) $id = $options['id'];
            if (isset($options['class'])) $class = $options['class'];
            if (isset($options['tag'])) $tag = $options['tag'];
        } else {
            $style = "height: $h; width: $w;";
        }

        return HTML::tag(
            $tag,
            $txt,
            [
                'id' => $id,
                'class' => $class,
                'style' => "display: block; background-image: url('$svg'); background-size: $w $h; $style"
            ]
        );
    }

    /**
     * Задать свой лист типов|svg
     * @param array $tupe 
     * @param array $svg
     */
    public static function set($tupe = null, $svg = null)
    {
        self::$extensions = ($tupe) ? ($tupe) : (self::$tupe_list);
        self::$extsvg = ($svg) ? ($svg) : (self::$svg_list);
    }

    /**
     * Получиьт текущий список типов[0] и svg[1]
     */
    public static function get()
    {
        return [self::$extensions, self::$extsvg];
    }

    /**
     * Вернуть родной список типов и svg
     */
    public static function return()
    {
        self::$extensions = self::$tupe_list;
        self::$extsvg = self::$svg_list;
    }

    // --------------------------------------------------------------

    /**
     * Пример работы FileTypeIcons 
     */
    public static function example()
    {
        $echo = '';
        $echo .= '<style>
        .file-60>.fa { font-size: 60px; display: block;}    
        .file-30>.fa { font-size: 30px; display: block;}    
        .file-20>.fa { font-size: 20px; display: block;}    
        .file-60>svg { height: 60px; width: 60px;}    
        .file-30>svg { height: 30px; width: 30px;}    
        .file-20>svg {height: 20px;width: 20px;}
        </style>';
        $echo .= '<table border="1">';
        $echo .= '<tr><th colspan="5">use denisok94\plugin\FileTypeIcons as FTI;</th></tr>';
        $echo .= '<tr>
            <th rowspan="3">$file</th>
            <th rowspan="3">FTI::ext($file)</th>
            <th rowspan="3">FTI::full($file)</th>
            <th colspan="3">svg согласно type</th>

            <th rowspan="3">FTI::type($file)</th>
            <th colspan="3">Font Awesome</th>

            <th rowspan="3">FTI::fa($file)</th>
            <th colspan="3">' .  HTML::a("Font Awesome 4", "https://www.w3schools.com/icons/fontawesome_icons_filetype.asp", ['target' => "_blank"]) . '</th>
            <th rowspan="3">FTI::fa($file, true)</th>
            <th colspan="3">' . HTML::a("Font Awesome 5", "https://www.w3schools.com/icons/fontawesome5_icons_files.asp", ['target' => "_blank"]) . '</th>
        </tr>';
        $echo .= '<tr>
            <th colspan="3">FTI::svg($file)</th>

            <th colspan="3">&#60;i class="fa fa-$type">&#60;/i></th>

            <th colspan="3">&#60;i class="fas fa-$fa">&#60;/i></th>

            <th colspan="3">&#60;i class="fal fa-$fa">&#60;/i></th>
        </tr>';
        $echo .= ' <tr>
            <th>size 10</th>
            <th>size 30</th>
            <th>size 60</th>

            <th>size 10</th>
            <th>size 30</th>
            <th>size 60</th>

            <th>size 10</th>
            <th>size 30</th>
            <th>size 60</th>

            <th>size 10</th>
            <th>size 30</th>
            <th>size 60</th>
        </tr>';

        $file_list = [
            "example",
            "example.JPG",
            "example.jpg",
            "example.png",
            "example.gif",
            "example.svg",
            "example.rar",
            "example.7z",
            "example.gzip",
            "example.css",
            "example.js",
            "example.html",
            "example.htm",
            "example.py",
            "example.php",
            "example.swf",
            "example.txt",
            "example.mp4",
            "example.mp3",
            "example.midi",
            "example.xml",
            "example.xlsx",
            "example.docx",
            "example.pptx",
            "example.pdf",
        ];
        foreach ($file_list as $value) {
            $ext = self::ext($value);
            $full = self::full($value);
            $type = self::type($value);
            $fa = self::fa($value);
            $svg = self::svg($value);
            $fa_pro = self::fa($value, true);

            $echo .=  '<tr>';
            $echo .=  '<td>' . basename($value) . '</td>';
            $echo .=  '<td>' . $ext . '</td>';
            $echo .=  "<td> type: {$full['type']},<br>ico: {$full['ico']},<br>ext: {$full['ext']}</td>";

            $echo .=  '<td>' . HTML::tag('div', $svg, ['class' => 'file-20']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', $svg, ['class' => 'file-30']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', $svg, ['class' => 'file-60']) . '</td>';

            $echo .=  '<td>' . $type . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fa fa-' . $type]), ['class' => 'file-20']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fa fa-' . $type]), ['class' => 'file-30']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fa fa-' . $type]), ['class' => 'file-60']) . '</td>';

            $echo .=  '<td>' . $fa . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fas fa fa-' . $fa]), ['class' => 'file-20']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fas fa fa-' . $fa]), ['class' => 'file-30']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fas fa fa-' . $fa]), ['class' => 'file-60']) . '</td>';

            $echo .=  '<td>' . $fa_pro . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fal fa-' . $fa_pro]), ['class' => 'file-20']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fal fa-' . $fa_pro]), ['class' => 'file-30']) . '</td>';
            $echo .=  '<td>' . HTML::tag('div', HTML::tag('i', null, ['class' => 'fal fa-' . $fa_pro]), ['class' => 'file-60']) . '</td>';

            $echo .=  '</tr>';
        }
        $echo .=  '</table>';
        return $echo;
    } // end example
}
