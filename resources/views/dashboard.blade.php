<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="/css/app.css">

</head>

<body>

    @verbatim
    <div id="app">
        <header>
            <h1>⚡ Task Management</h1>
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
    @endverbatim

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                const today = new Date().toISOString().split('T')[0];
                return {
                    API: 'https://task-manager-production-cd6b.up.railway.app/api',
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