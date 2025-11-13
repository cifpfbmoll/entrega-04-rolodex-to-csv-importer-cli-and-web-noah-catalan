<?php

namespace App\Controllers;

class Contacts extends BaseController
{
    // 📋 Mostrar todos los contactos con búsqueda y filtrado
    public function index()
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        $contacts = [];
        $searchTerm = $this->request->getGet('search');
        
        if (file_exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            if ($handle) {
                // Saltar la cabecera
                fgetcsv($handle);
                
                $index = 0;
                // Leer todos los contactos
                while (($row = fgetcsv($handle)) !== false) {
                    $contact = [
                        'index' => $index,
                        'name' => $row[0] ?? '',
                        'phone' => $row[1] ?? '',
                        'email' => $row[2] ?? ''
                    ];
                    
                    // Filtrar por búsqueda si existe
                    if ($searchTerm) {
                        $searchLower = strtolower($searchTerm);
                        if (
                            strpos(strtolower($contact['name']), $searchLower) !== false ||
                            strpos(strtolower($contact['phone']), $searchLower) !== false ||
                            strpos(strtolower($contact['email']), $searchLower) !== false
                        ) {
                            $contacts[] = $contact;
                        }
                    } else {
                        $contacts[] = $contact;
                    }
                    
                    $index++;
                }
                fclose($handle);
            }
        }
        
        return view('contacts/index', [
            'contacts' => $contacts,
            'searchTerm' => $searchTerm
        ]);
    }
    
    // ➕ Formulario para añadir contacto
    public function create()
    {
        return view('contacts/create');
    }
    
    // 💾 Guardar nuevo contacto con validación mejorada
    public function store()
    {
        // Validar datos con CodeIgniter 4
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[100]',
            'phone' => 'permit_empty|min_length[7]|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]'
        ], [
            'name' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 2 caracteres',
                'max_length' => 'El nombre no puede exceder 100 caracteres'
            ],
            'phone' => [
                'min_length' => 'El teléfono debe tener al menos 7 caracteres',
                'max_length' => 'El teléfono no puede exceder 20 caracteres'
            ],
            'email' => [
                'valid_email' => 'Formato de email inválido',
                'max_length' => 'El email no puede exceder 100 caracteres'
            ]
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        
        // Verificar duplicados
        if ($this->isDuplicate($name, $email)) {
            return redirect()->back()->withInput()->with('error', '⚠️ Ya existe un contacto con ese nombre o email');
        }
        
        // Añadir al CSV
        $csvFile = WRITEPATH . 'contacts.csv';
        
        // Crear archivo si no existe
        if (!file_exists($csvFile)) {
            $handle = fopen($csvFile, 'w');
            fputcsv($handle, ['Name', 'Phone', 'Email']);
            fclose($handle);
        }
        
        // Añadir nuevo contacto
        $handle = fopen($csvFile, 'a');
        fputcsv($handle, [trim($name), trim($phone), trim($email)]);
        fclose($handle);
        
        return redirect()->to('/contacts')->with('success', '✅ ¡Contacto añadido correctamente!');
    }
    
    // �️ Eliminar contacto
    public function delete($index)
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        
        if (!file_exists($csvFile)) {
            return redirect()->to('/contacts')->with('error', '❌ Archivo no encontrado');
        }
        
        // Leer todos los contactos
        $contacts = [];
        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle); // Guardar cabecera
        
        $currentIndex = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if ($currentIndex != $index) {
                $contacts[] = $row;
            }
            $currentIndex++;
        }
        fclose($handle);
        
        // Reescribir el archivo
        $handle = fopen($csvFile, 'w');
        fputcsv($handle, $header);
        foreach ($contacts as $contact) {
            fputcsv($handle, $contact);
        }
        fclose($handle);
        
        return redirect()->to('/contacts')->with('success', '🗑️ Contacto eliminado correctamente');
    }
    
    // �📥 Exportar a CSV mejorado
    public function export()
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        
        if (!file_exists($csvFile)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        // Generar nombre con fecha
        $filename = 'contacts_' . date('Y-m-d_His') . '.csv';
        
        // Descargar el archivo
        return $this->response->download($csvFile, null)->setFileName($filename);
    }
    
    // 🔍 Verificar duplicados
    private function isDuplicate($name, $email): bool
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        
        if (!file_exists($csvFile)) {
            return false;
        }
        
        $handle = fopen($csvFile, 'r');
        fgetcsv($handle); // Saltar cabecera
        
        while (($row = fgetcsv($handle)) !== false) {
            $existingName = trim($row[0] ?? '');
            $existingEmail = trim($row[2] ?? '');
            
            // Comparar ignorando mayúsculas/minúsculas
            if (
                strcasecmp($existingName, trim($name)) === 0 ||
                (!empty($email) && !empty($existingEmail) && strcasecmp($existingEmail, trim($email)) === 0)
            ) {
                fclose($handle);
                return true;
            }
        }
        
        fclose($handle);
        return false;
    }
}
