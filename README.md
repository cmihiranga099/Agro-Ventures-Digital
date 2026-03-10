# Task Manager

A task management application built with Laravel 12, MySQL, Blade, and Tailwind CSS. Users can register, log in, and manage their own tasks — creating, editing, soft-deleting, and restoring them. There's also a REST API secured with Laravel Sanctum.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL 8+

## Setup

```bash
git clone <repo-url>
cd task-manager

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create the MySQL database first:

```sql
CREATE DATABASE task_manager;
```

Then update `.env` with your database credentials and run migrations:

```bash
php artisan migrate

# Optional: seed with a demo user (demo@example.com / password) and sample tasks
php artisan db:seed
```

Build assets and start the server:

```bash
npm run build
php artisan serve
```

Open `http://localhost:8000` in your browser.

## Environment Variables

| Variable | Description | Default |
|---|---|---|
| `APP_NAME` | Application name shown in the UI | `TaskFlow` |
| `APP_ENV` | Environment (`local`, `production`) | `local` |
| `APP_KEY` | Laravel encryption key — set with `artisan key:generate` | — |
| `APP_DEBUG` | Show detailed errors | `true` |
| `APP_URL` | Full URL of the app | `http://localhost` |
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `task_manager` |
| `DB_USERNAME` | Database username | `root` |
| `DB_PASSWORD` | Database password | _(empty)_ |
| `SESSION_DRIVER` | Session storage driver | `database` |

## Features

- Auth: register, login, logout, profile update, password change
- Tasks: create, edit, soft delete, restore from trash, force delete
- Filters: status, priority, keyword search, due date range
- Sorting: newest, oldest, due date, priority
- Pagination on task list and trash
- Dashboard with task counts, upcoming deadlines, recent activity
- REST API with Sanctum token authentication

## API

All API routes are under `/api` and require a Bearer token in the `Authorization` header.

To get a token (using Tinker):

```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->createToken('my-token')->plainTextToken;
```

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/tasks` | List tasks (supports filters + pagination) |
| POST | `/api/tasks` | Create a task |
| GET | `/api/tasks/{id}` | Get a single task |
| PUT | `/api/tasks/{id}` | Update a task |
| DELETE | `/api/tasks/{id}` | Soft delete a task |
| GET | `/api/tasks/trashed` | List soft-deleted tasks |
| POST | `/api/tasks/{id}/restore` | Restore a deleted task |

Query params for GET `/api/tasks`: `status`, `priority`, `search`, `due_from`, `due_to`, `sort` (newest\|oldest\|due_date\|priority), `trashed` (only\|with), `page`.

## Assumptions

- Each user only sees and manages their own tasks — there's no admin view or shared workspace.
- Deleting a task from the web UI moves it to trash (soft delete). Permanent deletion is only available from the trash view.
- The API does not have separate login/register endpoints — it's assumed the consumer obtains a Sanctum token via Tinker or a separate token issuance flow. Adding `POST /api/login` would be straightforward but wasn't included since the spec focused on task endpoints.
- Due dates are optional. Tasks without a due date are sorted to the end when sorting by due date.
