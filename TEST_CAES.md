# Task Manager API - Use Cases and Testing Guide

## Overview
This document provides clear testing and usage examples for the Task Manager API. Base URL: http://127.0.0.1:9000

## Endpoints Summary
| Method | Endpoint | Description |
| --- | --- | --- |
| GET | /api/tasks | Fetch all tasks |
| POST | /api/tasks | Create a new task |
| PATCH | /api/tasks/{id}/status | Update task status |
| DELETE | /api/tasks/{id} | Delete a task (must be done) |
| GET | /api/tasks/report?date={date} | Get task summary for a specific date |

## Common Headers
- `Accept: application/json`
- `Content-Type: application/json` (POST only)

## Use Cases

### 1) Fetch all tasks
**Purpose:** Fetch all tasks for the dashboard or testing.

**cURL**
```bash
curl http://127.0.0.1:9000/api/tasks -H "Accept: application/json"
```

**Postman**
- Method: GET
- URL: http://127.0.0.1:9000/api/tasks
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
curl -X POST http://127.0.0.1:9000/api/tasks \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'
```

**Postman**
- Method: POST
- URL: http://127.0.0.1:9000/api/tasks
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
curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
    -H "Accept: application/json"
```

**Postman**
- Method: PATCH
- URL: http://127.0.0.1:9000/api/tasks/1/status
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
curl -X DELETE http://127.0.0.1:9000/api/tasks/1 \
    -H "Accept: application/json"
```

**Postman**
- Method: DELETE
- URL: http://127.0.0.1:9000/api/tasks/1
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
curl "http://127.0.0.1:9000/api/tasks/report?date=2026-04-01" \
    -H "Accept: application/json"
```

**Postman**
- Method: GET
- URL: http://127.0.0.1:9000/api/tasks/report?date=2026-04-01
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
curl -X POST http://127.0.0.1:9000/api/tasks \
    -H "Content-Type: application/json" \
    -d '{"title":"Write unit tests","due_date":"2026-04-01","priority":"low"}'
```

2. View all tasks
```bash
curl http://127.0.0.1:9000/api/tasks -H "Accept: application/json"
```

3. Mark as in_progress
```bash
curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status -H "Accept: application/json"
```

4. Mark as done
```bash
curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status -H "Accept: application/json"
```

5. Delete task (only after status is done)
```bash
curl -X DELETE http://127.0.0.1:9000/api/tasks/1 -H "Accept: application/json"
```

6. Generate report for a date
```bash
curl "http://127.0.0.1:9000/api/tasks/report?date=2026-04-01" -H "Accept: application/json"
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
| Duplicate task (same title + due date) | 400 | `A task with this title already exists for the given due date.` |
| Past due date | 400 | `This is due date which must be today or a future date.` |
| Delete task not done | 400 | `Only tasks with status "done" can be deleted.` |
| Task already done | 400 | `Task is already marked as done. No further status changes allowed.` |

## Quick Reference
| Action | cURL Command |
| --- | --- |
| GET all tasks | `curl http://127.0.0.1:9000/api/tasks -H "Accept: application/json"` |
| POST create task | `curl -X POST http://127.0.0.1:9000/api/tasks -H "Content-Type: application/json" -d '{"title":"Task","due_date":"2026-04-01","priority":"high"}'` |
| PATCH update status | `curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status -H "Accept: application/json"` |
| DELETE task | `curl -X DELETE http://127.0.0.1:9000/api/tasks/1 -H "Accept: application/json"` |
| GET report | `curl "http://127.0.0.1:9000/api/tasks/report?date=2026-04-01" -H "Accept: application/json"` |
