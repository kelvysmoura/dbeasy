<center>
<h1>DBEasy</h1>
<h3>v1.1.0</h3>
<hr>
</center>

### config/db.php
```php
# Arquivo de configuração do banco de dados

# Define configuração padrão do banco de dados
$db['use_now'] = 'def';

# Array de configuração
$db['def'] = array(
	'host' => '',	# Opcional | Default: 'localhost'
	'port' => '',	# Opcional | Default: ''
	'dbname' => 'your-database',	# Obrigatorio | Default: 'undefined'
	'user' => '',	# Opcional | Default: 'root'
	'pass' => '',	# Opcional | Default: ''
	'attr_options' => [
		'errmode' => 'errmode_exception',	# Options: errmode_silent | errmode_warning | errmode_exception
		'default_fetch_mode' => 'fetch_obj',	# Options: fetch_obj | fetch_assoc | fetch_both | fetch_named | fetch_num
		'case' => 'case_natural'	# Options: case_upper | case_lower |  case_natural
	]
);
```
### Autoload e Connection
```php
# Autoload
require_once 'dbeasy-path/autoload.php';

# Namespace
use Core\DBEasy;

# Connection
$dbe = new DBEasy('your_config_db');	# Optional | Default: $db['use_now']
```

## Create
```php
$dbe->create('table_name')->Set(['field' => 'value']])->Run();
# INSERT INTO table_name(field) VALUE(value)/
```

## Read
```php
$dbe->Read('table_name')->Run();
# SELECT * FROM table_name;

$dbe->Read('table_name')->Id(1)->Run();
# SELECT * FROM table_name;

$dbe->Read('table_name')->Wh('code', 'EM5El17')->Run();
# SELECT * FROM table_name WHERE code = EM5El17;

$dbe->Read('table_name')->Fields('id, username')->Run();
# SELECT id, username FROM table_name;

$dbr->Read('table_name')->Limit(3)->Run();
# SELECT * FROM table_name LIMIT 3;

$dbr->Read('table_name')->Limit(3)->Offset(2)->Run();
# SELECT * FROM table_name LIMIT 3 OFFSET 2;

$dbr->Read('table_name')->Asc('id');
# SELECT * FROM table_name ORDER BY id ASC;

$dbr->Read('table_name')->Desc('id');
# SELECT * FROM table_name ORDER BY id DESC;

$dbr->Read('table_name')->orderBy('id Desc')->Run();
# SELECT * FROM table_name ORDER BY uusername DESC;
```

## Update
```php
$dbe->update('table_name')->Set(['field' => 'value']])->id(1)->Run();
# UPDATE SET field = value FROM table_name WHERE id = 1;

############################## C U D A D O ! ###################################
#
# Metodo update() sem nenhuma metodo do tipo WHERE 
# e seguido apenas pelo metodo Run() ou usando ultimo parametro de execução,
# pode alterar todos os registros de seu tabela.
# Se esse não for sua inteção, é recomendado ultilizar um ou mais dos metodos abaixo:
# 
# ->Id(int|required, boolean|optional|default:false)
# ->Wh(string|required, any|required, boolean|optional|default:false)
# ->Andwh(string|required, boolean|optional|default:false)
# ->Orwh(string|required, boolean|optional|default:false)
# ################################################################################
```

## Delete
```php
$dbe->delete('table_name')->id(1)->Run();
# DELETE FROM table_name WHERE id = 1;

############################## C U D A D O ! ###################################
#
# Metodo delete() sem nenhuma metodo do tipo WHERE 
# e seguido apenas pelo metodo Run() ou usando ultimo parametro de execução,
# pode alterar todos os registros de seu tabela.
# Se esse não for sua inteção, é recomendado ultilizar um ou mais dos metodos abaixo:
# 
# ->Id(int|required, boolean|optional|default:false)
# ->Wh(string|required, any|required, boolean|optional|default:false)
# ->Andwh(string|required, boolean|optional|default:false)
# ->Orwh(string|required, boolean|optional|default:false)
# ################################################################################
```

### Licença
DBEasy é um software open source licenciado sob a licença MIT (MIT). Veja [LICENSE](LICENSE) para maiores detalhes.

### Redes sociais
- [Facebook](https://fb.com/kelvys.moura)
- [Instagran](https://instagram.com/kelvysmoura)
- [Twitter](https://twitter.com/kelvysmoura)

Desenvolvido por [Kelvys Moura](https://github.com/kelvysmoura)