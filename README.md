Deploy instruction:

(1) cp .env.example .env
(2) docker-compose up -d
(3) php artisan migrate --seed
(4) php passport:install
(5) Для дебага используем постман, с bearer auth токеном.

Постман:
- https://www.postman.com/
- Создаешь запрос на страницу http://localhost/api/user/login/
- Данные для входа в фабрике laravel (рандомный email из базы)
- Пароль на всех аккаунтах - password
 
Пример того как работать тут - https://www.youtube.com/watch?v=8edBY1g0ujY


Если не работает все, проверь наличие папки vendor, при ее отсутствии установи локално composer и выполни коману «composer install». Все как в инструкции laravel.
