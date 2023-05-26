
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Projeto Laravel+API+RestFul+Swagger

### Requisitos: 
+ PHP 8.1
+ PHP 8.1 - CLI
+ Composer
+ SGDB baseado em MySQL
+ Git

### Modulos necesários
+ mysqli
+ pdo_mysql
+ sodium
+ curl
+ fileinfo
+ xdebug
## Instalação

1. Faça o clone do projeto com gitclone

```bash
  git clone https://github.com/camilasouz0/laravel-api-restful.git
```

2. Faça a Instalação do projeto utilizando o seguinte comando

```bash
  composer install
```

3. Crie o arquivo de variáveis de ambiente utilizando o seguinte comando

```bash
  cp .env.example .env
```

5. Crie a secret do JWT e em seguida rode as migrações utilizando os seguintes comandos

```bash
  php artisan jwt:secret
  php artisan migrate
```

6. Execute o servidor artisan para rodar localmente

```bash
  php artisan serve
```
    
## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar alterar as seguintes variáveis de ambiente no seu .env

`DB_HOST`

`DB_DATABASE`

`DB_USERNAME`

`DB_PASSWORD`

## Documentação da API
+ A api do Swagger se encontra disponível em http://localhost:8000/swagger/index.html (Se o projeto estiver rodando localmente com o artisan)
+ Todas as requisições devem conter o seguinte header :
```
{ 
   Content-Type: application/json, 
   Accept: application/json, 
   Authorization: Bearer {token} 
}
```
Onde, {token} é o token obtido ao fazer a requisição de login

#### Realiza o login e recupera o TOKEN JWT

```http
  POST /api/v1/login
```

| Parâmetro   | Tipo       |  Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. Email do usuário
| `password` | `string` | **Obrigatório**. Senha do usuário |

#### Realiza o registro na API

```http
  POST /api/v1/register
```

| Parâmetro   | Tipo       |  Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Obrigatório**. Nome do usuário
| `email` | `string` | **Obrigatório**. Email do usuário
| `password` | `string` | **Obrigatório**. Senha do usuário com 6 ou mais caracteres |

#### Retorna todos os usuários

```http
  GET /api/v1/users
```

#### Retorna um usuário

```http
  POST /api/v1/users/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `string` | **Obrigatório**. O ID do usuário que você quer |


## EXECUTAR TESTES (PHPUNIT)
No terminal para executar todos os testes execute o comando:
```
php vendor\bin\phpunit
```
No terminal para executar uma classe específica execute o comando:
```
php vendor\bin\phpunit ./tests/[NomeDaClasse]
```
No terminal para executar um teste específico execute o comando:
```
php vendor\bin\phpunit --filter [METODO] ./tests/[NOMEDACLASSE]
```

## Licença
The Laravel framework is open-sourced software licensed under the [MIT license](https://choosealicense.com/licenses/mit/) .
