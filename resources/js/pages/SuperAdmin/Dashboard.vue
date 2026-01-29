<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { ref, computed, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Super Admin Dashboard',
    },
];

// Dashboard Stats
const stats = ref([
    { 
        label: 'Total Users', 
        value: '12,482', 
        change: '+14.2%', 
        trend: 'up',
        icon: '👥',
        color: 'from-violet-500 to-purple-600'
    },
    { 
        label: 'Revenue', 
        value: '$482,394', 
        change: '+28.4%', 
        trend: 'up',
        icon: '💰',
        color: 'from-emerald-500 to-teal-600'
    },
    { 
        label: 'Active Sessions', 
        value: '8,429', 
        change: '+8.1%', 
        trend: 'up',
        icon: '⚡',
        color: 'from-amber-500 to-orange-600'
    },
    { 
        label: 'System Health', 
        value: '98.4%', 
        change: '-0.3%', 
        trend: 'down',
        icon: '🔧',
        color: 'from-blue-500 to-cyan-600'
    },
]);

// Recent Activities
const activities = ref([
    { user: 'Sarah Chen', action: 'Updated user permissions', time: '2 mins ago', type: 'permission' },
    { user: 'Marcus Rodriguez', action: 'Created new admin account', time: '15 mins ago', type: 'admin' },
    { user: 'Emily Watson', action: 'Deployed system update v2.4.1', time: '1 hour ago', type: 'system' },
    { user: 'David Kim', action: 'Resolved security alert #847', time: '2 hours ago', type: 'security' },
    { user: 'Alex Thompson', action: 'Modified billing settings', time: '3 hours ago', type: 'billing' },
]);

// System Alerts
const alerts = ref([
    { type: 'warning', message: 'Database backup scheduled in 2 hours', priority: 'medium' },
    { type: 'info', message: 'New feature deployment ready for review', priority: 'low' },
    { type: 'critical', message: '3 failed login attempts from IP 192.168.1.x', priority: 'high' },
]);

// Chart data simulation
const chartData = ref<number[]>([]);
const generateChartData = () => {
    chartData.value = Array.from({ length: 30 }, () => Math.floor(Math.random() * 100) + 20);
};

onMounted(() => {
    generateChartData();
});

const getActivityIcon = (type: string) => {
    const icons: Record<string, string> = {
        permission: '🔐',
        admin: '👤',
        system: '🔄',
        security: '🛡️',
        billing: '💳'
    };
    return icons[type] || '📝';
};

const getAlertClass = (type: string) => {
    const classes: Record<string, string> = {
        warning: 'bg-amber-50 border-amber-200 text-amber-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800',
        critical: 'bg-red-50 border-red-200 text-red-800'
    };
    return classes[type] || 'bg-gray-50 border-gray-200 text-gray-800';
};
</script>

<template>
    <Head title="Super Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="dashboard-container">
            <!-- Welcome Section -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h1 class="welcome-title">Welcome back, Administrator</h1>
                    <p class="welcome-subtitle">Here's what's happening with your platform today</p>
                </div>
                <div class="welcome-time">
                    <span class="time-label">Current Time</span>
                    <span class="time-value">{{ new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }) }}</span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div 
                    v-for="(stat, index) in stats" 
                    :key="index"
                    class="stat-card"
                    :style="{ animationDelay: `${index * 100}ms` }"
                >
                    <div class="stat-header">
                        <div class="stat-icon-wrapper" :class="`bg-gradient-to-br ${stat.color}`">
                            <span class="stat-icon">{{ stat.icon }}</span>
                        </div>
                        <span 
                            class="stat-change"
                            :class="stat.trend === 'up' ? 'positive' : 'negative'"
                        >
                            {{ stat.change }}
                        </span>
                    </div>
                    <div class="stat-body">
                        <div class="stat-value">{{ stat.value }}</div>
                        <div class="stat-label">{{ stat.label }}</div>
                    </div>
                    <div class="stat-sparkline">
                        <svg width="100%" height="40" preserveAspectRatio="none">
                            <polyline
                                :points="chartData.slice(0, 10).map((val, i) => `${i * 11},${40 - (val / 3)}`).join(' ')"
                                fill="none"
                                :stroke="`url(#gradient-${index})`"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <defs>
                                <linearGradient :id="`gradient-${index}`" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" :stop-color="stat.trend === 'up' ? '#10b981' : '#ef4444'" stop-opacity="0.5"/>
                                    <stop offset="100%" :stop-color="stat.trend === 'up' ? '#10b981' : '#ef4444'" stop-opacity="1"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <!-- Activity Feed -->
                <div class="activity-panel panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Recent Activity</h2>
                        <button class="view-all-btn">View All</button>
                    </div>
                    <div class="activity-list">
                        <div 
                            v-for="(activity, index) in activities" 
                            :key="index"
                            class="activity-item"
                            :style="{ animationDelay: `${600 + index * 80}ms` }"
                        >
                            <div class="activity-icon">{{ getActivityIcon(activity.type) }}</div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    <span class="activity-user">{{ activity.user }}</span>
                                    <span class="activity-action">{{ activity.action }}</span>
                                </div>
                                <div class="activity-time">{{ activity.time }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Alerts -->
                <div class="alerts-panel panel">
                    <div class="panel-header">
                        <h2 class="panel-title">System Alerts</h2>
                        <span class="alert-badge">{{ alerts.length }}</span>
                    </div>
                    <div class="alerts-list">
                        <div 
                            v-for="(alert, index) in alerts" 
                            :key="index"
                            class="alert-item"
                            :class="getAlertClass(alert.type)"
                            :style="{ animationDelay: `${800 + index * 100}ms` }"
                        >
                            <div class="alert-priority" :class="alert.priority"></div>
                            <div class="alert-content">
                                <p class="alert-message">{{ alert.message }}</p>
                            </div>
                        </div>
                    </div>
                    <button class="manage-alerts-btn">Manage All Alerts</button>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-panel panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Quick Actions</h2>
                    </div>
                    <div class="actions-grid">
                        <button class="action-btn" style="animation-delay: 1000ms">
                            <span class="action-icon">➕</span>
                            <span class="action-label">Add User</span>
                        </button>
                        <button class="action-btn" style="animation-delay: 1100ms">
                            <span class="action-icon">⚙️</span>
                            <span class="action-label">System Config</span>
                        </button>
                        <button class="action-btn" style="animation-delay: 1200ms">
                            <span class="action-icon">📊</span>
                            <span class="action-label">Reports</span>
                        </button>
                        <button class="action-btn" style="animation-delay: 1300ms">
                            <span class="action-icon">🔒</span>
                            <span class="action-label">Security</span>
                        </button>
                        <button class="action-btn" style="animation-delay: 1400ms">
                            <span class="action-icon">💾</span>
                            <span class="action-label">Backup</span>
                        </button>
                        <button class="action-btn" style="animation-delay: 1500ms">
                            <span class="action-icon">📝</span>
                            <span class="action-label">Audit Logs</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Performance Chart -->
            <div class="chart-panel panel">
                <div class="panel-header">
                    <h2 class="panel-title">Performance Overview</h2>
                    <div class="chart-controls">
                        <button class="chart-btn active">30D</button>
                        <button class="chart-btn">7D</button>
                        <button class="chart-btn">24H</button>
                    </div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" preserveAspectRatio="none" class="performance-chart">
                        <!-- Grid lines -->
                        <line v-for="i in 5" :key="`grid-${i}`" 
                            x1="0" :y1="i * 40" 
                            x2="100%" :y2="i * 40" 
                            stroke="rgba(148, 163, 184, 0.1)" 
                            stroke-width="1"
                        />
                        
                        <!-- Area fill -->
                        <defs>
                            <linearGradient id="chartGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="rgba(139, 92, 246, 0.3)" />
                                <stop offset="100%" stop-color="rgba(139, 92, 246, 0)" />
                            </linearGradient>
                        </defs>
                        
                        <polygon
                            :points="`0,200 ${chartData.map((val, i) => `${(i / (chartData.length - 1)) * 100}%,${200 - (val * 1.5)}`).join(' ')} 100%,200`"
                            fill="url(#chartGradient)"
                        />
                        
                        <!-- Line -->
                        <polyline
                            :points="chartData.map((val, i) => `${(i / (chartData.length - 1)) * 100}%,${200 - (val * 1.5)}`).join(' ')"
                            fill="none"
                            stroke="rgba(139, 92, 246, 1)"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=JetBrains+Mono:wght@500&display=swap');

.dashboard-container {
    font-family: 'DM Sans', sans-serif;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fc 0%, #eef2f7 100%);
    min-height: 100vh;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2.5rem;
    border-radius: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
    animation: slideDown 0.6s ease-out;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.welcome-content {
    color: white;
    z-index: 1;
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.welcome-subtitle {
    font-size: 1.125rem;
    opacity: 0.9;
}

.welcome-time {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.time-label {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.time-value {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'JetBrains Mono', monospace;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.75rem;
    border-radius: 1.25rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: slideUp 0.6s ease-out backwards;
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

.stat-icon-wrapper {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    font-size: 1.75rem;
}

.stat-change {
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    font-family: 'JetBrains Mono', monospace;
}

.stat-change.positive {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.stat-change.negative {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.stat-body {
    margin-bottom: 1rem;
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
    letter-spacing: -0.02em;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.stat-sparkline {
    opacity: 0.6;
    margin-top: 1rem;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.panel {
    background: white;
    padding: 1.75rem;
    border-radius: 1.25rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
}

.panel-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.01em;
}

.view-all-btn {
    font-size: 0.875rem;
    color: #667eea;
    font-weight: 600;
    transition: all 0.2s;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background: transparent;
    border: none;
    cursor: pointer;
}

.view-all-btn:hover {
    background: rgba(102, 126, 234, 0.1);
}

/* Activity List */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-radius: 0.75rem;
    transition: all 0.2s;
    animation: fadeIn 0.5s ease-out backwards;
    border: 1px solid transparent;
}

.activity-item:hover {
    background: #f8fafc;
    border-color: #e2e8f0;
}

.activity-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 0.75rem;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-text {
    margin-bottom: 0.25rem;
    line-height: 1.5;
}

.activity-user {
    font-weight: 600;
    color: #1e293b;
    margin-right: 0.25rem;
}

.activity-action {
    color: #64748b;
}

.activity-time {
    font-size: 0.75rem;
    color: #94a3b8;
    font-family: 'JetBrains Mono', monospace;
}

/* Alerts */
.alert-badge {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-family: 'JetBrains Mono', monospace;
}

.alerts-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.alert-item {
    padding: 1rem 1rem 1rem 1.5rem;
    border-radius: 0.75rem;
    border: 1px solid;
    display: flex;
    gap: 1rem;
    animation: fadeIn 0.5s ease-out backwards;
    position: relative;
}

.alert-priority {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 0.75rem 0 0 0.75rem;
}

.alert-priority.high {
    background: linear-gradient(to bottom, #ef4444, #dc2626);
}

.alert-priority.medium {
    background: linear-gradient(to bottom, #f59e0b, #d97706);
}

.alert-priority.low {
    background: linear-gradient(to bottom, #3b82f6, #2563eb);
}

.alert-message {
    font-size: 0.875rem;
    line-height: 1.5;
}

.manage-alerts-btn {
    width: 100%;
    padding: 0.875rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.manage-alerts-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

/* Quick Actions */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.action-btn {
    padding: 1.25rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeIn 0.5s ease-out backwards;
}

.action-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.action-btn:hover .action-icon,
.action-btn:hover .action-label {
    filter: brightness(0) invert(1);
}

.action-icon {
    font-size: 1.75rem;
}

.action-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #475569;
}

/* Chart Panel */
.chart-panel {
    animation: slideUp 0.6s ease-out 1.6s backwards;
}

.chart-controls {
    display: flex;
    gap: 0.5rem;
}

.chart-btn {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    font-weight: 600;
    font-size: 0.875rem;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'JetBrains Mono', monospace;
}

.chart-btn.active,
.chart-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

.chart-container {
    margin-top: 1.5rem;
}

.performance-chart {
    filter: drop-shadow(0 2px 8px rgba(139, 92, 246, 0.2));
}

/* Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .welcome-banner {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .welcome-time {
        align-self: stretch;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .content-grid {
        grid-template-columns: 1fr;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>