# Blink

## How to use

Run the full stack (PHP + Apache, PostgreSQL, and pgAdmin) with Docker. Configure your environment, start the services, and open the app in your browser.

### Prerequisites
- Docker and Docker Compose installed

### 1) Configure environment
Create your environment file from the example and fill in values:

```bash
cp .env.example .env
```

Update `.env` with:
- PostgreSQL: `POSTGRES_USER`, `POSTGRES_PASSWORD`, `POSTGRES_DB`
- pgAdmin: `PGADMIN_DEFAULT_EMAIL`, `PGADMIN_DEFAULT_PASSWORD`
- Google Maps: `GOOGLE_MAPS_API_KEY` (enable the Maps JavaScript API in Google Cloud)

### 2) Start the stack
From the project root:

```bash
docker compose up -d --build
```

This will:
- Build and start the web app at `http://localhost:8080`
- Start PostgreSQL on port `5432` with a persistent volume
- Start pgAdmin at `http://localhost:5053`


## For developers

### Views folder modular structure

Each UI module lives under `views/<module>/` and contains:

- `components/` – small reusable HTML snippets
- `pages/` – routeable pages (html/php)
- `scripts/` – JS for this module only
- `styles/` – CSS for this module only

Shared styles live in `views/common/styles/`:
- `theme.css`, `base.css`, `tailwindStyle.js`

Current modules and entry pages:
- Main map: `views/main/pages/main.php`
- Login: `views/login/pages/login.html`
- Register: `views/register/pages/register.html`
- Scan: `views/scan/pages/scan.html`
- Add balance: `views/addBalance/pages/addBalance.html`

When adding a new feature/page, place its assets inside that module. Avoid using `views/styles` or `views/scripts` (kept as placeholders during migration) and instead import from the module path.

### Branch conventions
Use pascal case and short names please

- feature/`Feature`

Example: `feature/AddSideBar`

### Commit conventions

Use short, semantic commit messages (Conventional Commits style):

- `feat:` new feature
- `fix:` bug fix
- `refactor:` refactoring changes

Example: `feat: add markers`

### Naming conventions

- Files: `ThisIsAFile` (PascalCase)
- Functions: `thisIsAFunction()` (camelCase)
- Variables: `thisIsAVariable` (camelCase)
- Constants: `THIS_IS_CONSTANT` (SCREAMING_SNAKE_CASE)







