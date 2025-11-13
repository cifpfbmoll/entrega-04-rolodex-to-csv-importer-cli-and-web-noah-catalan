<?php

/**
 * Rolodex Contact Importer - Web Version
 * 
 * Versión web simple que funciona con el mismo archivo CSV
 * que la aplicación CLI.
 */

// Configuración
define('WRITEPATH', __DIR__ . '/writable/');
$csvFile = WRITEPATH . 'contacts.csv';

// Funciones
function readContacts() {
    global $csvFile;
    $contacts = [];
    
    if (file_exists($csvFile)) {
        $handle = fopen($csvFile, 'r');
        if ($handle) {
            // Saltar cabecera
            fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== false) {
                $contacts[] = [
                    'name' => $row[0] ?? '',
                    'phone' => $row[1] ?? '',
                    'email' => $row[2] ?? ''
                ];
            }
            fclose($handle);
        }
    }
    
    return $contacts;
}

function addContact($name, $phone, $email) {
    global $csvFile;
    
    // Validar
    if (empty(trim($name))) {
        return ['error' => 'El nombre es requerido'];
    }
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['error' => 'Email inválido'];
    }
    
    // Crear archivo si no existe
    if (!file_exists($csvFile)) {
        $handle = fopen($csvFile, 'w');
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        fclose($handle);
    }
    
    // Añadir contacto
    $handle = fopen($csvFile, 'a');
    fputcsv($handle, [trim($name), trim($phone), trim($email)]);
    fclose($handle);
    
    return ['success' => '¡Contacto añadido correctamente!'];
}

// Manejar descarga de CSV
if (isset($_GET['download']) && $_GET['download'] === 'csv') {
    if (file_exists($csvFile)) {
        // Generar nombre con fecha
        $filename = 'contacts_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        readfile($csvFile);
        exit;
    }
}

// Manejar formulario POST
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    $result = addContact($name, $phone, $email);
    $message = $result['error'] ?? $result['success'] ?? '';
}

// Leer contactos
$contacts = readContacts();

// Estadísticas
$total = count($contacts);
$withPhone = count(array_filter($contacts, fn($c) => !empty($c['phone'])));
$withEmail = count(array_filter($contacts, fn($c) => !empty($c['email'])));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>📇 Rolodex Contact Importer - Web Version</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container { 
            max-width: 1000px; 
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .card { 
            box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
            border: none;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px 16px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .alert {
            border-radius: 10px;
            border: none;
            animation: slideIn 0.3s ease;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
        }
        .hero-section {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .required-star {
            color: #dc3545;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="display-4 mb-3">📇 Rolodex Contact Importer</h1>
            <p class="lead mb-4">Digitaliza tu agenda física con nuestra herramienta web</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#add-contact" class="btn btn-light btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Añadir Contacto
                </a>
                <a href="?download=csv" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-download me-2"></i>Descargar CSV
                </a>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'error') !== false ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
                <i class="bi bi-<?= strpos($message, 'error') !== false ? 'exclamation-triangle' : 'check-circle' ?>-fill me-2"></i>
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <i class="bi bi-people-fill display-4 mb-2"></i>
                    <h3><?= $total ?></h3>
                    <small>Total Contactos</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <i class="bi bi-telephone-fill display-4 mb-2"></i>
                    <h3><?= $withPhone ?></h3>
                    <small>Con Teléfono</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <i class="bi bi-envelope-fill display-4 mb-2"></i>
                    <h3><?= $withEmail ?></h3>
                    <small>Con Email</small>
                </div>
            </div>
        </div>
        
        <!-- Contacts List -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>
                        Lista de Contactos
                    </h4>
                    <span class="badge bg-white text-dark">
                        <i class="bi bi-person-badge me-1"></i>
                        <?= $total ?> contacto(s)
                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($contacts)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-person-x display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No hay contactos todavía</h5>
                        <p class="text-muted">Añade tu primer contacto usando el formulario de abajo</p>
                        <a href="#add-contact" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Añadir Primer Contacto
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i> Nombre</th>
                                    <th><i class="bi bi-telephone me-1"></i> Teléfono</th>
                                    <th><i class="bi bi-envelope me-1"></i> Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($contact['name']) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['phone'])): ?>
                                            <a href="tel:<?= htmlspecialchars($contact['phone']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone-fill text-success"></i>
                                                <?= htmlspecialchars($contact['phone']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['email'])): ?>
                                            <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope-fill text-primary"></i>
                                                <?= htmlspecialchars($contact['email']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Add Contact Form -->
        <div class="card" id="add-contact">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Añadir Nuevo Contacto
                </h4>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i>
                                Nombre Completo <span class="required-star">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   placeholder="Ej: Juan Pérez"
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone me-1"></i>
                                Teléfono
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone" 
                                   name="phone" 
                                   placeholder="Ej: 555-123-4567">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>
                                Email
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Ej: juan@ejemplo.com">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Guardar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer Info -->
        <div class="text-center mt-4">
            <div class="card bg-light bg-opacity-10">
                <div class="card-body py-3">
                    <small class="text-white">
                        <i class="bi bi-lightbulb me-1"></i>
                        <strong>Tip:</strong> También puedes usar la línea de comandos con 
                        <code>php contact-importer.php</code> para una rápida entrada de datos
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll to add contact form
        document.querySelectorAll('a[href="#add-contact"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector('#add-contact').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Phone formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
