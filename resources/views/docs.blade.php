<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeraTasks — API Documentation</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root[data-theme="dark"] {
            --bg: #080b14;
            --bg2: #0d1117;
            --bg3: #111827;
            --surface: rgba(255, 255, 255, 0.04);
            --border: rgba(255, 255, 255, 0.08);
            --border-strong: rgba(255, 255, 255, 0.15);
            --text: #f0f4ff;
            --text-muted: #6b7280;
            --text-soft: #9ca3af;
            --accent: #6366f1;
            --accent2: #818cf8;
            --accent-glow: rgba(99, 102, 241, 0.25);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --nav-bg: rgba(8, 11, 20, 0.88);
            --code-bg: #0d1117;
            --get: #10b981;
            --post: #6366f1;
            --patch: #f59e0b;
            --delete: #ef4444;
        }

        :root[data-theme="light"] {
            --bg: #f5f7ff;
            --bg2: #eef0fa;
            --bg3: #e8ecf8;
            --surface: rgba(255, 255, 255, 0.85);
            --border: rgba(99, 102, 241, 0.12);
            --border-strong: rgba(99, 102, 241, 0.25);
            --text: #0f1729;
            --text-muted: #9ca3af;
            --text-soft: #6b7280;
            --accent: #6366f1;
            --accent2: #4f46e5;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            --nav-bg: rgba(245, 247, 255, 0.9);
            --code-bg: #1e2433;
            --get: #059669;
            --post: #6366f1;
            --patch: #d97706;
            --delete: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 80% 50% at 20% 10%, var(--accent-glow), transparent);
            pointer-events: none;
            z-index: 0;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: var(--nav-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border);
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent), #7c3aed);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 0 16px var(--accent-glow);
        }

        .nav-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text);
        }

        .nav-title span {
            color: var(--accent);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            color: var(--text-soft);
            text-decoration: none;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--accent);
            background: var(--surface);
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
        }

        /* LAYOUT */
        .layout {
            display: flex;
            min-height: 100vh;
            padding-top: 64px;
            position: relative;
            z-index: 1;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            padding: 28px 20px;
            border-right: 1px solid var(--border);
            background: var(--bg2);
        }

        .sidebar-section {
            margin-bottom: 28px;
        }

        .sidebar-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 10px;
            padding: 0 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: var(--text-soft);
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: var(--surface);
            color: var(--text);
        }

        .sidebar-link.active {
            background: var(--accent-glow);
            color: var(--accent2);
        }

        .method-dot {
            width: 7px;
            height: 7px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .dot-get {
            background: var(--get);
        }

        .dot-post {
            background: var(--post);
        }

        .dot-patch {
            background: var(--patch);
        }

        .dot-delete {
            background: var(--delete);
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            flex: 1;
            padding: 40px 48px;
            max-width: 960px;
        }

        /* HERO */
        .hero {
            margin-bottom: 48px;
        }

        .hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 12px;
            background: linear-gradient(135deg, var(--text), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .hero p {
            color: var(--text-soft);
            font-size: 1.05rem;
            line-height: 1.6;
            max-width: 600px;
        }

        .hero-meta {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .hero-badge {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.78rem;
            color: var(--text-soft);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .hero-badge strong {
            color: var(--text);
        }

        /* SECTION */
        .section {
            margin-bottom: 56px;
            scroll-margin-top: 80px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text);
        }

        .section-desc {
            color: var(--text-soft);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 40px 0;
        }

        /* ENDPOINT CARD */
        .endpoint {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .endpoint:hover {
            border-color: var(--border-strong);
        }

        .endpoint-header {
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
        }

        .method-badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .method-GET {
            background: rgba(16, 185, 129, 0.12);
            color: var(--get);
        }

        .method-POST {
            background: rgba(99, 102, 241, 0.12);
            color: var(--post);
        }

        .method-PATCH {
            background: rgba(245, 158, 11, 0.12);
            color: var(--patch);
        }

        .method-DELETE {
            background: rgba(239, 68, 68, 0.12);
            color: var(--delete);
        }

        .endpoint-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.88rem;
            color: var(--text);
            font-weight: 500;
        }

        .endpoint-desc {
            margin-left: auto;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .endpoint-body {
            padding: 0 22px 22px;
            border-top: 1px solid var(--border);
            padding-top: 20px;
        }

        /* TABLE */
        .param-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
            margin-bottom: 16px;
        }

        .param-table th {
            text-align: left;
            padding: 8px 12px;
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--border);
        }

        .param-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .param-table tr:last-child td {
            border-bottom: none;
        }

        .param-name {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--accent2);
        }

        .param-type {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--text-soft);
        }

        .required {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .optional {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        /* CODE */
        .code-block {
            background: var(--code-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px 18px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            line-height: 1.7;
            overflow-x: auto;
            color: #e2e8f0;
            margin-top: 12px;
        }

        .code-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
            margin-top: 16px;
        }

        .c-key {
            color: #818cf8;
        }

        .c-str {
            color: #86efac;
        }

        .c-num {
            color: #fb923c;
        }

        .c-kw {
            color: #f472b6;
        }

        .c-comment {
            color: #4b5563;
        }

        /* RULE CARD */
        .rules-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 16px;
        }

        .rule-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
        }

        .rule-card-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rule-card p {
            font-size: 0.8rem;
            color: var(--text-soft);
            line-height: 1.5;
        }

        /* STATUS FLOW */
        .status-flow {
            display: flex;
            align-items: center;
            gap: 0;
            margin: 20px 0;
            flex-wrap: wrap;
            gap: 8px;
        }

        .status-node {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .status-node.pending {
            border-color: rgba(96, 165, 250, 0.4);
            color: #60a5fa;
        }

        .status-node.in_progress {
            border-color: rgba(167, 139, 250, 0.4);
            color: #a78bfa;
        }

        .status-node.done {
            border-color: rgba(16, 185, 129, 0.4);
            color: var(--success);
        }

        .status-arrow {
            color: var(--text-muted);
            font-size: 1.2rem;
        }

        /* DB TABLE */
        .db-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }

        .db-table th {
            text-align: left;
            padding: 10px 14px;
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--border);
            background: var(--bg2);
        }

        .db-table td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--border);
        }

        .db-table tr:last-child td {
            border-bottom: none;
        }

        .db-table tr:hover td {
            background: var(--surface);
        }

        .pk {
            background: rgba(99, 102, 241, 0.12);
            color: var(--accent2);
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .content {
            animation: fadeIn 0.4s ease;
        }

        @media(max-width:900px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
                padding: 24px 20px;
            }
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-strong);
            border-radius: 3px;
        }
    </style>
</head>

<body>

    <nav>
        <a class="nav-brand" href="/">
            <div class="nav-logo">⚡</div>
            <span class="nav-title">Tera<span>Tasks</span></span>
        </a>
        <div class="nav-right">
            <a class="nav-link" href="/">← Dashboard</a>
            <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn">☀️</button>
        </div>
    </nav>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
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
                    <div class="hero-badge">🚀 <strong>Laravel 13</strong></div>
                    <div class="hero-badge">🗄️ <strong>MySQL 8</strong></div>
                    <div class="hero-badge">🐘 <strong>PHP 8.4</strong></div>
                    <div class="hero-badge">🎨 <strong>Vue.js 3</strong></div>
                    <div class="hero-badge">☁️ <strong>Railway</strong></div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- BASE URL -->
            <div class="section" id="base-url">
                <div class="section-title">Base URL</div>
                <div class="section-desc">All API requests are prefixed with <code
                        style="font-family:'JetBrains Mono',monospace; color:var(--accent2); background:var(--surface); padding:2px 8px; border-radius:4px;">/api</code>
                </div>
                <div class="code-block">https://task-manager-production-cd6b.up.railway.app/api</div>
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
                        <div class="rule-card-title">🔒 Unique Title per Date</div>
                        <p>A task title cannot be duplicated on the same due_date. The same title is allowed on
                            different dates.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">📅 Future Due Dates Only</div>
                        <p>The due_date must be today or a future date. Past dates are rejected with a 422 validation
                            error.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">⬆️ Status Can Only Move Forward</div>
                        <p>Status progresses strictly one step at a time. Cannot skip steps or revert to a previous
                            status.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-card-title">🗑️ Delete Only Done Tasks</div>
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
                    <p style="font-size:0.8rem; color:var(--text-muted); margin-top:8px;">Each PATCH request advances
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
                        <span class="endpoint-desc">Daily task summary (Bonus)</span>
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
                <div class="code-block">git clone https://github.com/Grealishgit/task-manager.git
                    cd task-manager
                    composer install
                    cp .env.example .env
                    php artisan key:generate
                    php artisan migrate
                    php -S 127.0.0.1:9000 -t public</div>
                <div class="code-label">Railway Environment Variables</div>
                <div class="code-block">APP_KEY=<span class="c-str">base64:...</span>
                    APP_ENV=<span class="c-str">production</span>
                    DB_CONNECTION=<span class="c-str">mysql</span>
                    DB_HOST=<span class="c-str">containers-us-west-xxx.railway.app</span>
                    DB_PORT=<span class="c-num">XXXXX</span>
                    DB_DATABASE=<span class="c-str">railway</span>
                    DB_USERNAME=<span class="c-str">root</span>
                    DB_PASSWORD=<span class="c-str">your_password</span></div>
            </div>

        </main>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            const theme = isDark ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('tera-theme', theme);
            document.getElementById('themeBtn').textContent = isDark ? '🌙' : '☀️';
        }

        // Load saved theme
        const saved = localStorage.getItem('tera-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('themeBtn').textContent = saved === 'dark' ? '☀️' : '🌙';
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