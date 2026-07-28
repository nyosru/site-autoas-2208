## Branch discipline
- **`prod` is the deploy branch** — CI/CD (GitHub Actions) deploys to VPS on push to `prod`. Never commit directly to `prod` without user instruction.
- Two branches: `main` and `prod`.

## Build & dev
```sh
npm run dev      # Laravel Mix development
npm run prod     # Production build (used in CI with Node 18)
npm run watch    # Watch mode
composer install
```
- CI builds assets on GitHub runner (`npm ci && npm run prod`), then SCPs `public/js/app.js`, `public/css/app.css`, `public/mix-manifest.json` to the VPS.
- Server runs PHP 8.0 — composer installs with `--no-dev`.
- Docker контейнер для локальной разработки "2312auto_as"

## Testing
```sh
php artisan test
vendor/bin/phpunit
php artisan test --group=api1      # Catalog API tests
php artisan test --group=good      # Good API tests
php artisan test --filter=ShopCat  # Focused run
```
- PHPUnit 9.5, test suites: `Unit` and `Feature`. Feature tests use `DatabaseMigrations`/`RefreshDatabase`.

## Custom artisan commands
```sh
php artisan photo:generate-mini                     # 200px thumbnails (default)
php artisan photo:generate-mini --width=400         # custom width
php artisan list:classes                            # list container bindings
```

## Architecture
- **Laravel 8 + Vue 3 SPA** — single Blade view (`resources/views/welcome.blade.php`) mounts the Vue app.
- Vue Router with `createWebHistory()` and a catch-all route `/:catchAll(.*)*` — all frontend routing is handled client-side.
- Entry: `resources/js/app.js` → builds to `public/js/app.js`.
- **Webpack copies** (see `webpack.mix.js`):
  - `resources/to-storage-app-public/` → `storage/app/public/`
  - `resources/apiAllAutoparts` → `public/apiAllAutoparts`

## Key controllers
| Route file | Purpose |
|---|---|
| `routes/web.php` | Admin pages, VK auth, catch-all SPA route |
| `routes/api.php` | Catalog, goods, orders, banners, pages, import |

## Error messaging and notifications
### Оповещения об успешной/неуспешной отправке
- **`SendOrderController::sendMsgToListeners()`** теперь отправляет сообщения одновременно по двум каналам:
  - VK с помощью `$vkService->sendToUserWithResult()` (с детальным логированием ошибок)
  - API `php-cat.com` с помощью `$messageService->sendNotification()` для достав_EXTRA канала
- **Улучшенное логирование**:
  - Отдельные записи для успешной/неудачной отправки каждого пользователя
  - Заголовок `SendOrder` с количеством получателей
  - Логирование всех типов ошибок (HTTP-статусы, API-ошибки, exceptions)
- **PHP 7 совместимость**: Переключен на старый синтаксис конструктора для проджект undelivered

### Технические детали
- Используется `VkMessageService.sendNotification()` для отправки через api.php-cat.com
- Поддерживается индивидуальная конфигурация $`PHP_CAT_API_SECRET` и $`PHP_CAT_API_URL`
- Логирование обогащено кастомным форматом для лучшего трейсинга
- Отдельное логирование для копий сообщений (админу)

## Auth & roles
- Admin login via **VK OAuth** (Socialite). Routes under `/admin/`.
- Custom `role` middleware checks `owner` / `tourist` roles on the `users` table.

## Third-party integrations
| Service | Env vars |
|---|---|
| AllAutoparts API | `ALLAUTOPARTS_API_session_login`, `ALLAUTOPARTS_API_session_password` |
| Ucaller (SMS) | `UCALLER_KEY`, `UCALLER_SERVICE_ID` |
| Telegram bot | `TELEGA_ORDERBOT_TOKEN` |
| VK OAuth | `VK_CLIENT_ID`, `VK_CLIENT_SECRET`, `VK_REDIRECT_URI` |

## Database
- Production DB: `avtoas_prod` (MySQL).
- Key tables: `mod_020_cats` (catalog), `mod_021_items` (goods), `mod_021_items_analogs` (analogs), `orders`, `order_goods`, `order_comments`, `pages`, `mod_banner_up`.
- 27 migrations — note `mod_022_orders` migration exists but the `Order` model uses the `orders` table.

## Code style
- **Prettier**: no semicolons, single quotes, trailing commas es6.
- **StyleCI**: Laravel preset for PHP.
- **EditorConfig**: 4-space indent, LF endings, UTF-8.
- No ESLint, no PHP CS Fixer, no pre-commit hooks.

## CI/CD
- Trigger: push to `prod`.
- Steps: build assets → SSH pull + `composer i --no-dev` + `artisan migrate` → SCP assets → Telegram/VK notifications.
- VPS: `46.254.19.97`, user `di4basa7`, dir `/var/www/di4basa7/data/www/prod`.

## Misc
- `make bash` → `docker exec -it 2312auto_as bash` (dev container).
- Storage symlink: `public/storage` → `storage/app/public`.
- Need to copy `resources/to-storage-app-public/` to `storage/app/public/` for local dev.
