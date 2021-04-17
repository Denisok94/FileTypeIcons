FileTypeIcons
====

Yii2 extension for the definition of icon by file extension.

Выдаст название иконки или svg, по типу файла в соответствии с его расширением.

![https://img.shields.io/badge/license-BSD-green](https://img.shields.io/badge/license-BSD-green) ![https://img.shields.io/badge/downloads-~3Mb-blue](https://img.shields.io/badge/downloads-~3Mb-blue)

## Оглавление

0. [Вступление](#вступление)
1. [Установка](#установка)
2. [Подключение](#подключение)
3. [Функции](#функции)
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
4. [Статус](#статус)
    1. [Готово](#готово)
    2. [В работе](#в-работе)
    3. [В планах](#в-планах)
5. [Обновления](#обновления)


## Вступление

- Плагин не претендует на идеальность и единственно верным решением текущей задачи.
- Список типов файлов согласно их расширению составлен по мнению автора. Если он вас не устраивает, реализована возможность его замена. 
- Иконки взяты с сайта [icon-icons.com](https://icon-icons.com/)
- в планах реализовать выдачу svg согласно расширению файла.
- Я не буду против, если Вы предложите свой вариант типов и/или пак svg иконок.

____
[:arrow_up:Оглавление](#Оглавление)
___
## Установка

Run:
```
php composer.phar require --prefer-dist denisok94/file-type-icons
```

or add to the `require` section of your `composer.json` file:

```json
"denisok94/file-type-icons": "*"
```
```
composer update
```

____
[:arrow_up:Оглавление](#Оглавление)
___
## Подключение

```php
use \denisok94\plugin\FileTypeIcons as FTI;
$example = new FTI();
```
____
[:arrow_up:Оглавление](#Оглавление)
___
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
___
### ext

Получить расширение файла. Результат будет с нижним регистром, можно использовать в своих нуждах.

```php
$example->ext('example.xml'); // xml
$example->ext('example.PDF'); // pdf
```
Или использовать для своих иконок
```css
.my-ico>i:before {
    background-size: 30px 30px;
    height: 30px;
    width: 30px;
}
.xml:before {
    display: block;
    content: ' ';
    background-image: url('/assets/xml.svg');
}
```
```php
$ext = $example->ext('example.xml'); // xml
use yii\helpers\Html;
echo HTML::tag('div', HTML::tag('i', null, ['class' => $ext]), ['class' => 'my-ico']);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### type

Узнать к какому типу относится файл, также можно использовать для иконки FA.

```php
$type = $example->type('example.swf'); // file
$type = $example->type('example.JPG'); // image
$type = $example->type('example.rar'); // archive
$type = $example->type('example.xml'); // excel
echo HTML::tag('i', null, ['class' => 'fa fa-' . $type]); // Font Awesome
```

Или, можно создать свою svg иконку под определённый тип, и обернуть в div

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

Получить название иконки для Font Awesome 4/5

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

Получить "полную" информацию о файле, в рамках плагина

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

Получить svg иконку согласно типу файлу

```php
$svg = $example->svg('example.xml'); // <svg ...></svg>
echo HTML::tag('div', $svg, ['style' => 'height: 60px; width: 60px;']);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### svgBg

Вставить свою svg иконку на фон

```php
svgBg($svg, $options = []);
$options = [
    'style' => array|string,
    'class' => string,
    'tag' => string,
    'id' => string,
    'txt' => string
];

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

Задать свой лист типов расширений и/или лист svg

```php
$f_t = new FTI(Лист типов, Лист svg);
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
$f_t->set(Лист типов, Лист svg);
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
    ]
]);
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### get

Получиьт текущий список типов[0] и svg[1] 

```php
print_r($f_t->get());
```
___
### return

Вернуть родной список типов и svg 

```php
$f_t->return();
```
____
[:arrow_up:Оглавление](#Оглавление)
___
### example

Показать пример работы плагина `FileTypeIcons`. Выдаст таблицу с примерами

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

- Расширение списка типов файлов
- Расширение списка svg иконок типов
___
### В планах

- svg иконка согласно расширению файла
____
[:arrow_up:Оглавление](#Оглавление)


___
## Обновления 
___
### Update to v0.6.5

| где | что | 
|:----------------|:---------|
| плагин | svg вынесены в отдельный класс | 
| README | исправление ошибок | 

___
### Update to v0.6.4

| где | что | 
|:----------------|:---------|
| плагин | исправление ошибок и оптимизация | 
| tupe_list | in audio add aac, in archive add gzip, in html add 'htm', 'mht'
| README | исправление ошибок | 

___
### Update to v0.6.3

| 1 | 2 | 
|:----------------|:---------|
| composer.json | `"suggest": {"rmrevin/yii2-fontawesome": "~2.9 → ~3.0"}` | 
| README | - | 

___
### Update to <v0.6.2

куча правок с разбирательством, как оно работает =)
____
[:arrow_up:Оглавление](#Оглавление)