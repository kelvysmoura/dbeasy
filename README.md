## DBEasy - v1.1.0

- [Inicio](https://github.com/kelvysmoura/dbeasy#dbeasy---v110)
- [Create](https://github.com/kelvysmoura/dbeasy#create)
- [Read](https://github.com/kelvysmoura/dbeasy#read)
- [Update](https://github.com/kelvysmoura/dbeasy#update)
- [Delete](https://github.com/kelvysmoura/dbeasy#Delete)
- [Executando query](https://github.com/kelvysmoura/dbeasy#executando-uma-query)
- [Detalhes dos metodos CRUD](https://github.com/kelvysmoura/dbeasy#detalhes-de-m%C3%A9todo-crud)
- [Where](https://github.com/kelvysmoura/dbeasy#m%C3%A9todos-where)
- [Metodo Set](https://github.com/kelvysmoura/dbeasy#m%C3%A9todo-set)
- [Order by](https://github.com/kelvysmoura/dbeasy#m%C3%A9todos-order-by)
- [Limit e Offset](https://github.com/kelvysmoura/dbeasy#m%C3%A9todos-limit-e-offset)
- [Licença e contatos](https://github.com/kelvysmoura/dbeasy#redes-sociais)

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

### Create
***Sintaxe:** Create(string $table)*
```php
$dbe->Create('table_name')->Set(['field' => 'value']])->Run();
# INSERT INTO table_name(field) VALUE(value);
```

### Read
***Sintaxe:** Read(string $table [, boolean $run = false])*
```php
$dbe->Read('table_name')->Run();
# SELECT * FROM table_name;

$dbe->Read('table_name')->Id(1)->Run();
# SELECT * FROM table_name;

$dbe->Read('table_name')->Wh('code', 'EM5El17')->Run();
# SELECT * FROM table_name WHERE code = EM5El17;

$dbe->Read('table_name')->Fields('id, username')->Run();
# SELECT id, username FROM table_name;

$dbe->Read('table_name')->Limit(3)->Run();
# SELECT * FROM table_name LIMIT 3;

$dbr->Read('table_name')->Limit(3)->Offset(2)->Run();
# SELECT * FROM table_name LIMIT 3 OFFSET 2;

$dbe->Read('table_name')->Asc('id');
# SELECT * FROM table_name ORDER BY id ASC;

$dbe->Read('table_name')->Desc('id');
# SELECT * FROM table_name ORDER BY id DESC;

$dbe->Read('table_name')->orderBy('id Desc')->Run();
# SELECT * FROM table_name ORDER BY username DESC;
```

### Update
***Sintaxe:** Update(string $table [, boolean $run = false])*
```php
$dbe->update('table_name')->Set(['field' => 'value']])->Id(1)->Run();
# UPDATE SET field = value FROM table_name WHERE id = 1;

############################## A V I S O ! ###################################
#
# Metodo update() sem nenhuma metodo do tipo WHERE 
# e seguido apenas pelo método Run() ou usando ultimo parâmetro de execução,
# pode alterar todos os registros de seu tabela.
# Se esse não for sua intenção, é recomendado utilizar um ou mais dos métodos abaixo:
# 
# ->Id(int|required, boolean|optional|default:false)
# ->Wh(string|required, any|required, boolean|optional|default:false)
# ->Andwh(string|required, boolean|optional|default:false)
# ->Orwh(string|required, boolean|optional|default:false)
# ################################################################################
```

### Delete
***Sintaxe:** Delete(string $table [, boolean $run = false])*
```php
$dbe->delete('table_name')->Id(1)->Run();
# DELETE FROM table_name WHERE id = 1;

############################## A V I S O ! ###################################
#
# Metodo delete() sem nenhuma metodo do tipo WHERE 
# e seguido apenas pelo método Run() ou usando ultimo parâmetro de execução,
# pode alterar todos os registros de seu tabela.
# Se esse não for sua intenção, é recomendado utilizar um ou mais dos métodos abaixo:
# 
# ->Id(int|required, boolean|optional|default:false)
# ->Wh(string|required, any|required, boolean|optional|default:false)
# ->Andwh(string|required, boolean|optional|default:false)
# ->Orwh(string|required, boolean|optional|default:false)
# ################################################################################
```

### Executando uma query

- Primeira forma de executar uma query é chamando o método Run()
- Segunda forma de executar uma query é passando *true* no ultimo parâmetro dos métodos que aceitam um valor do tipo boolean opcional
- Se a segunda forma for usada o metodo Run() não precisa ser chamado

*EXEMPLO*
```php
# Usando Run()
$dbe->read('table_name')->id(1)->Run();

# Usando parâmetro true
$dbe->Read('table_name')->id(1, true)
```
- Ambos os métodos acima executam a query: *SELECT * FROM table_name WHERE id = 1;*
- **Escolha apenas uma das duas formas**

### Detalhes de método CRUD

#### Create(string $table)
*Deve chamar o metodo*
- Set(array $insert [, boolean $run = false]);

#### Read(string $table [, boolean $run = false])
*Pode chamar os metodos*
- Fields(string $fields [, boolean $run = false]);

- Id(int $id [, boolean $run = false]);

- Wh(string $field, any $value, [, boolean $run = false]);

- Andwh(string $field, any $value, [, boolean $run = false]);

- Ordwh(string $field, any $value, [, boolean $run = false]);

- Limit(array $limit, [, boolean $run = false]);

- Offset(array $offset, [, boolean $run = false]);

- Asc(array $asc, [, boolean $run = false]);

- Desc(array $desc, [, boolean $run = false]);

- OrderBy(array $order_by, [, boolean $run = false]);

#### Update(string $table [, boolean $run = false])
*Pode chamar os métodos*
- Id(int $id [, boolean $run = false]);

- Wh(string $field, any $value, [, boolean $run = false]);

- Andwh(string $field, any $value, [, boolean $run = false]);

- Ordwh(string $field, any $value, [, boolean $run = false]);

> Se for utilizado uma das duas formas de execução de query sem antes chamar um dos métodos acima,
> todos os registro do sua tabela serão atualizados

#### Delete(string $table [, boolean $run = false])
*Pode chamar os métodos*
- Id(int $id [, boolean $run = false]);

- Wh(string $field, any $value, [, boolean $run = false]);

- Andwh(string $field, any $value, [, boolean $run = false]);

- Ordwh(string $field, any $value, [, boolean $run = false]);

> Ao utilizar uma das duas formas de execução de query sem antes chamar um dos métodos acima,
> todos os registro do sua tabela serão deletados


### Métodos where

- **Id(string $field [, boolean $run = false])**
  - Método usado para adicionar uma clausula WHERE (especificamente para uma coluna de noma id) na construção de uma query

- **Wh(string $field, any $value [, boolean $run = false])**
  - Método usado para adiciona uma clausula WHERE na construção de uma query

- **Andwh(string $field, any $value [, boolean $run = false])**
  - Método usado para adiciona AND a uma clausula WHERE na construção de uma query

- **Orwh(string $field, any $value [, boolean $run = false])**
  - Método usado para adiciona OR a uma clausula WHERE na custrução de uma query

##### Combinação de métodos where
- Não chame método *Id* depois de *Wh, Andwh* ou *Orwh*
- Não chame método *Andwh* e/ou *Orwh* antes do método *Wh*
- Método *Andwh* e *Orwh* podem ser chamados depois do método *Id*

### Método Set
***Sintaxe:** Set(array $fields [, boolean $run = false])*

- Método utilizado apenas pelo os métodos *Create* e *Update*
- O primeiro prametro deve receber um array associativo
- No contexto do método *Create* o índice é o nome da coluna da tabela e o valor do índice é o que deseja **inserir** nessa coluna
- No contexto do método *Update* o valor do índice é o que deseja **alterar** na coluna da tabela

### Métodos order by

- **OrderBy(string $order_by [, boolean $run = false])**
  - Método usado para adicionar clausula ORDER BY na construção de uma query

- **Asc(string $field [, boolean $run = false])**
  - Método usado para adicionar clausula ASC na clausula ORDER BY

- **Desc(string $field [, boolean $run = false])**
  - Método usado para adicionar clausula ASC na clausula ORDER BY

### Métodos limit e offset

- **Limit(int $limit [, boolean $run = false])**
  - Adiciona a clausula LIMIT na construção de uma query
  - Não pode ser chamada depois do método *Offset*

- **Offset(int [, boolean $run = false])**
  - Adiciona a clausula OFFSET na construção de uma query
  - Não pode ser chamado antes do método *Limit*

### Licença
DBEasy é um software open source licenciado sob a licença MIT (MIT). Veja [LICENSE](LICENSE) para maiores detalhes.

### Redes sociais
- [Facebook](https://fb.com/kelvys.moura)
- [Instagram](https://instagram.com/kelvysmoura)
- [Twitter](https://twitter.com/kelvysmoura)

Desenvolvido por [Kelvys Moura](https://github.com/kelvysmoura)