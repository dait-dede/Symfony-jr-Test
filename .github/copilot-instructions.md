# Project overview

This is a small Symfony 7.4 application scaffolded with `symfony/flex`. It uses PHP 8.2, Doctrine ORM and migrations, and keeps almost all logic in the `src/` directory. The only domain model shipped is `App\Entity\Registro` with a matching repository; controllers are not yet implemented.

## Architecture & layout

- `src/Entity` contains Doctrine entities defined with PHP 8 attributes. Example: `Registro.php` defines fields `usuarioId`, `descripcion`, `estatus`, etc.
- Each entity has a corresponding repository under `src/Repository` that extends `ServiceEntityRepository`. Add custom query methods there using the query builder.
- `src/Controller` is the usual place for HTTP controllers. Routing is attribute-based: methods use `#[Route(...)]` and `config/routes.yaml` imports `routing.controllers`.
- Configuration is split into `config/packages` for bundles and `config/routes` for route imports. `services.yaml` sets `autowire: true` and `autoconfigure: true` and maps `App\` namespace to `../src/`.
- `public/index.php` boots the kernel via `vendor/autoload_runtime.php`.
- Environment variables live in `.env` (with `.env.local` overrides). `DATABASE_URL` points to a local MySQL database (`examen_tecnico` by default).
- Doctrine migrations are in `migrations/` (see `Version20260216222646.php`, which creates the `registro` table). Schema changes must be managed via migrations.

## Developer workflows

1. **Setup**
   - `composer install` to pull dependencies.
   - Configure `.env` (or `.env.local`) with correct `DATABASE_URL`.
   - `php bin/console doctrine:migrations:migrate` to sync database.
   - `php bin/console cache:clear` or let `symfony serve` warm it.

2. **Database & entities**
   - After modifying or adding an entity, run `php bin/console make:migration` or `bin/console doctrine:migrations:generate` to create a new migration.
   - Apply with `php bin/console doctrine:migrations:migrate`.
   - If you just need to get the schema in sync locally, `php bin/console doctrine:schema:update --force` is acceptable in dev but commit migrations for production.
   - Use `php bin/console doctrine:schema:validate` to check mapping vs schema (see failing output when DB is out of sync).

3. **HTTP routes & controllers**
   - Add controllers under `src/Controller` and annotate with `#[Route('/path', name:'some_name')]`.
   - To see current routes, run `php bin/console debug:router`.
   - Use dependency injection in constructors; services are autowired.

4. **Testing**
   - PHPUnit is available via `vendor/bin/phpunit` or `php bin/phpunit`. `tests/` currently only has a `bootstrap.php`. Add tests under `tests/` using Symfony's WebTestCase or other base classes.
   - The test bootstrap loads environment variables and sets umask when debugging.

5. **Running the app**
   - Development server: use the Symfony CLI (`symfony serve`) or `php -S localhost:8000 -t public`.
   - Environment `APP_ENV`/`APP_DEBUG` come from `.env`.

## Conventions & patterns

- Entities use typed properties, `static` return type on setters, and `DateTimeImmutable` for dates.
- Service configuration relies on PSR‑4 autowiring; no manual IDs unless explicit configuration is required.
- Migrations are committed PHP files in `migrations/`; avoid editing generated SQL except for manual adjustments.
- Keep business logic out of controllers; use services injected via DI if logic grows.
- Most configuration is YAML under `config/packages`; environment-specific overrides go in `.env.$APP_ENV`.

## Commands you will likely need

```bash
# general
composer install
php bin/console cache:clear
php bin/console debug:container
php bin/console debug:router

# doctrine
php bin/console make:entity        # add or modify entity interactively
php bin/console make:migration     # generate migration after entity changes
php bin/console doctrine:migrations:migrate
php bin/console doctrine:migrations:status
php bin/console doctrine:schema:validate
# (dev-only) php bin/console doctrine:schema:update --force

# tests
php bin/phpunit
```

## Notes for future AI agents

- There is only one entity; expect other domain concepts to follow the same structure.
- Routes are not visible until a controller with attributes is added; search for `#[Route` when adding features.
- The database schema error the user saw (`schema not in sync`) means migrations must be run or created.
- When editing config packages, YAML files may have schema validation via comments at the top.
- No custom helper scripts or unusual build tools are present.

> **Tip:** if you’re asked to generate the exam for prospectos, check whether a controller/service exists that orchestrates exam creation; currently such a feature is not present, which may be why "no funciona".

Please review this draft and let me know if any section needs clarification or additional details. Adjustments can be made based on missing workflows or domain specifics.