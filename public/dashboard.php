<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
        }

        header {
            background: #1e293b;
            padding: 20px 40px;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header h1 {
            font-size: 1.5rem;
            color: #38bdf8;
            font-weight: 700;
        }

        header span {
            font-size: 0.85rem;
            color: #64748b;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 28px;
        }

        .card h2 {
            font-size: 1rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #38bdf8;
        }

        .form-group select option {
            background: #1e293b;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        button:hover {
            opacity: 0.85;
        }

        button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-primary {
            background: #38bdf8;
            color: #0f172a;
        }

        .btn-success {
            background: #22c55e;
            color: #fff;
            padding: 6px 12px;
            font-size: 0.78rem;
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
            padding: 6px 12px;
            font-size: 0.78rem;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #334155;
            color: #94a3b8;
        }

        .filter-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-row button {
            padding: 7px 16px;
            font-size: 0.8rem;
            background: #0f172a;
            color: #94a3b8;
            border: 1px solid #334155;
            border-radius: 20px;
        }

        .filter-row button.active {
            background: #38bdf8;
            color: #0f172a;
            border-color: #38bdf8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        thead th {
            text-align: left;
            padding: 10px 14px;
            color: #64748b;
            font-size: 0.78rem;
            text-transform: uppercase;
            border-bottom: 1px solid #334155;
        }

        tbody tr {
            border-bottom: 1px solid #1e293b;
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: #0f172a55;
        }

        tbody td {
            padding: 12px 14px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-high {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-medium {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-low {
            background: #f0fdf4;
            color: #16a34a;
        }

        .badge-pending {
            background: #1e3a5f;
            color: #60a5fa;
        }

        .badge-in_progress {
            background: #2d1b69;
            color: #a78bfa;
        }

        .badge-done {
            background: #14532d;
            color: #4ade80;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #475569;
            font-size: 0.9rem;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .report-card {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 16px;
        }

        .report-card h3 {
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .high-title {
            color: #ef4444;
        }

        .medium-title {
            color: #f59e0b;
        }

        .low-title {
            color: #22c55e;
        }

        .report-stat {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            padding: 4px 0;
            color: #94a3b8;
        }

        .report-stat span:last-child {
            font-weight: 700;
            color: #e2e8f0;
        }

        .report-row {
            display: flex;
            gap: 12px;
            align-items: end;
            margin-bottom: 20px;
        }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            border: 1px solid #334155;
            color: #e2e8f0;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 0.85rem;
            z-index: 999;
            max-width: 300px;
            transition: all 0.3s;
        }

        .toast-success {
            border-left: 4px solid #22c55e;
        }

        .toast-error {
            border-left: 4px solid #ef4444;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .report-grid {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

    <div id="app">
        <header>
            <h1>⚡ Task Manager</h1>
            <span>{{ tasks.length }} task{{ tasks.length !== 1 ? 's' : '' }} loaded</span>
        </header>

        <div class="container">

            <!-- Create Task -->
            <div class="card">
                <h2>➕ New Task</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" v-model="form.title" placeholder="Enter task title..." />
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
                            {{ loading ? 'Creating...' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Task List -->
            <div class="card">
                <h2>📋 Tasks</h2>
                <div class="filter-row">
                    <button v-for="f in filters" :key="f.value" :class="{ active: currentFilter === f.value }"
                        @click="setFilter(f.value)">
                        {{ f.label }}
                    </button>
                </div>

                <div v-if="loadingTasks" class="empty">Loading tasks...</div>

                <div v-else-if="tasks.length === 0" class="empty">
                    No tasks found. Create one above!
                </div>

                <table v-else>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks" :key="task.id">
                            <td>{{ task.id }}</td>
                            <td>{{ task.title }}</td>
                            <td>{{ formatDate(task.due_date) }}</td>
                            <td>
                                <span :class="'badge badge-' + task.priority">
                                    {{ task.priority }}
                                </span>
                            </td>
                            <td>
                                <span :class="'badge badge-' + task.status">
                                    {{ task.status.replace('_', ' ') }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <button v-if="task.status !== 'done'" class="btn-success"
                                        @click="advanceStatus(task)">
                                        {{ task.status === 'pending' ? '▶ Start' : '✔ Done' }}
                                    </button>
                                    <button v-if="task.status === 'done'" class="btn-danger" @click="deleteTask(task)">
                                        🗑 Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Daily Report -->
            <div class="card">
                <h2>📊 Daily Report</h2>
                <div class="report-row">
                    <div class="form-group">
                        <label>Select Date</label>
                        <input type="date" v-model="reportDate" />
                    </div>
                    <button class="btn-outline" @click="loadReport" :disabled="loadingReport">
                        {{ loadingReport ? 'Loading...' : 'Generate Report' }}
                    </button>
                </div>

                <div v-if="report" class="report-grid">
                    <div class="report-card" v-for="priority in ['high', 'medium', 'low']" :key="priority">
                        <h3 :class="priority + '-title'">{{ priority }}</h3>
                        <div class="report-stat" v-for="status in ['pending', 'in_progress', 'done']" :key="status">
                            <span>{{ status.replace('_', ' ') }}</span>
                            <span>{{ report.summary[priority][status] }}</span>
                        </div>
                    </div>
                </div>

                <div v-else class="empty">Select a date and click Generate Report</div>
            </div>

        </div>

        <!-- Toast Notification -->
        <div v-if="toast.show" class="toast" :class="'toast-' + toast.type">
            {{ toast.message }}
        </div>
    </div>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                const today = new Date().toISOString().split('T')[0];
                return {
                    API: 'https://task-manager-production-a822.up.railway.app/api',
                    tasks: [],
                    loading: false,
                    loadingTasks: false,
                    loadingReport: false,
                    currentFilter: '',
                    reportDate: today,
                    report: null,
                    form: {
                        title: '',
                        due_date: today,
                        priority: 'high',
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
            },

            methods: {
                async request(method, endpoint, body = null) {
                    const options = {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
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
                    } else {
                        const errors = data.errors ? Object.values(data.errors).flat().join(' ') : data.message;
                        this.showToast(errors, 'error');
                    }
                },

                async advanceStatus(task) {
                    const data = await this.request('PATCH', `/tasks/${task.id}/status`);
                    if (data.data) {
                        this.showToast(`Status updated to "${data.data.status}"`, 'success');
                        this.loadTasks();
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

                formatDate(dateStr) {
                    return new Date(dateStr).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
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