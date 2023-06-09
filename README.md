## App Buzzvel


Crie o Arquivo .env
```sh
cp .env.example .env
```
Atualize as variáveis de ambiente do arquivo .env

```sh
APP_NAME=buzzvel
APP_URL=http://localhost:8080

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=buzzvel
DB_USERNAME=sail
DB_PASSWORD=password

```

Instale as dependências:

    ```shell
    composer install
    ```

Suba os containers do projeto
```sh
docker-compose up -d
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate

```
Para executar as migrations
```sh
php artisan migrate
```


Acessar o projeto
[http://localhost:8080](http://localhost:8080)
