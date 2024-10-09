#📚 Desafio técnico Spassu

### Objetivo
Desenvolver uma aplicação que realize o cadastro de livros, bem como autores e assuntos, além de emitir um relatório com os dados agrupados

## Stack utilizada
**Docker** - Para a criação de containers
**PHP 8.2** - Linguagem de programação
**Laravel** - Framework PHP
**Mysql** - Banco de dados

### Como rodar o projeto?
1. **Clone o repositório:**
   ```bash
   git clone git@github.com:eliton-algoll/test-library.git
   ```
2. **Acesse a pasta do projeto:**
   ```bash
   cd test-library
   ```
3. **Crie o arquivo .env:**
   ```bash
   cp .env.example .env
   ```
4. **Rodar o comando para instalar as dependências e construir os containers:**
   ```bash
   make install
   ```
5. **Rodar as migrations para gerar as tabelas e view:**
   ```bash
   make migrate
   ```
6. **A aplicação estará rodando no endereço**
   ```bash
   http://localhost:8080/
    ```

7. ** Caso esteja no Windows ou não tenha o Make instalado na mnáquina seguir os comando abaixo na ordem:**
   ```bash
   docker-compose up -d --build
   composer install
   php artisan migrate
    ```
   
### Comando úteis?
1. **Rodar os testes:**
   ```bash
   make test
   ```
2. **Rodar o rollback das migrations:**
   ```bash
   make migrate-rollback
   ```
3. **Subir e derrubar os containers respectivamente:**
   ```bash
   make up
   make down
   ```
