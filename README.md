






# Task Management API

> A production-ready RESTful Task Management API built with **Laravel 13**, **MySQL 8**, and a **Vue.js 3** frontend. Built for the Software Engineering Internship Take-Home Assignment 2026.

## Live Demo

| Resource | URL                                                      |
| -------- | -------------------------------------------------------- |
| Live App | https://task-manager-production-cd6b.up.railway.app      |
| API Docs | https://task-manager-production-cd6b.up.railway.app/docs |
| GitHub   | https://github.com/Grealishgit/task-manager              |

## Overview
This document provides testing and usage examples for the Task Manager API.
Local Base URL: http://127.0.0.1:8000

## 📂 Project Structure

```
📂 task-manager
┃
┣ 📂 app
┃ ┣ 📂 Http
┃ ┃ ┣ 📂 Controllers
┃ ┃ ┃ ┗ 📄 TaskController.php       ← All 5 API endpoint handlers
┃ ┃ ┗ 📂 Requests
┃ ┃   ┗ 📄 StoreTaskRequest.php     ← Validation rules for task creation
┃ ┗ 📂 Models
┃   ┗ 📄 Task.php                   ← Eloquent model + status flow logic
┃
┣ 📂 bootstrap
┃ ┗ 📄 app.php                      ← Laravel app config + API routing setup
┃
┣ 📂 database
┃ ┣ 📂 migrations
┃ ┃ ┗ 📄 2026_03_30_create_tasks_table.php  ← Tasks table schema
┃ ┣ 📂 seeders
┃ ┃ ┣ 📄 DatabaseSeeder.php
┃ ┃ ┗ 📄 TaskSeeder.php             ← Sample task data
┃ ┗ 📄 task_manager_dump.sql        ← Ready-to-import MySQL dump
┃
┣ 📂 resources
┃ ┗ 📂 views
┃   ┣ 📄 dashboard.blade.php        ← Vue.js 3 frontend UI
┃   ┗ 📄 docs.blade.php             ← API documentation page
┃
┣ 📂 routes
┃ ┣ 📄 api.php                      ← All API route definitions
┃ ┗ 📄 web.php                      ← Web routes (dashboard + docs)
┃
┣ 📂 config
┃ ┗ 📄 cors.php                     ← CORS configuration
┃
┣ 📄 Dockerfile                     ← Docker config for Railway deployment
┣ 📄 start.sh                       ← Container startup script
┣ 📄 .env.example                   ← Environment variables template
┗ 📄 composer.json                  ← PHP dependencies
```

## Tech Stack

| Layer           | Technology                     |
| --------------- | ------------------------------ |
| Framework       | Laravel 13                     |
| Language        | PHP 8.4                        |
| Database        | MySQL 8.0                      |
| Frontend        | Vue.js 3 (CDN, no build tools) |
| Deployment      | Railway (Docker)               |
| Version Control | GitHub                         |

## Features

- Create tasks with full validation
- List and filter tasks sorted by priority then due date
- Status progression enforcement (`pending` -> `in_progress` -> `done`)
- Delete restriction (only `done` tasks can be deleted)
- Daily report endpoint
- Modern Vue.js UI with dark/light theme toggle
- Welcome modal on first visit
- Live task stats dashboard
- Full API documentation page at `/docs`

## Database

**Database:** MySQL 8
**Table:** `tasks`

| Column       | Type                                 | Description                         |
| ------------ | ------------------------------------ | ----------------------------------- |
| `id`         | BIGINT UNSIGNED                      | Auto-increment primary key          |
| `title`      | VARCHAR(255)                         | Task title                          |
| `due_date`   | DATE                                 | Deadline - must be today or future  |
| `priority`   | ENUM(`low`,`medium`,`high`)          | Task priority                       |
| `status`     | ENUM(`pending`,`in_progress`,`done`) | Task status - defaults to `pending` |
| `created_at` | TIMESTAMP                            | Laravel auto-managed                |
| `updated_at` | TIMESTAMP                            | Laravel auto-managed                |

**Unique Constraint:** (`title`, `due_date`) - same title is allowed on different dates.

## Business Rules

| Rule                                  | Behaviour                                                 |
| ------------------------------------- | --------------------------------------------------------- |
| Duplicate title + same due_date       | Rejected with `422`                                       |
| `due_date` in the past                | Rejected with `422`                                       |
| Status skip (e.g. `pending` -> `done`) | Not allowed - one step at a time                          |
| Status revert (e.g. `done` -> `pending`) | Not allowed                                               |
| Delete a non-`done` task              | Rejected with `403 Forbidden`                             |
| List tasks                            | Always sorted: `high` -> `medium` -> `low`, then `due_date` ASC |

**Status Flow:**

```
pending -> in_progress -> done
```

## How to Run Locally

### Prerequisites

- PHP 8.2+
- Composer
- MySQL 8+
- Git

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/Grealishgit/task-manager.git
cd task-manager

# 2. Install PHP dependencies
composer install

# 3. Set up environment file
cp .env.example .env

# 4. Open .env and update your MySQL credentials:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=task_manager
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Generate app key
php artisan key:generate

# 6. Create the database
mysql -u root -p -e "CREATE DATABASE task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Run migrations
php artisan migrate

# 8. (Optional) Seed with sample data
php artisan db:seed

# 9. Start the server
php -S 127.0.0.1:8000 -t public
```

The app will be live at: **http://127.0.0.1:8000**

### Alternative: Import SQL dump directly

```bash
mysql -u root -p task_manager < database/task_manager_dump.sql
```

## Port Troubleshooting

If `php artisan serve` fails to listen on 127.0.0.1, use:

`php -S 127.0.0.1:8000 -t public`

Example error:

```text
php artisan serve --port=8080 or php artisan serve
Failed to listen on 127.0.0.1:8000 (reason: ?)
Failed to listen on 127.0.0.1:8001 (reason: ?)
Failed to listen on 127.0.0.1:8003 (reason: ?)
Failed to listen on 127.0.0.1:8004 (reason: ?)
Failed to listen on 127.0.0.1:8005 (reason: ?)
Failed to listen on 127.0.0.1:8006 (reason: ?)
Failed to listen on 127.0.0.1:8007 (reason: ?)
Failed to listen on 127.0.0.1:8008 (reason: ?)
Failed to listen on 127.0.0.1:8009 (reason: ?)
Failed to listen on 127.0.0.1:8010 (reason: ?)
```

## How to Deploy on Railway

1. Push your code to GitHub
2. Go to https://railway.app -> New Project -> Deploy from GitHub repo
3. Select your repository
4. Click + New -> Database -> Add MySQL
5. In your Laravel service -> Variables tab, add:

| Key             | Value                                            |
| --------------- | ------------------------------------------------ |
| `APP_KEY`       | Run `php artisan key:generate --show` locally    |
| `APP_ENV`       | `production`                                     |
| `APP_DEBUG`     | `false`                                          |
| `DB_CONNECTION` | `mysql`                                          |
| `DB_HOST`       | From Railway MySQL -> Variables -> `MYSQLHOST`     |
| `DB_PORT`       | From Railway MySQL -> Variables -> `MYSQLPORT`     |
| `DB_DATABASE`   | From Railway MySQL -> Variables -> `MYSQLDATABASE` |
| `DB_USERNAME`   | From Railway MySQL -> Variables -> `MYSQLUSER`     |
| `DB_PASSWORD`   | From Railway MySQL -> Variables -> `MYSQLPASSWORD` |

6. Railway will auto-deploy on every `git push`

## API Endpoints

| Environment | Base URL                                              |
| ----------- | ----------------------------------------------------- |
| Local       | http://127.0.0.1:8000/api                             |
| Production  | https://task-manager-production-cd6b.up.railway.app/api |

**Required Headers:**

```
Content-Type: application/json
Accept: application/json
```

## Endpoints Summary

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | /api/tasks | Fetch all tasks |
| POST | /api/tasks | Create a new task |
| PATCH | /api/tasks/{id}/status | Update task status |
| DELETE | /api/tasks/{id} | Delete a task (must be done) |
| GET | /api/tasks/report?date={date} | Get task summary for a specific date |

### 1. Create Task

**Purpose:** Add a task with a title, due date, and priority.

**Constraints**
- `due_date` must be today or in the future.
- Duplicate title + due date is rejected.

**Request Body:**

```json
{
    "title": "Fix login bug",
    "due_date": "2026-04-01",
    "priority": "high"
}
```

| Field      | Type         | Required | Rules                                 |
| ---------- | ------------ | -------- | ------------------------------------- |
| `title`    | string       | yes      | Max 255 chars. Unique per `due_date`. |
| `due_date` | date (Y-m-d) | yes      | Must be today or a future date.       |
| `priority` | enum         | yes      | One of: `low`, `medium`, `high`       |

**Success Response `201`:**

```json
{
    "message": "Task created successfully.",
    "data": {
        "id": 1,
        "title": "Fix login bug",
        "due_date": "2026-04-01T00:00:00.000000Z",
        "priority": "high",
        "status": "pending",
        "created_at": "2026-03-30T10:00:00.000000Z",
        "updated_at": "2026-03-30T10:00:00.000000Z"
    }
}
```

**Validation Error `422`:**

```json
{
    "message": "A task with this title already exists for the given due date.",
    "errors": {
        "title": [
            "A task with this title already exists for the given due date."
        ]
    }
}
```

**Validation Error (past due date) `422`:**

```json
{
    "message": "This is due date which must be today or a future date.",
    "errors": {
        "due_date": ["This is due date which must be today or a future date."]
    }
}
```

### 2. List Tasks

**`GET /api/tasks`**

**Optional Query Parameter:**

| Param    | Type | Description                                   |
| -------- | ---- | --------------------------------------------- |
| `status` | enum | Filter by `pending`, `in_progress`, or `done` |

**Examples:**

```
GET /api/tasks
GET /api/tasks?status=pending
GET /api/tasks?status=in_progress
GET /api/tasks?status=done
```

**Success Response `200`:**

```json
{
    "message": "Tasks retrieved successfully.",
    "data": [
        {
            "id": 1,
            "title": "Fix login bug",
            "due_date": "2026-04-01T00:00:00.000000Z",
            "priority": "high",
            "status": "pending",
            "created_at": "2026-03-30T10:00:00.000000Z",
            "updated_at": "2026-03-30T10:00:00.000000Z"
        }
    ]
}
```

**Empty Response `200`:**

```json
{
    "message": "No tasks found.",
    "data": []
}
```

**Sorting:** Results are always sorted `high` -> `medium` -> `low` priority, then `due_date` ascending using MySQL `FIELD()`.

### 3. Update Task Status

**`PATCH /api/tasks/{id}/status`**

No request body required. Automatically advances status one step forward.

**Status Flow:** `pending` -> `in_progress` -> `done`

**Success Response `200`:**

```json
{
  "message": "Task status updated to 'in_progress'.",
  "data": {
    "id": 1,
    "status": "in_progress"
  }
}
```

**Error - Already Done `422`:**

```json
{
    "message": "Task is already marked as done. No further status changes allowed."
}
```

**Error - Not Found `404`:**

```json
{
    "message": "No query results for model [App\\Models\\Task] 99"
}
```

### 4. Delete Task

**`DELETE /api/tasks/{id}`**

Only tasks with status `done` can be deleted.

**Success Response `200`:**

```json
{
    "message": "Task deleted successfully."
}
```

**Error - Not Done `403`:**

```json
{
    "message": "Only tasks with status \"done\" can be deleted."
}
```

### 5. Daily Report (Bonus)

**`GET /api/tasks/report?date=YYYY-MM-DD`**

Returns task counts grouped by priority and status for the given due date.

**Query Parameter:**

| Param  | Type         | Required | Description                 |
| ------ | ------------ | -------- | --------------------------- |
| `date` | date (Y-m-d) | yes      | Date to generate report for |

**Success Response `200`:**

```json
{
    "date": "2026-04-01",
    "summary": {
        "high": { "pending": 2, "in_progress": 1, "done": 0 },
        "medium": { "pending": 1, "in_progress": 0, "done": 3 },
        "low": { "pending": 0, "in_progress": 0, "done": 1 }
    }
}
```

## Common Headers

- `Accept: application/json`
- `Content-Type: application/json` (POST only)

## Testing and Usage Examples (Local)

### 1) Fetch all tasks
**Purpose:** Fetch all tasks for the dashboard or testing.

**cURL**
```bash
curl http://127.0.0.1:8000/api/tasks -H "Accept: application/json"
```

**Postman**
- Method: GET
- URL: http://127.0.0.1:8000/api/tasks
- Headers: Accept: application/json

**Response (success)**
```json
{
    "message": "Tasks fetched successfully.",
    "data": [
        {
            "id": 1,
            "title": "Fix login bug",
            "due_date": "2026-04-01T00:00:00.000000Z",
            "priority": "high",
            "status": "pending",
            "created_at": "2026-03-30T09:29:46.000000Z",
            "updated_at": "2026-03-30T09:29:46.000000Z"
        }
    ]
}
```

**Response (no tasks)**
```json
{
    "message": "No tasks found.",
    "data": []
}
```

### 2) Create a new task
**Purpose:** Add a task with a title, due date, and priority.

**Constraints**
- `due_date` must be today or in the future.
- Duplicate title + due date is rejected.

**cURL**
```bash
curl -X POST http://127.0.0.1:8000/api/tasks \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'
```

**Postman**
- Method: POST
- URL: http://127.0.0.1:8000/api/tasks
- Headers: Content-Type: application/json, Accept: application/json
- Body: raw (JSON)

```json
{
    "title": "Fix login bug",
    "due_date": "2026-04-01",
    "priority": "high"
}
```

**Response (success)**
```json
{
    "message": "Task created successfully.",
    "data": {
        "title": "Fix login bug",
        "due_date": "2026-04-01T00:00:00.000000Z",
        "priority": "high",
        "status": "pending",
        "updated_at": "2026-03-30T09:29:46.000000Z",
        "created_at": "2026-03-30T09:29:46.000000Z",
        "id": 1
    }
}
```

**Response (duplicate title + date)**
```json
{
    "message": "A task with this title already exists for the given due date.",
    "errors": {
        "title": ["A task with this title already exists for the given due date."]
    }
}
```

**Response (past due date)**
```json
{
    "message": "This is due date which must be today or a future date.",
    "errors": {
        "due_date": ["This is due date which must be today or a future date."]
    }
}
```

### 3) Advance task status
**Purpose:** Move a task through the status flow.

**Status flow:** `pending` -> `in_progress` -> `done`

**cURL**
```bash
curl -X PATCH http://127.0.0.1:8000/api/tasks/1/status \
    -H "Accept: application/json"
```

**Postman**
- Method: PATCH
- URL: http://127.0.0.1:8000/api/tasks/1/status
- Headers: Accept: application/json
- Body: none

**Response (status updated)**
```json
{
    "message": "Task status updated to 'in_progress'.",
    "data": {
        "id": 1,
        "title": "Fix login bug",
        "due_date": "2026-04-01T00:00:00.000000Z",
        "priority": "high",
        "status": "in_progress",
        "created_at": "2026-03-30T09:29:46.000000Z",
        "updated_at": "2026-03-30T09:31:31.000000Z"
    }
}
```

**Response (already done)**
```json
{
    "message": "Task is already marked as done. No further status changes allowed."
}
```

### 4) Delete a task
**Purpose:** Remove a task after it is marked as done.

**Rule:** Only tasks with status `done` can be deleted.

**cURL**
```bash
curl -X DELETE http://127.0.0.1:8000/api/tasks/1 \
    -H "Accept: application/json"
```

**Postman**
- Method: DELETE
- URL: http://127.0.0.1:8000/api/tasks/1
- Headers: Accept: application/json

**Response (success)**
```json
{
    "message": "Task deleted successfully."
}
```

**Response (not done)**
```json
{
    "message": "Only tasks with status \"done\" can be deleted."
}
```

### 5) Get daily report
**Purpose:** Summarize task counts by priority and status for a given date.

**cURL**
```bash
curl "http://127.0.0.1:8000/api/tasks/report?date=2026-04-01" \
    -H "Accept: application/json"
```

**Postman**
- Method: GET
- URL: http://127.0.0.1:8000/api/tasks/report?date=2026-04-01
- Headers: Accept: application/json

**Response**
```json
{
    "date": "2026-04-01",
    "summary": {
        "high": {
            "pending": 0,
            "in_progress": 0,
            "done": 0
        },
        "medium": {
            "pending": 0,
            "in_progress": 0,
            "done": 0
        },
        "low": {
            "pending": 1,
            "in_progress": 0,
            "done": 0
        }
    }
}
```

## Complete Flow Example
1. Create a task
```bash
curl -X POST http://127.0.0.1:8000/api/tasks \
    -H "Content-Type: application/json" \
    -d '{"title":"Write unit tests","due_date":"2026-04-01","priority":"low"}'
```

2. View all tasks
```bash
curl http://127.0.0.1:8000/api/tasks -H "Accept: application/json"
```

3. Mark as in_progress
```bash
curl -X PATCH http://127.0.0.1:8000/api/tasks/1/status -H "Accept: application/json"
```

4. Mark as done
```bash
curl -X PATCH http://127.0.0.1:8000/api/tasks/1/status -H "Accept: application/json"
```

5. Delete task (only after status is done)
```bash
curl -X DELETE http://127.0.0.1:8000/api/tasks/1 -H "Accept: application/json"
```

6. Generate report for a date
```bash
curl "http://127.0.0.1:8000/api/tasks/report?date=2026-04-01" -H "Accept: application/json"
```

## Postman Collection Outline
Create a new collection in Postman with these requests:

| Request Name | Method | URL | Headers | Body |
| --- | --- | --- | --- | --- |
| Get All Tasks | GET | /api/tasks | Accept: application/json | - |
| Create Task | POST | /api/tasks | Content-Type, Accept | JSON |
| Update Status | PATCH | /api/tasks/:id/status | Accept: application/json | - |
| Delete Task | DELETE | /api/tasks/:id | Accept: application/json | - |
| Get Report | GET | /api/tasks/report?date={{date}} | Accept: application/json | - |

## Test Data Examples
**Valid task creation**
```json
{
    "title": "Complete project documentation",
    "due_date": "2026-04-15",
    "priority": "medium"
}
```

**Priority values**
- high
- medium
- low

**Status flow**
- pending -> in_progress -> done

## Error Responses

| Scenario | Status Code | Message |
| --- | --- | --- |
| Duplicate task (same title + due date) | 422 | `A task with this title already exists for the given due date.` |
| Past due date | 422 | `This is due date which must be today or a future date.` |
| Delete task not done | 403 | `Only tasks with status "done" can be deleted.` |
| Task already done | 422 | `Task is already marked as done. No further status changes allowed.` |
| Task not found | 404 | `No query results for model [App\\Models\\Task] {id}` |

## Quick Reference (Local)

| Action | cURL Command |
| --- | --- |
| GET all tasks | `curl http://127.0.0.1:8000/api/tasks -H "Accept: application/json"` |
| POST create task | `curl -X POST http://127.0.0.1:8000/api/tasks -H "Content-Type: application/json" -d '{"title":"Task","due_date":"2026-04-01","priority":"high"}'` |
| PATCH update status | `curl -X PATCH http://127.0.0.1:8000/api/tasks/1/status -H "Accept: application/json"` |
| DELETE task | `curl -X DELETE http://127.0.0.1:8000/api/tasks/1 -H "Accept: application/json"` |
| GET report | `curl "http://127.0.0.1:8000/api/tasks/report?date=2026-04-01" -H "Accept: application/json"` |

## Example cURL Requests (Production)

```bash
# Create a task
curl -X POST https://task-manager-production-cd6b.up.railway.app/api/tasks \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'

# List all tasks
curl https://task-manager-production-cd6b.up.railway.app/api/tasks \
  -H "Accept: application/json"

# Filter by status
curl "https://task-manager-production-cd6b.up.railway.app/api/tasks?status=pending" \
  -H "Accept: application/json"

# Advance task status
curl -X PATCH https://task-manager-production-cd6b.up.railway.app/api/tasks/1/status \
  -H "Accept: application/json"

# Delete a task (must be done)
curl -X DELETE https://task-manager-production-cd6b.up.railway.app/api/tasks/1 \
  -H "Accept: application/json"

# Daily report
curl "https://task-manager-production-cd6b.up.railway.app/api/tasks/report?date=2026-04-01" \
  -H "Accept: application/json"
```

## HTTP Status Codes

| Code  | Meaning       | When                                                        |
| ----- | ------------- | ----------------------------------------------------------- |
| `201` | Created       | Task created successfully                                   |
| `200` | OK            | Successful GET, PATCH, DELETE                               |
| `422` | Unprocessable | Validation failed, duplicate title, past date, already done |
| `403` | Forbidden     | Attempting to delete a non-done task                        |
| `404` | Not Found     | Task ID does not exist                                      |

## Frontend

The Vue.js 3 UI is served at the root URL and includes:

- Welcome modal on first visit
- Dark/light theme toggle with localStorage persistence
- Live stats bar - total, pending, in progress, done counts
- Create task form with Enter key support
- Task table with priority badges, status badges, due date warnings
- Due soon and overdue indicators
- Created At and Updated At timestamps per task
- Advance status and delete buttons with rule enforcement
- Toast notifications for all actions
- Daily report section with priority breakdown
- Documentation page at `/docs`

## Environment Variables

```env
APP_NAME="Task Manager API"
APP_ENV=local
APP_KEY=base64:your_generated_key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

## Author

**Eugene Khanda** | Cytonn Software Engineering Intern Applicant, 2026
Kindly find my GitHub here: [@Grealishgit](https://github.com/Grealishgit)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
