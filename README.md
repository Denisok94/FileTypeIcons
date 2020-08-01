FileTypeIcons
====

Иконка под тип файла.
Выдаст название иконкии в соответствии с расширению файла.
Yii2 extension for the definition of icon by file extension.

## Оглавление

0. [Установка](#Установка)
1. [Подключение](#Подключение)
2. [Функции](#Функции)
    1. [ext](#ext)
    2. [type](#type)
    3. [fa](#fa)
    4. [full](#full)
    5. [svg](#svg)
    6. [svgBg](#svgBg)
    7. [set](#set)
    8. [get](#get)
    9. [return](#return)
    10. [example](#example)
3. [Статус](#Статус)
    1. [Готово](#Готово)
    2. [В работе](#В-работе)
    3. [В планах](#В-планах)


## Установка

Run:
```
php composer.phar require --prefer-dist denisok94/file-type-icons
```

or add

```json
"denisok94/file-type-icons": "*"
```

to the require section of your composer.json file.

____
[:arrow_up:Оглавление](#Оглавление)

## Подключение

```php
use \denisok94\plugin\FileTypeIcons as FTI;
$example = new FTI();
```
____
[:arrow_up:Оглавление](#Оглавление)

## Функции

| Имя | Параметры | Описание |
|----------------|:---------:|:----------------|
| ext | string $file | Получить расширение файла |
| type | string $file | Получить тип файла |
| fa | string $file, bool $pro | Получить название иконки font-awesome |
| full | string $file | Полная информация, выдаст: тип, исконку, расширение |
| svg | string $file | svg тег согласно расширению файла |
| svgBg | string $svg, array&#124;null $options  | Вставить свой svg в background |
| set | array $tupe, array $svg | Задать свой лист типов|svg |
| get |  | Получиьт текущий список типов[0] и svg[1] |
| return |  | Вернуть родной список типов и svg |
| example |  | Пример работы FileTypeIcons |

____
[:arrow_up:Оглавление](#Оглавление)

### ext

```php
$example->ext('example.xml'); // xml
$example->ext('example.PDF'); // pdf
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### type

```php
$type = $example->type('example.xml'); // excel
$type = $example->type('example.PDF'); // pdf
$type = $example->type('example.gif'); // image
$type = $example->type('example.mp3'); // audio
echo HTML::tag('i', null, ['class' => 'fa fa-' . $type]); // Font Awesome
```
or
```css
.office>i:before {
    background-size: 30px 30px;
    height: 30px;
    width: 30px;
}
.excel:before {
    display: block;
    content: ' ';
    background-image: url('/assets/excel.svg');
}
```
```php
$type = $example->type('example.xml'); // excel
echo HTML::tag('div', HTML::tag('i', null, ['class' => $type]), ['class' => 'office']);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### fa

```php
$fa = $example->fa('example.xml'); // file-excel-o
$fa_5 = $example->fa('example.xml', true); // file-excel
$fa = $example->fa('example.PDF'); // file-pdf-o
$fa_5 = $example->fa('example.PDF', true); // file-pdf
$fa = $example->fa('example.gif'); // file-image-o
$fa_5 = $example->fa('example.gif', true); // file-image
$fa = $example->fa('example.mp3'); // file-audio-o
$fa_5 = $example->fa('example.mp3', true); // file-audio
echo HTML::tag('i', null, ['class' => 'fas fa fa-' . $fa]); // Font Awesome 4
echo HTML::tag('i', null, ['class' => 'fal fa-' . $fa_5])); // Font Awesome 5
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### full

```php
$example->full('example.xml'); // type => excel, ico => excel, ext => xml
$example->full('example.PDF'); // type => pdf, ico => pdf, ext => pdf
$example->full('example.py'); // type => python, ico => code, ext => py
$example->full('example.zip'); // type => archive, ico => archive, ext => zip
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### svg

```php
$svg = $example->full('example.xml'); // <svg ...></svg>
echo HTML::tag('div', $svg, ['style' => 'height: 60px; width: 60px;']);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### svgBg

```php
svgBg($svg, $options = []);
$options = ['style' => array|string,'class' => string,'tag' => string,'id' => string,'txt' => string];

$svg1 = '/svg/excel.svg';
echo $example->svgBg($svg1, [
    'style' => ['width' => '60px', 'height' => '60px'],
    'class' => 'my-svg',
    'id' => 'my-svg',
    'tag' => 'i'
]);

$svg2 = 'data:image/svg+xml; utf8, <svg ...></svg>';
echo $example->svgBg($svg2, [
    'style' => 'width: 60px; height: 60px;',
    'class' => 'my-svg',
    'id' => 'my-svg',
    'tag' => 'div'
]);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### set

Задать свой лист тегов расширений и/или лист svg

```php
$f_t = new FTI([
    'image' => [
        'ico' => 'image',
        'ext' => ['png', 'jpg', 'jpeg', 'bmp', 'psd', 'icon', 'gif', 'ico', 'svg', 'webp'],
    ],
    'video' => [
        'ico' => 'video',
        'ext' =>  ['mp4', 'avi', 'webm', 'mkv', '3gp', 'f4v', 'flv', 'moov', 'mov', 'mpeg', 'mpg'],
    ]
],
[
    'image' => [
        'by' => 'author',
        'svg' => '<svg ...><svg>',
    ],
    'video' => [
        'by' => 'author',
        'svg' => '<svg ...><svg>',
    ]
]); 
or
$f_t->set([
    'image' => [
        'ico' => 'image',
        'ext' => ['png', 'jpg', 'jpeg', 'bmp', 'psd', 'icon', 'gif', 'ico', 'svg', 'webp'],
    ]
],
[
    'image' => [
        'by' => 'author',
        'svg' => '<svg ...><svg>',
    ],
    'video' => [
        'by' => 'author',
        'svg' => '<svg ...><svg>',
    ]
]);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### get

```php
print_r($f_t->get());
```
___
### return

```php
$f_t->return();
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### example

```php
echo $test->example();
```
____
[:arrow_up:Оглавление](#Оглавление)
___
## Статус 
___
### Готово 
___
### В работе
___
### В планах

____
[:arrow_up:Оглавление](#Оглавление)
