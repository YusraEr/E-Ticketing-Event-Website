// Chart initialization
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('userActivityChart').getContext('2d');
    const userActivityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'User Activity',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)'
                    }
                }
            }
        }
    });

    initReportCharts();
});

// Add data refresh functionality
function refreshStats() {
    fetch('/api/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            // Update stats cards with animation
            updateStatsWithAnimation(data);
        });
}

function updateStatsWithAnimation(data) {
    const elements = document.querySelectorAll('.stats-card');
    elements.forEach(el => {
        const target = el.getAttribute('data-target');
        if (data[target]) {
            animateValue(el, parseInt(el.textContent), data[target], 1000);
        }
    });
}

// Initialize Report Charts

function initReportCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [3000, 3500, 4200, 4800, 5200, 6000],
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)',
                        callback: value => `Rp .${value}`
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)'
                    }
                }
            }
        }
    });

    // User Growth Chart
    const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(growthCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'New Users',
                data: [65, 59, 80, 81],
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: 'rgb(148, 163, 184)'
                    }
                }
            }
        }
    });
}

// User Management
let editingUser = null;

function editUser(userId) {

    fetch(`/api/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            editingUser = data;
            Alpine.store('editingUser', data);
            Alpine.store('showUserModal', true);
        });
}

function updateUser(data) {
    fetch(`/api/users/${editingUser.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        refreshUsers();
        Alpine.store('showUserModal', false);
    });
}

// Event Management
let editingEvent = null;

function createEvent() {
    editingEvent = { name: '', description: '', event_date: '', image: null };
    Alpine.store('editingEvent', editingEvent);
    Alpine.store('showEventModal', true);
}

function editEvent(eventId) {
    fetch(`/api/events/${eventId}`)
        .then(response => response.json())
        .then(data => {
            editingEvent = data;
            Alpine.store('editingEvent', data);
            Alpine.store('showEventModal', true);
        });
}

function saveEvent(data) {
    const formData = new FormData();
    Object.keys(data).forEach(key => formData.append(key, data[key]));

    fetch(editingEvent.id ? `/api/events/${editingEvent.id}` : '/api/events', {
        method: editingEvent.id ? 'PUT' : 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        refreshEvents();
        Alpine.store('showEventModal', false);
    });
}

function deleteEvent(eventId) {
    if (confirm('Are you sure you want to delete this event?')) {
        fetch(`/api/events/${eventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(() => refreshEvents());
    }
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    editingEvent.image = file;
}




