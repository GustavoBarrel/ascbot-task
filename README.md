<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# Projeto Laravel API

## Sobre o Projeto

Este projeto é uma API back-end desenvolvida com Laravel. O objetivo é fornecer uma série de endpoints para realizar operações básicas de CRUD e gerenciamento de usuários, além de funcionalidades adicionais como envio de e-mails.

## Funcionalidades

- **Criação de Usuário:** Permite o registro de novos usuários no sistema.
- **Login:** Autenticação de usuários para acesso aos recursos protegidos.
- **CRUD de Livros:** Operações completas para criar, ler, atualizar e deletar informações de livros.
- **Envio de E-mail:** Capacidade de enviar e-mails a partir da aplicação para diversos fins, como notificações ou confirmações.
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
- `extension=zip`


## Instalação

### 1. Criar um Banco de Dados no PostgreSQL

Crie um banco de dados no pgAdmin4 chamado `ascbot_teste`.

### 2. Baixar o Arquivo

Baixe o arquivo ZIP do projeto no GitHub e extraia para a pasta desejada.

### 3. Alterar Ambientes

Dentro do arquivo, encontre o arquivo chamado `.env` e atualize os seguintes campos com os dados do seu banco de dados:

- `DB_CONNECTION=pgsql`
- `DB_HOST=localhost`
- `DB_PORT=5432`
- `DB_DATABASE=ascbot_teste`
- `DB_USERNAME=postgres`
- `DB_PASSWORD=null`

Além disso, mantenha os seguintes campos como se encontram, pois é um e-mail criado especialmente para o envio de e-mails ao criar livros.

- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp.gmail.com`
- `MAIL_PORT=587`
- `MAIL_USERNAME=laravelsendemailtest@gmail.com`
- `MAIL_PASSWORD=hvixtllkawighwuh`
- `MAIL_ENCRYPTION=tls`
- `MAIL_FROM_ADDRESS=laravelsendemailtest@gmail.com`
- `MAIL_FROM_NAME="${APP_NAME}"`

### 4. Baixar as Dependências

Utilize o seguinte comando para baixar as dependências: 
`composer install`

### 5. Gerar a Chave do JWT Token

No terminal, execute o seguinte comando: `php artisan jwt:secret`

### 6. Realizar Migração do Banco de Dados

Execute o seguinte comando no terminal para criar as tabelas necessárias:
`php artisan migrate:refresh`

## 7. Execução do Projeto

Para iniciar a API, utilize o seguinte comando no terminal: 
`php artisan serve`

## 8. Possíveis Erros

Às vezes, podem ocorrer erros relacionados ao cache. Então, um comando bastante utilizado é o `composer clear-cache`.

## Modelo Entidade Relacionamento

Através do link abaixo, é possível verificar o modelo MER criado do banco de dados.
`https://lucid.app/lucidchart/72e8d333-79fe-49a4-9092-e524856c16f3/edit?invitationId=inv_62576926-e70d-44fe-80af-b2d69a8748ab`

## Rotas

### 1. Usuário

Vale salientar que o `e-mail cadastrado ao criar usuário será o e-mail em que será enviado o e-mail ao criar livros`.

- **Criação de Usuário:** `http://127.0.0.1:8000/api/user` deve ser executado como um `POST`, passando no body um JSON com :`name`, `email`, `password`.
- **Login de Usuário:** `http://127.0.0.1:8000/api/login` deve ser executado como um `POST`, passando no body um JSON com : `email`, `password`.

### 2. Livros

- **Criação de Livros:** `http://127.0.0.1:8000/api/book` deve ser executado como um `POST`, passando no body um JSON com : `title`, `description`, `user_id`.
- **Visualização de Todos os Livros:** `http://127.0.0.1:8000/api/book` deve ser executado como um `GET`.
- **Visualização de um Único Livro:** `http://127.0.0.1:8000/api/book/{id}` deve ser executado como um `GET`.
- **Atualização de Livros:** `http://127.0.0.1:8000/api/book{id}` deve ser executado como um `PATCH`, passando um JSON com : `title`, `description`, `user_id`.
- **Exclusão de Livros:** `http://127.0.0.1:8000/api/book/{id}` deve ser executado como um `DELETE`.

### 3. Favoritar Livros

- **Favoritar Livros:** `http://127.0.0.1:8000/api/favorite` deve ser executado como um `POST`, passando no  um JSON com : `user_id`, `book_id`.

## Realização dos Testes

Para realizar os testes, é necessário consumir as rotas da API. Então, vou deixar abaixo duas possibilidades para você fazer esse consumo:

- **Postman**
- **Thunder Client** - extensão do próprio VS Code
