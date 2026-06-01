</div> <!-- /.dashboard-wrapper -->

<!-- LOGS MODAL -->
<div id="logsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; overflow-y:auto; padding:30px 0;">
    <div style="background:white; width:700px; max-width:95%; max-height:85vh; margin:0 auto; padding:20px; border-radius:8px; display:flex; flex-direction:column;">
        <h3>Application Logs</h3>
        <div id="logsContainer" style="overflow-y:auto; max-height:65vh; padding-right:6px;"></div>
        <button onclick="$('#logsModal').hide()" class="btn" style="margin-top:15px; align-self:flex-start;">Close</button>
    </div>
</div>

<!-- ASSIGN MODAL -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign HR / TL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assign_application_id">
                <div id="assign_users_list"></div>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>


<script>
    // Status distribution (pie) – unchanged
    const statusLabels = <?= json_encode(array_keys($statusCounts ?? [])) ?>;
    const statusData = <?= json_encode(array_values($statusCounts ?? [])) ?>;

    if (document.getElementById('statusChart')) {
        // Register the datalabels plugin (auto-register works, but we call it for safety)
        Chart.register(ChartDataLabels);

        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut', // modern donut shape
            data: {
                labels: statusLabels.length ? statusLabels : ['No Data'],
                datasets: [{
                    data: statusLabels.length ? statusData : [1],
                    backgroundColor: ['#6366f1', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'], // vibrant palette
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverBorderWidth: 5,
                    spacing: 4, // clean gap between slices
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%', // donut hole size
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyleWidth: 10,
                            padding: 20,
                            font: {
                                size: 12,
                                family: "'Inter', system-ui, sans-serif"
                            },
                            color: '#334155',
                            generateLabels: function(chart) {
                                const data = chart.data;
                                return data.labels.map((label, i) => ({
                                    text: `${label}: ${data.datasets[0].data[i]} (${Math.round((data.datasets[0].data[i] / data.datasets[0].data.reduce((a,b)=>a+b,0))*100)}%)`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    strokeStyle: '#ffffff',
                                    lineWidth: 2,
                                    hidden: false,
                                    index: i
                                }));
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percent = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                return ` ${context.label}: ${context.parsed} (${percent}%)`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#ffffff',
                        font: {
                            weight: 'bold',
                            size: 14,
                            family: 'Inter, system-ui, sans-serif'
                        },
                        // white outline for better contrast
                        textStrokeColor: '#1e293b',
                        textStrokeWidth: 0,
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percent = total > 0 ? Math.round((value / total) * 100) : 0;
                            return percent + '%';
                        },
                        display: (context) => {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                        anchor: 'center',
                        clamp: true,
                        offset: 0,
                        // no background box
                        backgroundColor: null,
                        borderRadius: 0,
                        padding: 0
                    }
                }
            }
        });
    }

    // Roles Pie showing percent chosen per role
    if (document.getElementById('rolesPieChart')) {
        try {
            const pieCanvas = document.getElementById('rolesPieChart');
            const pieCtx = pieCanvas.getContext('2d');
            Chart.register(ChartDataLabels);
            const palette = ['#6366f1', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6', '#3b82f6', '#06b6d4', '#f97316'];
            const bgColors = roleLabels.map((_, i) => palette[i % palette.length]);

            console.debug('rolesPieChart data', {
                roleLabels,
                roleData
            });

            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: roleLabels.length ? roleLabels : ['No Roles'],
                    datasets: [{
                        data: roleLabels.length ? roleData : [0],
                        backgroundColor: bgColors,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#334155'
                            }
                        },
                        datalabels: {
                            color: '#ffffff',
                            font: {
                                weight: '600',
                                size: 12
                            },
                            formatter: (value, ctx) => {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                return total > 0 ? Math.round((value / total) * 100) + '%' : '';
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                    return ` ${context.label}: ${context.parsed} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
                } catch (err) {
                    console.error('rolesPieChart error', err);
                    // Replace canvas with server-side SVG fallback if available
                    const el = document.getElementById('rolesPieChart');
                    const fallback = document.getElementById('rolesSvgFallback');
                    if (el && el.parentNode && fallback) {
                        // insert fallback content
                        const wrapper = document.createElement('div');
                        wrapper.style.width = '100%';
                        wrapper.style.height = '260px';
                        wrapper.innerHTML = fallback.innerHTML;
                        el.parentNode.replaceChild(wrapper, el);
                    } else if (el && el.parentNode) {
                        const msg = document.createElement('div');
                        msg.style.padding = '18px';
                        msg.textContent = 'Chart unavailable';
                        el.parentNode.replaceChild(msg, el);
                    }
                }
    }
    // 📊 REDESIGNED: Applications Per Role (horizontal bar with gradient)
    const roleLabels = <?= json_encode(array_keys($roleCounts ?? [])) ?>;
    const roleData = <?= json_encode(array_values($roleCounts ?? [])) ?>;

    if (document.getElementById('roleChart')) {
        const ctx = document.getElementById('roleChart').getContext('2d');

        // Create gradient for bars
        const gradient = ctx.createLinearGradient(0, 0, 400, 0);
        gradient.addColorStop(0, '#1e3a8a'); // deep blue
        gradient.addColorStop(1, '#3b82f6'); // lighter blue

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: roleLabels.length ? roleLabels : ['No Roles'],
                datasets: [{
                    label: 'Applications',
                    data: roleLabels.length ? roleData : [0],
                    backgroundColor: gradient,
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                indexAxis: 'y', // horizontal bars
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            font: {
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#334155'
                        }
                    }
                },
                // Value labels on bars
                animation: {
                    onComplete: function() {
                        const chartInstance = this;
                        const ctx = chartInstance.ctx;
                        ctx.font = Chart.helpers.fontString(
                            Chart.defaults.font.size,
                            'bold',
                            Chart.defaults.font.family
                        );
                        ctx.fillStyle = '#ffffff';
                        ctx.textAlign = 'left';
                        ctx.textBaseline = 'middle';
                        this.data.datasets.forEach(function(dataset, i) {
                            const meta = chartInstance.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                const data = dataset.data[index];
                                if (data > 0) {
                                    ctx.fillText(data, bar.x - 30, bar.y);
                                }
                            });
                        });
                    }
                }
            }
        });
    }

    // AJAX status update
    document.querySelectorAll('.statusForm').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const status = this.querySelector('select').value;
            try {
                const resp = await fetch('<?= base_url('admin/update-status/') ?>' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'status=' + encodeURIComponent(status)
                });
                if (resp.ok) {
                    document.getElementById('status-text-' + id).innerHTML = `<span class="status-badge ${status.toLowerCase()}">${status}</span>`;
                    showToast('Status updated to ' + status);
                } else {
                    showToast('Error updating status', true);
                }
            } catch (error) {
                showToast('Error updating status', true);
            }
        });
    });

    // Assign HR/TL
    $(document).on('click', '.openAssignModal', function() {
        const appId = $(this).data('id');
        $('#assign_application_id').val(appId);
        $.get('<?= base_url('admin/get-assignable-users') ?>', function(users) {
            let html = '';
            if (!users || users.length === 0) {
                html = '<div class="alert alert-warning">No HR/TL users available.</div>';
            } else {
                users.forEach(function(user) {
                    html += `<div class="border rounded p-2 mb-2">
                                <strong>${user.name}</strong> (${user.role})
                                <button class="btn btn-primary btn-sm float-end assign-user" data-user-id="${user.id}">Assign</button>
                            </div>`;
                });
            }
            $('#assign_users_list').html(html);
            $('#assignModal').modal('show');
        });
    });

    $(document).on('click', '.assign-user', function() {
        const userId = $(this).data('user-id');
        const appId = $('#assign_application_id').val();
        const btn = $(this);
        btn.prop('disabled', true).text('Assigning...');
        $.post('<?= base_url('admin/assign-application') ?>', {
            application_id: appId,
            user_id: userId
        }, function(res) {
            if (res.success) {
                location.reload();
            } else {
                showToast('Assignment failed: ' + (res.error || 'Unknown error'), true);
                btn.prop('disabled', false).text('Assign');
            }
        }).fail(function() {
            showToast('Server error', true);
            btn.prop('disabled', false).text('Assign');
        });
    });

    // Logs eye icon
    $(document).on('click', '.viewLogs', function() {
        const id = $(this).data('id');
        $.get('<?= base_url('admin/application-logs') ?>/' + id, function(logs) {
            let html = '';
            if (logs && logs.length) {
                logs.forEach(function(log) {
                    html += `<div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
                                <strong>${log.action}</strong><br>${log.description}<br><small>${log.created_at}</small>
                            </div>`;
                });
            } else {
                html = '<div class="alert alert-info">No logs found.</div>';
            }
            $('#logsContainer').html(html);
            $('#logsModal').show();
        });
    });

    function showToast(message, isError = false) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = 'toast show' + (isError ? ' error-toast' : '');
        clearTimeout(toast.hideTimeout);
        toast.hideTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
    }
</script>


</body>

</html>
