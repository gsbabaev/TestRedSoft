# RESTful service template free on PHP
На PHP шаблон RESTful-сервис на нативном PHP. Структура позволяет работать одновременно над разными методами командой.
Дальше на ломаном анлгийском. Sorry me. ^^)

[![Latest Stable Version](https://poser.pugx.org/gsbabaev/restfulphptpl/v/stable)](https://packagist.org/packages/gsbabaev/restfulphptpl)
[![Total Downloads](https://poser.pugx.org/gsbabaev/restfulphptpl/downloads)](https://packagist.org/packages/gsbabaev/restfulphptpl)
[![License](https://poser.pugx.org/gsbabaev/test-red-soft/license)](https://packagist.org/packages/gsbabaev/test-red-soft)

### Requires

```bash
php: >=7.1.0
mysql: @stable
```
### Best Install


I recommend you to install this library via [Composer](https://getcomposer.org/) and use Composer autoload for easily include the files.
```bash
composer require gsbabaev/restfulphptpl
```
### Other Install
- [Download the latest release.](https://github.com/gsbabaev/restfulphptpl/archive/master.zip)
- Clone the repo: `git clone https://github.com/gsbabaev/restfulphptpl.git`

### Configuration .htaccess
``` bash
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php?q=$1 [L,QSA]
```

### Requires/Use libs
```bash
colshrapnel/safemysql: @stable
```
In folder `lib` place files `vf77/dbtree: @stable`/ It lib not present in [packages](https://packagist.org/packages)

### Config.php 

``` php
$config['db'] = 'bbb';
$config['user'] = 'xxx';
$config['pass'] = 'yyy';
```

### Load example dump to mysql
``` bash
mysql -pyyy -uxxx bbb < dump.restfulphptpl.sql
```
### Let's try it!
``` php
use RESTfulPHPtpl\TRS;

$trs = new TRS();

echo $trs->json();
```

### USE on Curl

``` bash
curl -X {metod} 'https://domains.com/{entity}/{task}/{data}/../{data}'
```

{metod} `(Support in router)`
``` bash
 GET - Получение информации о товаре.См. task
 POST - Добавление нового товара (опционально)
 PUT -  Редактирование товара (опционально)
 PATCH - Редактирование некоторых параметров товара (опционально)
 DELETE - Удаление товара (опционально)
```
{entity}
``` bash
product - for example this
```
{task} and {data}
``` bash
GET /product/get/{Id}/../{Id} - Выдача товара по ID
GET /product/find/{substr} - Выдача товаров по вхождению подстроки в названии
GET /product/manuf/{substr}/../{substr} - Выдача товаров по производителю/производителям
GET /product/cat/{cat}/../{cat} - Выдача товаров по разделу (только раздел)
GET /product/cats/{cat} - Выдача товаров по разделу и вложенным разделам с неограниченной вложенностью 
```

### Nested set
Используемый способ доступа и взаимодействия с разделам с неограниченной вложенностью.

### Contact

- Email: gs.babaev@yandex.ru

### Example 

https://salemulti.site

## Copyright and license

Code and documentation copyright 2020 . Code released under the [MIT License](https://github.com/gsbabaev/restfulphptpl/blob/master/LICENSE). 

