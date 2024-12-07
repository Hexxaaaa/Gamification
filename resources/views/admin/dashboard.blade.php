@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
.stats-card {
    transition: transform 0.2s;
}
.stats-card:hover {
    transform: translateY(-5px);
}
.chart-container {
    min-height: 300px;
}
.dashboard-icon {
    font-size: 2.5rem;
    opacity: 0.7;
}
.stat-value {
    font-size: 2rem;
    font-weight: bold;
    color: #2c3e50;
}
.stat-label {
    color: #7f8c8d;
    font-size: 0.9rem;
    text-transform: uppercase;
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="stat-label">Active Users</p>
                            <h2 class="stat-value">{{ number_format($activeUsers) }}</h2>
                            <p class="text-success mb-0">
                                <i class="fas fa-user-plus me-1"></i>
                                +{{ number_format($newUsers) }} this month
                            </p>
                        </div>
                        <div class="dashboard-icon text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="stat-label">Completed Tasks</p>
                            <h2 class="stat-value">{{ number_format($completedTasks) }}</h2>
                            <p class="text-info mb-0">
                                <i class="fas fa-star me-1"></i>
                                {{ number_format($totalPoints) }} points earned
                            </p>
                        </div>
                        <div class="dashboard-icon text-info">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="stat-label">Daily Active Users</p>
                            <h2 class="stat-value">{{ number_format($dailyActiveUsers) }}</h2>
                            <p class="text-warning mb-0">
                                <i class="fas fa-users me-1"></i>
                                {{ number_format($monthlyActiveUsers) }} monthly
                            </p>
                        </div>
                        <div class="dashboard-icon text-warning">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vouchers Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="stat-label">Redeemed Vouchers</p>
                            <h2 class="stat-value">{{ number_format($redeemedVouchers) }}</h2>
                            <p class="text-danger mb-0">
                                <i class="fas fa-gift me-1"></i>
                                Total redemptions
                            </p>
                        </div>
                        <div class="dashboard-icon text-danger">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- User Registration Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>User Registrations</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

               <!-- Daily Tasks Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-area me-2"></i>Daily Task Completion
                        <small class="text-muted ms-2">(Last 30 days)</small>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="dailyTasksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    <!-- Task Statistics Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Task Statistics</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Description</th>
                            <th>Total Completions</th>
                            <th>Unique Users</th>
                            <th>Last Completion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskStatistics as $task)
                        <tr>
                            <td>#{{ $task->id }}</td>
                            <td>{{ Str::limit($task->description, 50) }}</td>
                            <td><span class="badge bg-success">{{ $task->user_tasks_count }}</span></td>
                            <td><span class="badge bg-info">{{ $task->unique_users_count }}</span></td>
                            <td>{{ $task->last_completion ? date('M d, Y', strtotime($task->last_completion)) : 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Registration Chart
    new Chart(document.getElementById('userRegistrationChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($userRegistrations->pluck('date')) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($userRegistrations->pluck('count')) !!},
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

        
    new Chart(document.getElementById('dailyTasksChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyTasks->pluck('date')->map(function($date) { 
                return \Carbon\Carbon::parse($date)->format('M d');
            })) !!},
            datasets: [{
                label: 'Tasks Completed',
                data: {!! json_encode($dailyTasks->pluck('count')) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#6366f1',
                pointHoverBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    padding: 10,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return 'Completed Tasks: ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 2],
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection