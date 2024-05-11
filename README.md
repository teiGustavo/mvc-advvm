## Dependências:
- PHP 8.2
- Composer
- Docker
- Docker Compose

## Como iniciar o projeto:
- Abra o terminal
- `git clone`
- `cd mvc-advvm`
- `composer install`
- Duplicar o arquivo .env.example na raiz do projeto
  - Renomear a cópia para .env
  - Realizar as modificações desejadas (lembrar de alterar também nos arquivos do docker)
- `docker compose up`
- Abrir o bash do container do php:
  - `cd /var/www/html`
  - `chown www-data:www-data ./files`
- Acessar o PhpMyAdmin:
  - Selecionar o banco mvc_advvm
  - Executar o arquivo src/BD.sql
 
## URLs padrão:
- Base: localhost
- Portas:
  - Aplicação: 8000
  - PhpMyAdmin: 8080