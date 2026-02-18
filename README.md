# TaskHub

Модульный таск-трекер на Laravel 11. ООП, переменные в `.env`, развёртывание через Docker с портами, смещёнными относительно стандартных (чтобы не конфликтовать с React на 80/443).

## Требования

- Docker и Docker Compose
- На хосте порты **8080** (веб), **3307** (MySQL), **6380** (Redis, опционально) свободны или заданы в `.env`

## Запуск

```bash
# 1. Скопировать конфиг и задать переменные
copy .env.example .env
# Отредактировать .env: APP_KEY сгенерировать после первого запуска контейнера

# 2. Запуск контейнеров (порты: 8080, 3307, 6380)
docker compose up -d --build

# 3. Генерация ключа и миграции (один раз)
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate

# 4. Открыть в браузере
# http://localhost:8080
```

Приложение будет доступно на **http://localhost:8080** (или на том порту, что задан в `.env` как `APP_PORT`).

## Порты (смещённые)

| Сервис | Внутри контейнера | На хосте (по умолчанию) |
|--------|--------------------|-------------------------|
| Nginx  | 80                 | **8080** (`APP_PORT`)   |
| MySQL  | 3306               | **3307** (`DB_PORT`)    |
| Redis  | 6379               | **6380** (`REDIS_PORT`) |

В `.env` можно переопределить: `APP_PORT`, `DB_PORT`, `REDIS_PORT` — они используются в `docker-compose.yml` для проброса портов.

## Структура (модули и ООП)

- **Модули**: `app/Modules/Auth`, `User`, `Task`, `Comment` — у каждого свой `*ServiceProvider`, роуты в `Modules/*/Routes/`, контроллеры в `Modules/*/Http/Controllers/`.
- **ООП**: бизнес-логика в сервисах (`TaskService`, `CommentService`), доступ к данным через репозитории (`TaskRepository` + `TaskRepositoryInterface`), модели с отношениями и константами статусов/ролей.
- **Конфигурация**: все чувствительные и средозависимые значения вынесены в `.env`; пример — `.env.example`.

## Команды

- Миграции: `docker compose exec app php artisan migrate`
- Консоль: `docker compose exec app php artisan tinker`
- Остановка: `docker compose down`
