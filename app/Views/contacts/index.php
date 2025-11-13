<!DOCTYPE html>
<html lang="es">
<head>
    <title>📇 Gestor de Contactos - Rolodex Digital</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 2rem;
        }
        .container { 
            max-width: 1100px; 
            padding-top: 2rem;
        }
        .card { 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
            border: none;
            border-radius: 15px;
            background: white;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .hero-section {
            background: white;
            color: #333;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .stats-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
        }
        .search-box {
            border-radius: 25px;
            border: 2px solid #e0e0e0;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .search-box:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-delete {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .stat-card h5 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="mb-3">📇 Gestor de Contactos Rolodex</h1>
            <p class="mb-4 text-muted">Digitaliza tu agenda física con tecnología moderna</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="/contacts/create" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus"></i> Nuevo Contacto
                </a>
                <a href="/contacts/export" class="btn btn-success btn-lg">
                    <i class="bi bi-download"></i> Exportar CSV
                </a>
            </div>
        </div>
        
        <!-- Alerts -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Search Bar -->
        <?php if (!empty($contacts)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <form method="get" action="/contacts" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               class="form-control search-box" 
                               placeholder="🔍 Buscar por nombre, teléfono o email..."
                               value="<?= esc($searchTerm ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                    <?php if ($searchTerm): ?>
                    <div class="col-12">
                        <a href="/contacts" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-circle"></i> Limpiar búsqueda
                        </a>
                        <span class="ms-2 text-muted">
                            Mostrando <?= count($contacts) ?> resultado(s) para "<?= esc($searchTerm) ?>"
                        </span>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>
                        Lista de Contactos
                    </h4>
                    <span class="stats-badge">
                        <i class="bi bi-person-badge me-1"></i>
                        <?= count($contacts) ?> contacto(s)
                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($contacts)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-person-x display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No hay contactos todavía</h5>
                        <p class="text-muted">Comienza añadiendo tu primer contacto o usa la línea de comandos:</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/contacts/create" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Añadir Primer Contacto
                            </a>
                            <button class="btn btn-outline-secondary" onclick="copyCommand()">
                                <i class="bi bi-terminal"></i> Copiar Comando CLI
                            </button>
                        </div>
                        <div id="commandAlert" class="alert alert-info mt-3" style="display: none;">
                            <small><code>php contact-importer.php</code></small>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i> Nombre</th>
                                    <th><i class="bi bi-telephone me-1"></i> Teléfono</th>
                                    <th><i class="bi bi-envelope me-1"></i> Email</th>
                                    <th class="text-end"><i class="bi bi-gear me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($contact['name']) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['phone'])): ?>
                                            <a href="tel:<?= esc($contact['phone']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone-fill text-success"></i>
                                                <?= esc($contact['phone']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['email'])): ?>
                                            <a href="mailto:<?= esc($contact['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope-fill text-primary"></i>
                                                <?= esc($contact['email']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-danger btn-sm btn-delete" 
                                                onclick="confirmDelete(<?= $contact['index'] ?>, '<?= esc($contact['name']) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row mt-4 g-3">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <i class="bi bi-people display-4"></i>
                                <h5 class="mt-2"><?= count($contacts) ?></h5>
                                <small>Total Contactos</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <?php 
                                $withPhone = count(array_filter($contacts, fn($c) => !empty($c['phone'])));
                                ?>
                                <i class="bi bi-telephone display-4"></i>
                                <h5 class="mt-2"><?= $withPhone ?></h5>
                                <small>Con Teléfono</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <?php 
                                $withEmail = count(array_filter($contacts, fn($c) => !empty($c['email'])));
                                ?>
                                <i class="bi bi-envelope display-4"></i>
                                <h5 class="mt-2"><?= $withEmail ?></h5>
                                <small>Con Email</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Footer Tips -->
        <div class="text-center mt-4">
            <div class="card" style="background: white;">
                <div class="card-body py-3">
                    <small class="text-muted">
                        <i class="bi bi-lightbulb-fill me-1 text-warning"></i>
                        <strong>Tip Pro:</strong> Usa el comando 
                        <code class="bg-light p-1 rounded">php spark import:contacts</code> 
                        para importar contactos rápidamente desde la terminal
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(index, name) {
            if (confirm(`¿Estás seguro de eliminar el contacto "${name}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = `/contacts/delete/${index}`;
            }
        }
        
        // Auto-submit search on input (debounced)
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (e.target.value.length >= 2 || e.target.value.length === 0) {
                    e.target.form.submit();
                }
            }, 500);
        });
    </script>
</body>
</html>
