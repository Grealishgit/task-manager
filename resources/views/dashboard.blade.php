<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management | API</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="/css/dashboard.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Onest:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet">

</head>

<body>
    @verbatim
    <div id="app">

        <!-- WELCOME MODAL -->
        <div class="modal-overlay" v-if="showModal">
            <div class="modal">
                <h1>Welcome to TaskManagement API</h1>
                <p>A powerful task management system built with Laravel & Vue.js. Create, prioritize, and track your
                    tasks with ease.</p>
                <div class="modal-features">
                    <div class="modal-feature">Task Tracking</div>
                    <div class="modal-feature">Status Oversight</div>
                    <div class="modal-feature">Daily Reports</div>
                    <div class="modal-feature">Priority Sorting</div>
                </div>
                <button class="btn-continue" @click="showModal = false">Continue to Dashboard</button>
            </div>
        </div>

        <!-- NAVBAR -->
        <nav>
            <a class="nav-brand" href="/">
                <span class="nav-title">Task Management | <span> API</span></span>
            </a>

            <div class="nav-center">
                <a href="https://github.com/Grealishgit/task-manager">Github Repo</a>
                <a class="nav-link" href="/docs">Docs</a>
            </div>
            <div class="nav-right">
                <div class="nav-pill">{{ allTasks.length }} task{{ allTasks.length !== 1 ? 's' : '' }}</div>

                <button class="theme-toggle" @click="toggleTheme" :title="isDark ? 'Light mode' : 'Dark mode'">
                    {{ isDark ? '☀️' : '🌙' }}
                </button>
            </div>
        </nav>

        <!-- MAIN -->
        <main class="main" v-if="!showModal">
            <div class="container page-enter">

                <!-- Stats -->
                <div class="stats-bar">
                    <div class="stat-card">
                        <div class="stat-label">Total Tasks</div>
                        <div class="stat-value total">{{ allTasks.length }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending</div>
                        <div class="stat-value pending">{{ allTasks.filter(t => t.status === 'pending').length }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-value progress">{{ allTasks.filter(t => t.status === 'in_progress').length }}
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Done</div>
                        <div class="stat-value done">{{ allTasks.filter(t => t.status === 'done').length }}</div>
                    </div>
                </div>

                <!-- Create Task -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">New Task</div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" v-model="form.title" placeholder="Enter task title..."
                                @keyup.enter="createTask" />
                        </div>
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" v-model="form.due_date" />
                        </div>
                        <div class="form-group">
                            <label>Priority</label>
                            <select v-model="form.priority">
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button class="btn-primary" @click="createTask" :disabled="loading">
                                {{ loading ? 'Creating...' : 'Create Task' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Task List -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tasks</div>
                        <div class="filter-row">
                            <button v-for="f in filters" :key="f.value" class="filter-btn"
                                :class="{ active: currentFilter === f.value }"
                                @click="setFilter(f.value)">{{ f.label }}</button>
                        </div>
                    </div>

                    <div v-if="loadingTasks" class="empty">
                        <div class="empty-icon"></div>
                        <p>Loading tasks...</p>
                    </div>
                    <div v-else-if="tasks.length === 0" class="empty">
                        <div class="empty-icon"></div>
                        <p>No tasks found. Create one above!</p>
                    </div>
                    <div class="table-wrap" v-else>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td style="color:var(--text-muted);font-size:0.76rem;">{{ task.id }}</td>
                                    <td style="font-weight:500; max-width:200px;">{{ task.title }}</td>
                                    <td>
                                        <div class="date-main">{{ formatDate(task.due_date) }}</div>
                                        <div class="date-warn"
                                            v-if="isDueSoon(task.due_date) && task.status !== 'done'">⚠ Due soon</div>
                                        <div class="date-over"
                                            v-if="isOverdue(task.due_date) && task.status !== 'done'">Overdue</div>
                                    </td>
                                    <td><span :class="'badge badge-' + task.priority">{{ task.priority }}</span></td>
                                    <td><span
                                            :class="'badge badge-' + task.status">{{ task.status.replace('_',' ') }}</span>
                                    </td>
                                    <td>
                                        <div class="date-main">{{ formatDate(task.created_at) }}</div>
                                        <div class="date-sub">{{ formatTime(task.created_at) }}</div>
                                    </td>
                                    <td>
                                        <div class="date-main">{{ formatDate(task.updated_at) }}</div>
                                        <div class="date-sub">{{ formatTime(task.updated_at) }}</div>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <button v-if="task.status !== 'done'" class="btn-sm btn-advance"
                                                @click="advanceStatus(task)">
                                                {{ task.status === 'pending' ? '▶ Start' : '✔ Done' }}
                                            </button>
                                            <button v-if="task.status === 'done'" class="btn-sm btn-delete"
                                                @click="deleteTask(task)">🗑 Delete</button>
                                            <span v-if="task.status === 'done'"
                                                style="font-size:0.72rem;color:var(--success);">✓ Complete</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Daily Report -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Daily Report</div>
                    </div>
                    <div class="report-row">
                        <div class="form-group">
                            <label>Select Date</label>
                            <input type="date" v-model="reportDate" />
                        </div>
                        <button class="btn-outline" @click="loadReport" :disabled="loadingReport">
                            {{ loadingReport ? 'Generating...' : 'Generate Report' }}
                        </button>
                    </div>
                    <div v-if="report" class="report-grid">
                        <div class="report-card" v-for="priority in ['high','medium','low']" :key="priority">
                            <div :class="'report-card-title ' + priority">{{ priority }} priority</div>
                            <div class="report-stat" v-for="status in ['pending','in_progress','done']" :key="status">
                                <span class="report-stat-label">{{ status.replace('_',' ') }}</span>
                                <span class="report-stat-value">{{ report.summary[priority][status] }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="empty">
                        <p>Select a date and click Generate Report</p>
                    </div>
                </div>

            </div>
        </main>

        <!-- Toast -->
        <div v-if="toast.show" :class="'toast toast-' + toast.type">
            <span>{{ toast.type === 'success' ? '✓' : '✕' }}</span>
            {{ toast.message }}
        </div>

    </div>
    @endverbatim

    <script>
        const {
            createApp
        } = Vue;
        createApp({
            data() {
                const today = new Date().toISOString().split('T')[0];
                const theme = localStorage.getItem('task-api-theme') || 'light';
                document.documentElement.setAttribute('data-theme', theme);
                return {
                    API: window.location.hostname === 'coding-challenge.hantardev.tech' ?
                        '/api' : 'https://task-manager-production-cd6b.up.railway.app/api',
                    showModal: true,
                    isDark: theme === 'dark',
                    tasks: [],
                    allTasks: [],
                    loading: false,
                    loadingTasks: false,
                    loadingReport: false,
                    currentFilter: '',
                    reportDate: today,
                    report: null,
                    form: {
                        title: '',
                        due_date: today,
                        priority: 'high'
                    },
                    filters: [{
                            label: 'All',
                            value: ''
                        },
                        {
                            label: 'Pending',
                            value: 'pending'
                        },
                        {
                            label: 'In Progress',
                            value: 'in_progress'
                        },
                        {
                            label: 'Done',
                            value: 'done'
                        },
                    ],
                    toast: {
                        show: false,
                        message: '',
                        type: 'success'
                    },
                };
            },
            mounted() {
                this.loadTasks();
                this.loadAllTasks();
            },
            methods: {
                async request(method, endpoint, body = null) {
                    const options = {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    };
                    if (body) options.body = JSON.stringify(body);
                    const res = await fetch(this.API + endpoint, options);
                    return res.json();
                },
                async loadTasks() {
                    this.loadingTasks = true;
                    const url = this.currentFilter ? `/tasks?status=${this.currentFilter}` : '/tasks';
                    const data = await this.request('GET', url);
                    this.tasks = data.data || [];
                    this.loadingTasks = false;
                },
                async loadAllTasks() {
                    const data = await this.request('GET', '/tasks');
                    this.allTasks = data.data || [];
                },
                async createTask() {
                    if (!this.form.title || !this.form.due_date) {
                        this.showToast('Please fill in all fields.', 'error');
                        return;
                    }
                    this.loading = true;
                    const data = await this.request('POST', '/tasks', this.form);
                    this.loading = false;
                    if (data.data) {
                        this.showToast('Task created successfully!', 'success');
                        this.form.title = '';
                        this.loadTasks();
                        this.loadAllTasks();
                    } else {
                        const errors = data.errors ? Object.values(data.errors).flat().join(' ') : data.message;
                        this.showToast(errors, 'error');
                    }
                },
                async advanceStatus(task) {
                    const data = await this.request('PATCH', `/tasks/${task.id}/status`);
                    if (data.data) {
                        this.showToast(`Status → "${data.data.status}"`, 'success');
                        this.loadTasks();
                        this.loadAllTasks();
                    } else {
                        this.showToast(data.message, 'error');
                    }
                },
                async deleteTask(task) {
                    if (!confirm(`Delete "${task.title}"?`)) return;
                    const data = await this.request('DELETE', `/tasks/${task.id}`);
                    if (data.message === 'Task deleted successfully.') {
                        this.showToast('Task deleted.', 'success');
                        this.loadTasks();
                        this.loadAllTasks();
                    } else {
                        this.showToast(data.message, 'error');
                    }
                },
                async loadReport() {
                    if (!this.reportDate) {
                        this.showToast('Please select a date.', 'error');
                        return;
                    }
                    this.loadingReport = true;
                    const data = await this.request('GET', `/tasks/report?date=${this.reportDate}`);
                    this.loadingReport = false;
                    if (data.summary) {
                        this.report = data;
                    } else {
                        this.showToast(data.message || 'Failed to load report.', 'error');
                    }
                },
                setFilter(value) {
                    this.currentFilter = value;
                    this.loadTasks();
                },
                toggleTheme() {
                    this.isDark = !this.isDark;
                    const theme = this.isDark ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', theme);
                    localStorage.setItem('task-api-theme', theme);
                },
                formatDate(d) {
                    if (!d) return '—';
                    return new Date(d).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                },
                formatTime(d) {
                    if (!d) return '';
                    return new Date(d).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },
                isDueSoon(d) {
                    const diff = (new Date(d) - new Date()) / 86400000;
                    return diff >= 0 && diff <= 2;
                },
                isOverdue(d) {
                    return new Date(d) < new Date();
                },
                showToast(message, type = 'success') {
                    this.toast = {
                        show: true,
                        message,
                        type
                    };
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3500);
                },
            }
        }).mount('#app');
    </script>
</body>

</html>