<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management | API Documentation</title>
    <link rel="stylesheet" href="/css/docs.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Onest+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body>

    <nav>
        <a class="nav-brand" href="/">
            <span class="nav-title">Task Management | <span> API</span></span>
        </a>

        <div class="nav-center">
            <a href="https://github.com/Grealishgit/task-manager">Github Repo</a>
            <a class="nav-link" href="/docs">Docs</a>
        </div>
        <div class="nav-right">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-controls="sidebar"
                aria-expanded="false">Menu</button>
            <a class="nav-link" href="/">← Return to Tasks</a>
            <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn">☀️</button>
        </div>
    </nav>

    <div class="sidebar-backdrop" onclick="closeSidebar()" aria-hidden="true"></div>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-section">
                <div class="sidebar-label">Overview</div>
                <a class="sidebar-link active" href="#intro">Introduction</a>
                <a class="sidebar-link" href="#base-url">Base URL</a>
                <a class="sidebar-link" href="#database">Database Schema</a>
                <a class="sidebar-link" href="#business-rules">Business Rules</a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-label">Endpoints</div>
                <a class="sidebar-link" href="#create-task">
                    <div class="method-dot dot-post"></div> Create Task
                </a>
                <a class="sidebar-link" href="#list-tasks">
                    <div class="method-dot dot-get"></div> List Tasks
                </a>
                <a class="sidebar-link" href="#update-status">
                    <div class="method-dot dot-patch"></div> Update Status
                </a>
                <a class="sidebar-link" href="#delete-task">
                    <div class="method-dot dot-delete"></div> Delete Task
                </a>
                <a class="sidebar-link" href="#daily-report">
                    <div class="method-dot dot-get"></div> Daily Report
                </a>
            </div>
            <div class="sidebar-section">
                <div class="sidebar-label">Reference</div>
                <a class="sidebar-link" href="#errors">Error Responses</a>
                <a class="sidebar-link" href="#deployment">Deployment</a>
                <a class="sidebar-link" href="#snapshots">SnapShots</a>
            </div>
        </aside>

        <!-- CONTENT -->
        <main class="content">

            <!-- HERO -->
            <div class="hero" id="intro">
                <h1>TeraTasks API Docs</h1>
                <p>A RESTful Task Management API built with Laravel 13 and MySQL. Manage tasks with strict business
                    rules, priority sorting, and daily reporting.</p>
                <div class="hero-meta">
                    <div class="hero-badge"><strong>Laravel 13</strong></div>
                    <div class="hero-badge"><strong>MySQL 8</strong></div>
                    <div class="hero-badge"><strong>PHP 8.4</strong></div>
                    <div class="hero-badge"><strong>Vue.js 3</strong></div>
                    <div class="hero-badge"><strong>Railway</strong></div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- BASE URL -->
            <div class="section" id="base-url">
                <div class="section-title">Base URL</div>
                <div class="section-desc">All API requests are prefixed with <code
                        style="font-family:'JetBrains Mono',monospace; color:var(--accent2); background:var(--surface); padding:2px 8px; border-radius:4px;">/api</code>
                </div>

                <p>For production:</p>
                <div class="code-block">
                    <p>https://task-manager-production-cd6b.up.railway.app/api</p>
                    <p style="color:red">or if it fails use</p>
                    <p>https://coding-challenge.hantardev.tech/docs</p>
                </div>
                <div class="code-label">Required Headers</div>
                <div class="code-block">
                    <span class="c-key">Content-Type</span>: <span class="c-str">application/json</span>
                    <span class="c-key">Accept</span>: <span class="c-str">application/json</span>
                </div>

                <p style='margin-top: 20px;'>For development:</p>
                <div class="code-block">http://localhost:8000/api</div>
                <div class="code-label">Required Headers</div>
                <div class="code-block">
                    <span class="c-key">Content-Type</span>: <span class="c-str">application/json</span>
                    <span class="c-key">Accept</span>: <span class="c-str">application/json</span>
                </div>
            </div>

            <div class="divider"></div>

            <!-- DATABASE -->
            <div class="section" id="database">
                <div class="section-title">Database Schema</div>
                <div class="section-desc">Single table <code
                        style="font-family:'JetBrains Mono',monospace; color:var(--accent2); background:var(--surface); padding:2px 8px; border-radius:4px;">tasks</code>
                    in MySQL with a composite unique constraint on <code
                        style="font-family:'JetBrains Mono',monospace; color:var(--accent2); background:var(--surface); padding:2px 8px; border-radius:4px;">(title, due_date)</code>.
                </div>
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Column</th>
                            <th>Type</th>
                            <th>Constraint</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">id</code></td>
                            <td>BIGINT UNSIGNED</td>
                            <td><span class="pk">PK</span></td>
                            <td>Auto-increment primary key</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">title</code></td>
                            <td>VARCHAR(255)</td>
                            <td>NOT NULL</td>
                            <td>Task title — unique per due_date</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">due_date</code></td>
                            <td>DATE</td>
                            <td>NOT NULL</td>
                            <td>Task deadline — must be today or future</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">priority</code></td>
                            <td>ENUM</td>
                            <td>NOT NULL</td>
                            <td><code style="font-family:'JetBrains Mono',monospace;">low</code> | <code
                                    style="font-family:'JetBrains Mono',monospace;">medium</code> | <code
                                    style="font-family:'JetBrains Mono',monospace;">high</code></td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">status</code></td>
                            <td>ENUM</td>
                            <td>DEFAULT pending</td>
                            <td><code style="font-family:'JetBrains Mono',monospace;">pending</code> | <code
                                    style="font-family:'JetBrains Mono',monospace;">in_progress</code> | <code
                                    style="font-family:'JetBrains Mono',monospace;">done</code></td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">created_at</code></td>
                            <td>TIMESTAMP</td>
                            <td>NULLABLE</td>
                            <td>Laravel auto-managed</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace;">updated_at</code></td>
                            <td>TIMESTAMP</td>
                            <td>NULLABLE</td>
                            <td>Laravel auto-managed</td>
                        </tr>
                    </tbody>
                </table>
                <div class="code-label">Unique Constraint</div>
                <div class="code-block">UNIQUE KEY <span class="c-key">tasks_title_due_date_unique</span> (<span
                        class="c-str">title</span>, <span class="c-str">due_date</span>)</div>
            </div>

            <div class="divider"></div>

            <!-- BUSINESS RULES -->
            <div class="section" id="business-rules">
                <div class="section-title">Business Rules</div>
                <div class="section-desc">All rules are enforced server-side through Laravel validation and Eloquent
                    logic.</div>

                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-card-title">Unique Title per Date</div>
                        <p>A task title cannot be duplicated on the same due_date. The same title is allowed on
                            different dates.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">Future Due Dates Only</div>
                        <p>The due_date must be today or a future date. Past dates are rejected with a 422 validation
                            error.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">Status Can Only Move Forward</div>
                        <p>Status progresses strictly one step at a time. Cannot skip steps or revert to a previous
                            status.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">Delete Only Done Tasks</div>
                        <p>Only tasks with status <code style="font-family:'JetBrains Mono',monospace;">done</code> can
                            be deleted. Attempting to delete others returns 403.</p>
                    </div>
                </div>

                <div style="margin-top:24px;">
                    <div class="code-label">Status Flow</div>
                    <div class="status-flow">
                        <div class="status-node pending">pending</div>
                        <div class="status-arrow">→</div>
                        <div class="status-node in_progress">in_progress</div>
                        <div class="status-arrow">→</div>
                        <div class="status-node done">done</div>
                    </div>
                    <p style="font-size:0.8rem; color:var(--text-soft); margin-top:8px;">Each PATCH request advances
                        the status by exactly one step.</p>
                </div>
            </div>

            <div class="divider"></div>

            <!-- CREATE TASK -->
            <div class="section" id="create-task">
                <div class="section-title">Endpoints</div>
                <div class="endpoint">
                    <div class="endpoint-header">
                        <span class="method-badge method-POST">POST</span>
                        <span class="endpoint-path">/api/tasks</span>
                        <span class="endpoint-desc">Create a new task</span>
                    </div>
                    <div class="endpoint-body">
                        <div class="code-label">Request Body Parameters</div>
                        <table class="param-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Rules</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">title</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="required">Required</span></td>
                                    <td style="color:var(--text-soft);">Max 255 chars. Unique per due_date.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">due_date</span></td>
                                    <td><span class="param-type">date (Y-m-d)</span></td>
                                    <td><span class="required">Required</span></td>
                                    <td style="color:var(--text-soft);">Must be today or a future date.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">priority</span></td>
                                    <td><span class="param-type">enum</span></td>
                                    <td><span class="required">Required</span></td>
                                    <td style="color:var(--text-soft);">One of: <code
                                            style="font-family:'JetBrains Mono',monospace;">low</code>, <code
                                            style="font-family:'JetBrains Mono',monospace;">medium</code>, <code
                                            style="font-family:'JetBrains Mono',monospace;">high</code></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="code-label">Example Request</div>
                        <div class="code-block">curl -X <span class="c-kw">POST</span>
                            https://task-manager-production-cd6b.up.railway.app/api/tasks \
                            -H <span class="c-str">"Content-Type: application/json"</span> \
                            -H <span class="c-str">"Accept: application/json"</span> \
                            -d <span class="c-str">'{"title":"Fix login
                                bug","due_date":"2026-04-01","priority":"high"}'</span></div>
                        <div class="code-label">Success Response (201)</div>
                        <div class="code-block">{
                            <span class="c-key">"message"</span>: <span class="c-str">"Task created
                                successfully."</span>,
                            <span class="c-key">"data"</span>: {
                            <span class="c-key">"id"</span>: <span class="c-num">1</span>,
                            <span class="c-key">"title"</span>: <span class="c-str">"Fix login bug"</span>,
                            <span class="c-key">"due_date"</span>: <span
                                class="c-str">"2026-04-01T00:00:00.000000Z"</span>,
                            <span class="c-key">"priority"</span>: <span class="c-str">"high"</span>,
                            <span class="c-key">"status"</span>: <span class="c-str">"pending"</span>,
                            <span class="c-key">"created_at"</span>: <span
                                class="c-str">"2026-03-30T10:00:00.000000Z"</span>,
                            <span class="c-key">"updated_at"</span>: <span
                                class="c-str">"2026-03-30T10:00:00.000000Z"</span>
                            }
                            }
                        </div>
                    </div>
                </div>

                <!-- LIST TASKS -->
                <div class="endpoint" id="list-tasks">
                    <div class="endpoint-header">
                        <span class="method-badge method-GET">GET</span>
                        <span class="endpoint-path">/api/tasks</span>
                        <span class="endpoint-desc">List all tasks</span>
                    </div>
                    <div class="endpoint-body">
                        <div class="code-label">Query Parameters</div>
                        <table class="param-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">status</span></td>
                                    <td><span class="param-type">enum</span></td>
                                    <td><span class="optional">Optional</span></td>
                                    <td style="color:var(--text-soft);">Filter by <code
                                            style="font-family:'JetBrains Mono',monospace;">pending</code>, <code
                                            style="font-family:'JetBrains Mono',monospace;">in_progress</code>, or <code
                                            style="font-family:'JetBrains Mono',monospace;">done</code></td>
                                </tr>
                            </tbody>
                        </table>
                        <p style="font-size:0.82rem; color:var(--text-soft); margin-bottom:12px;">Results sorted by
                            priority (high → medium → low), then due_date ascending using MySQL <code
                                style="font-family:'JetBrains Mono',monospace;">FIELD()</code>.</p>
                        <div class="code-label">Example Requests</div>
                        <div class="code-block">GET /api/tasks
                            GET /api/tasks?status=pending
                            GET /api/tasks?status=in_progress
                            GET /api/tasks?status=done</div>
                    </div>
                </div>

                <!-- UPDATE STATUS -->
                <div class="endpoint" id="update-status">
                    <div class="endpoint-header">
                        <span class="method-badge method-PATCH">PATCH</span>
                        <span class="endpoint-path">/api/tasks/{id}/status</span>
                        <span class="endpoint-desc">Advance task status</span>
                    </div>
                    <div class="endpoint-body">
                        <p style="font-size:0.82rem; color:var(--text-soft); margin-bottom:12px;">No request body
                            needed. Automatically advances status by one step: <code
                                style="font-family:'JetBrains Mono',monospace;">pending → in_progress → done</code>.
                            Cannot skip or revert.</p>
                        <div class="code-label">URL Parameters</div>
                        <table class="param-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">id</span></td>
                                    <td><span class="param-type">integer</span></td>
                                    <td style="color:var(--text-soft);">Task ID</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="code-label">Success Response (200)</div>
                        <div class="code-block">{
                            <span class="c-key">"message"</span>: <span class="c-str">"Task status updated to
                                'in_progress'."</span>,
                            <span class="c-key">"data"</span>: { <span class="c-comment">... updated task object
                                ...</span> }
                            }
                        </div>
                        <div class="code-label">Error — Already Done (422)</div>
                        <div class="code-block">{
                            <span class="c-key">"message"</span>: <span class="c-str">"Task is already marked as done.
                                No further status changes allowed."</span>
                            }
                        </div>
                    </div>
                </div>

                <!-- DELETE TASK -->
                <div class="endpoint" id="delete-task">
                    <div class="endpoint-header">
                        <span class="method-badge method-DELETE">DELETE</span>
                        <span class="endpoint-path">/api/tasks/{id}</span>
                        <span class="endpoint-desc">Delete a task</span>
                    </div>
                    <div class="endpoint-body">
                        <p style="font-size:0.82rem; color:var(--text-soft); margin-bottom:12px;">Only tasks with status
                            <code style="font-family:'JetBrains Mono',monospace;">done</code> can be deleted. Returns
                            403 for any other status.
                        </p>
                        <div class="code-label">Success Response (200)</div>
                        <div class="code-block">{ <span class="c-key">"message"</span>: <span class="c-str">"Task
                                deleted successfully."</span> }</div>
                        <div class="code-label">Error — Not Done (403)</div>
                        <div class="code-block">{ <span class="c-key">"message"</span>: <span class="c-str">"Only tasks
                                with status \"done\" can be deleted."</span> }</div>
                    </div>
                </div>

                <!-- DAILY REPORT -->
                <div class="endpoint" id="daily-report">
                    <div class="endpoint-header">
                        <span class="method-badge method-GET">GET</span>
                        <span class="endpoint-path">/api/tasks/report</span>
                        <span class="endpoint-desc">Daily task summary</span>
                    </div>
                    <div class="endpoint-body">
                        <div class="code-label">Query Parameters</div>
                        <table class="param-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">date</span></td>
                                    <td><span class="param-type">date (Y-m-d)</span></td>
                                    <td><span class="required">Required</span></td>
                                    <td style="color:var(--text-soft);">Date to generate report for</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="code-label">Success Response (200)</div>
                        <div class="code-block">{
                            <span class="c-key">"date"</span>: <span class="c-str">"2026-04-01"</span>,
                            <span class="c-key">"summary"</span>: {
                            <span class="c-key">"high"</span>: { <span class="c-key">"pending"</span>: <span
                                class="c-num">2</span>, <span class="c-key">"in_progress"</span>: <span
                                class="c-num">1</span>, <span class="c-key">"done"</span>: <span class="c-num">0</span>
                            },
                            <span class="c-key">"medium"</span>: { <span class="c-key">"pending"</span>: <span
                                class="c-num">1</span>, <span class="c-key">"in_progress"</span>: <span
                                class="c-num">0</span>, <span class="c-key">"done"</span>: <span class="c-num">3</span>
                            },
                            <span class="c-key">"low"</span>: { <span class="c-key">"pending"</span>: <span
                                class="c-num">0</span>, <span class="c-key">"in_progress"</span>: <span
                                class="c-num">0</span>, <span class="c-key">"done"</span>: <span class="c-num">1</span>
                            }
                            }
                            }
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ERRORS -->
            <div class="section" id="errors">
                <div class="section-title">Error Responses</div>
                <div class="section-desc">All errors return JSON with a <code
                        style="font-family:'JetBrains Mono',monospace; color:var(--accent2);">message</code> field and
                    appropriate HTTP status codes.</div>
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Meaning</th>
                            <th>When</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace; color:#60a5fa;">201</code></td>
                            <td>Created</td>
                            <td>Task created successfully</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace; color:var(--success);">200</code>
                            </td>
                            <td>OK</td>
                            <td>Successful GET, PATCH, DELETE</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace; color:var(--warning);">422</code>
                            </td>
                            <td>Unprocessable</td>
                            <td>Validation failed, duplicate title, past date, already done</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace; color:var(--danger);">403</code>
                            </td>
                            <td>Forbidden</td>
                            <td>Attempting to delete a non-done task</td>
                        </tr>
                        <tr>
                            <td><code style="font-family:'JetBrains Mono',monospace; color:var(--danger);">404</code>
                            </td>
                            <td>Not Found</td>
                            <td>Task ID does not exist</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>

            <!-- DEPLOYMENT -->
            <div class="section" id="deployment">
                <div class="section-title">Deployment</div>
                <div class="section-desc">The API is hosted on Railway with a MySQL 8 database plugin.</div>
                <div class="code-label">Local Setup</div>
                <div class="code-block">
                    <p>git clone https://github.com/Grealishgit/task-manager.git</p>
                    <p>cd task-manager</p>
                    <p>composer install</p>
                    <p>cp .env.example .env</p>
                    <p>php artisan key:generate</p>
                    <p>php artisan migrate</p>
                    <p>php -S 127.0.0.1:9000 -t public</p>
                </div>
                <div class="code-label">Railway Environment Variables</div>
                <div class="code-block">
                    <p>APP_KEY=<span class="c-str">base64:...</span></p>
                    <p>APP_ENV=<span class="c-str">production</span></p>
                    <p>DB_CONNECTION= <span class="c-str">mysql</span></p>
                    <p>DB_HOST=<span class="c-str">containers-us-west-xxx.railway.app</span></p>
                    <p>DB_PORT=<span class="c-num">XXXXX</span></p>
                    <p>DB_DATABASE=<span class="c-str">railway</span></p>
                    <p>DB_USERNAME=<span class="c-str">root</span></p>
                    <p>DB_PASSWORD=<span class="c-str">your_password</span></p>
                </div>
            </div>

            <div class="divider"></div>
            <div class="section" id="snapshots">
                <div class="snapshot-grid">
                    <img src="https://27gy2ox4et.ucarecd.net/c450f97a-e3e6-4060-90f0-60e143f15dcc/Screenshot20260330193115.png"
                        alt="Snap1"
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/663ef9a4-6371-4b57-86ee-e49733e8994b/Screenshot20260330193544.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/b7e6e61e-d5b2-4b37-8af3-d8f5b2cfcad1/Screenshot20260330193433.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/ccc58815-fdef-4698-b130-f52d240b369b/Screenshot20260330193326.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/1f434c52-496f-47ff-85d8-9ede22579535/Screenshot20260330193340.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/0857c134-05ba-496f-bc45-3b2c16c0b84f/Screenshot20260330193451.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/91482cf8-ecbe-42bb-97d5-4c5292cf243e/Screenshot20260330193619.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/d0dfbb8a-ef73-4197-b099-ddea683b0c85/Screenshot20260330193519.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/4145557f-b9f0-4f63-837c-bfa7243a1a0f/report.png" alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/e2be9f58-068b-41c4-ac7b-01e3d652f76b/create.png" alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/15abd06e-2ed2-4d6b-956b-f525ae6b4039/Screenshot20260330192354.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/3c5a784f-bb6e-44b1-bb90-a0146acfaf9d/delete.png" alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/4ba4aae2-b94e-4bce-8548-ec6b208eeea5/list.png" alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                    <img src="https://27gy2ox4et.ucarecd.net/7ef3a7d9-733a-47c3-9dfd-4f2464c3c6af/apitaskpost.png"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;border-radius:8px; border: 1px solid #056b5b;">
                </div>
            </div>
            <div class="snapshot-viewer" id="snapshotViewer" aria-hidden="true">
                <div class="snapshot-frame" role="dialog" aria-modal="true" aria-label="Snapshot preview">
                    <img id="snapshotViewerImage" alt="Expanded snapshot">
                    <button class="snapshot-close" type="button" onclick="closeSnapshotViewer()"
                        aria-label="Close preview">Close</button>
                </div>
            </div>
    </div>

    </main>
    </div>

    <script>
        const snapshotViewer = document.getElementById('snapshotViewer');
        const snapshotViewerImage = document.getElementById('snapshotViewerImage');

        function openSnapshotViewer(src, altText) {
            if (!snapshotViewer || !snapshotViewerImage) return;
            snapshotViewerImage.src = src;
            snapshotViewerImage.alt = altText || 'Snapshot';
            snapshotViewer.classList.add('is-open');
            snapshotViewer.setAttribute('aria-hidden', 'false');
            document.body.classList.add('snapshot-open');
        }

        function closeSnapshotViewer() {
            if (!snapshotViewer || !snapshotViewerImage) return;
            snapshotViewer.classList.remove('is-open');
            snapshotViewer.setAttribute('aria-hidden', 'true');
            snapshotViewerImage.src = '';
            snapshotViewerImage.alt = '';
            document.body.classList.remove('snapshot-open');
        }

        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            const theme = isDark ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('tera-theme', theme);
            document.getElementById('themeBtn').textContent = isDark ? '🌙' : '☀️';
        }

        function toggleSidebar() {
            const body = document.body;
            const isOpen = body.classList.toggle('sidebar-open');
            const toggle = document.getElementById('sidebarToggle');
            if (toggle) toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
            const toggle = document.getElementById('sidebarToggle');
            if (toggle) toggle.setAttribute('aria-expanded', 'false');
        }

        // Load saved theme
        const saved = localStorage.getItem('tera-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('themeBtn').textContent = saved === 'dark' ? '☀️' : '🌙';
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', closeSidebar);
            });
            document.querySelectorAll('#snapshots img').forEach(img => {
                img.setAttribute('role', 'button');
                img.setAttribute('tabindex', '0');
                img.addEventListener('click', () => openSnapshotViewer(img.src, img.alt));
                img.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openSnapshotViewer(img.src, img.alt);
                    }
                });
            });
        });

        if (snapshotViewer) {
            snapshotViewer.addEventListener('click', (event) => {
                if (event.target === snapshotViewer) closeSnapshotViewer();
            });
        }

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && snapshotViewer && snapshotViewer.classList.contains('is-open')) {
                closeSnapshotViewer();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 900) closeSidebar();
        });

        // Active sidebar link on scroll
        const sections = document.querySelectorAll('.section, .endpoint');
        const links = document.querySelectorAll('.sidebar-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(s => {
                if (window.scrollY >= s.offsetTop - 100) current = s.id;
            });
            links.forEach(l => {
                l.classList.toggle('active', l.getAttribute('href') === '#' + current);
            });
        });
    </script>

</body>

</html>