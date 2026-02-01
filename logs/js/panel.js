// Panel de Intranet - JavaScript

// ==========================================================================
// FUNCIONES GLOBALES (deben estar disponibles para onclick)
// ==========================================================================

// Función para ver registro en modal
function verRegistro(tipo, indice, datos) {
    const modal = document.getElementById('verModal');
    const contenido = document.getElementById('verModalContent');
    
    if (!modal || !contenido) {
        console.error('Modal no encontrado');
        return;
    }
    
    let html = '';
    
    if (tipo === 'contacto') {
        html = `
            <div class="detalle-item">
                <div class="detalle-label">Fecha y Hora</div>
                <div class="detalle-value">${datos[0] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Nombre</div>
                <div class="detalle-value">${datos[1] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Empresa</div>
                <div class="detalle-value">${datos[2] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Correo Electrónico</div>
                <div class="detalle-value"><a href="mailto:${datos[3] || ''}" style="color: #003366;">${datos[3] || 'N/A'}</a></div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Teléfono</div>
                <div class="detalle-value">${datos[4] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Asunto</div>
                <div class="detalle-value">${datos[5] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Mensaje</div>
                <div class="detalle-value" style="white-space: pre-wrap;">${datos[6] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Dirección IP</div>
                <div class="detalle-value">${datos[7] || 'N/A'}</div>
            </div>
        `;
    } else if (tipo === 'cotizacion') {
        html = `
            <div class="detalle-item">
                <div class="detalle-label">Fecha y Hora</div>
                <div class="detalle-value">${datos[0] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Nombres</div>
                <div class="detalle-value">${datos[1] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Apellidos</div>
                <div class="detalle-value">${datos[2] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Nombre Completo</div>
                <div class="detalle-value">${(datos[1] || '') + ' ' + (datos[2] || '')}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Empresa</div>
                <div class="detalle-value">${datos[3] || 'N/A'}</div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Correo Electrónico</div>
                <div class="detalle-value"><a href="mailto:${datos[4] || ''}" style="color: #003366;">${datos[4] || 'N/A'}</a></div>
            </div>
            <div class="detalle-item">
                <div class="detalle-label">Mensaje</div>
                <div class="detalle-value" style="white-space: pre-wrap;">${datos[5] || 'N/A'}</div>
            </div>
        `;
    }
    
    contenido.innerHTML = html;
    modal.style.display = "block";
}

// Función para eliminar registro
function eliminarRegistro(tipo, fecha, indice, datos) {
    if (!confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('tipo', tipo);
    formData.append('fecha', fecha);
    formData.append('indice', indice);
    if (datos) {
        formData.append('datos', JSON.stringify(datos));
    }
    
    fetch('/logs/eliminar_registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registro eliminado correctamente');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'No se pudo eliminar el registro'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el registro');
    });
}

// ==========================================================================
// INICIALIZACIÓN CUANDO EL DOM ESTÉ LISTO
// ==========================================================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Manejo de modales - cerrar al hacer clic fuera
    window.onclick = function(event) {
        var modal = document.getElementById('filesModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
        var verModal = document.getElementById('verModal');
        if (event.target == verModal) {
            verModal.style.display = "none";
        }
    };

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const verModal = document.getElementById('verModal');
            if (verModal) {
                verModal.style.display = "none";
            }
            const filesModal = document.getElementById('filesModal');
            if (filesModal) {
                filesModal.style.display = "none";
            }
        }
    });

    // Inicializar gráficos del dashboard si existen
    if (typeof Chart !== 'undefined') {
        setTimeout(initDashboardCharts, 100);
    } else {
        // Si Chart.js no está cargado, intentar de nuevo después de un momento
        setTimeout(function() {
            if (typeof Chart !== 'undefined') {
                initDashboardCharts();
            } else {
                console.warn('Chart.js no está disponible. Los gráficos no se mostrarán.');
            }
        }, 500);
    }
});

// ==========================================================================
// FUNCIONES PARA GRÁFICOS DEL DASHBOARD
// ==========================================================================

// Inicializar gráficos del dashboard
function initDashboardCharts() {
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js no está disponible');
        return;
    }
    
    console.log('Inicializando gráficos del dashboard...');

    // Gráfico de registros por día
    const ctxDias = document.getElementById('chartRegistrosDia');
    if (ctxDias) {
        try {
            const datosDias = JSON.parse(ctxDias.getAttribute('data-chart') || '{}');
            new Chart(ctxDias, {
                type: 'line',
                data: {
                    labels: Object.keys(datosDias),
                    datasets: [{
                        label: 'Registros',
                        data: Object.values(datosDias),
                        borderColor: '#003366',
                        backgroundColor: 'rgba(0, 51, 102, 0.1)',
                        tension: 0.4,
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
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error al crear gráfico de días:', e);
        }
    }

    // Gráfico de registros por hora
    const ctxHora = document.getElementById('chartRegistrosHora');
    if (ctxHora) {
        try {
            const datosHora = JSON.parse(ctxHora.getAttribute('data-chart') || '[]');
            new Chart(ctxHora, {
                type: 'bar',
                data: {
                    labels: Array.from({length: 24}, (_, i) => i + ':00'),
                    datasets: [{
                        label: 'Registros',
                        data: datosHora,
                        backgroundColor: '#FF6600',
                        borderColor: '#e65c00',
                        borderWidth: 1
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
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error al crear gráfico de horas:', e);
        }
    }

    // Gráfico de registros por mes
    const ctxMes = document.getElementById('chartRegistrosMes');
    if (ctxMes) {
        try {
            const datosMes = JSON.parse(ctxMes.getAttribute('data-chart') || '{}');
            new Chart(ctxMes, {
                type: 'bar',
                data: {
                    labels: Object.keys(datosMes).map(m => {
                        const [year, month] = m.split('-');
                        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                        return meses[parseInt(month) - 1] + ' ' + year;
                    }),
                    datasets: [{
                        label: 'Registros',
                        data: Object.values(datosMes),
                        backgroundColor: '#003366',
                        borderColor: '#004488',
                        borderWidth: 1
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
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error al crear gráfico de meses:', e);
        }
    }

    // Gráfico de top empresas
    const ctxEmpresas = document.getElementById('chartTopEmpresas');
    if (ctxEmpresas && ctxEmpresas.style.display !== 'none') {
        try {
            const datosEmpresas = JSON.parse(ctxEmpresas.getAttribute('data-chart') || '{}');
            const labels = Object.keys(datosEmpresas).slice(0, 10);
            const values = Object.values(datosEmpresas).slice(0, 10);
            
            new Chart(ctxEmpresas, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#003366', '#FF6600', '#0b5ed7', '#5a5a5a', '#28a745',
                            '#17a2b8', '#ffc107', '#dc3545', '#6f42c1', '#e83e8c'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error al crear gráfico de empresas:', e);
        }
    }
}
