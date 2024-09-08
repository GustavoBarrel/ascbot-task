<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> -->

# Projeto Laravel API

## Sobre o Projeto

Este projeto é uma API back-end desenvolvida com Laravel. O objetivo é fornecer uma série de endpoints para realizar operações básicas de CRUD e gerenciamento de usuários, além de funcionalidades adicionais como envio de emails.

## Funcionalidades

- **Criação de Usuário:** Permite o registro de novos usuários no sistema.
- **Login:** Autenticação de usuários para acesso aos recursos protegidos.
- **CRUD de Livros:** Operações completas para criar, ler, atualizar e deletar informações de livros.
- **Envio de Email:** Capacidade de enviar emails a partir da aplicação para diversos fins, como notificações ou confirmações.
- **Laravel:** Framework acessível e poderoso, oferecendo ferramentas necessárias para aplicações robustas de grande porte.

## Requisitos

- PHP >= 8.0
- Composer
- Laravel = 11.22.0
- PostgreSQL
- Visual Studio Code

## Evite Erros

Seu projeto pode enfrentar alguns erros decorrentes de extensões do PHP. Portanto, vá até o diretório onde o PHP está instalado, abra o arquivo `php.ini` em um bloco de notas, remova o sinal de `;` das seguintes extensões e salve o arquivo:

- `extension=fileinfo`
- `extension=pgsql`
- `extension=pdo_pgsql`

## Instalação

### 1. Criar um Banco de Dados no PostgreSQL

Crie um banco de dados no pgAdmin4 chamado `ascbot_teste`.

### 2. Baixar o Arquivo

Baixe o arquivo ZIP do projeto no GitHub e extraia para a pasta desejada.

### 3. Alterar enviroments

Dentro do arquivo encontre o arquivo chamado .env e atualize os seguintes campos com os dados do seu banco de dados:

- DB_CONNECTION=pgsql
- DB_HOST=localhost
- DB_PORT=5432
- DB_DATABASE=ascbot_teste
- DB_USERNAME=postgres
- DB_PASSWORD=null

Alem disso, mantenha os seguintes campos da forma como se encontram pois é um email criado especialmente para o envio de emails ao criar livros.

- MAIL_MAILER=smtp
- MAIL_HOST=smtp.gmail.com
- MAIL_PORT=587
- MAIL_USERNAME=laravelsendemailtest@gmail.com
- MAIL_PASSWORD=hvixtllkawighwuh
- MAIL_ENCRYPTION=tls
- MAIL_FROM_ADDRESS=laravelsendemailtest@gmail.com
- MAIL_FROM_NAME="${APP_NAME}"

### 4. Faça o download das dependencias.

Utilizando o seguinte codigo faça o download das dependencias : 
Composer install

### 5. Gere a chave do jwt token.

Pelo terminal execute o seguinte codigo : php artisan jwt:secret

### 5. Realizar migração do banco de dados

Execute o seguinte codigo no terminal para criar as tabelas necessarias.
php artisan migrate:refresh

## Execução do proeto

Para iniciar a api utilize o seguinte codigo no terminal : 
php artisan serve

## Possiveis erros

As vezes pode ocorrer alguns erros com relação ao cache. entao um comando bastante utilizado é o composer clear-cache