<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Contact Import Command
 * 
 * Interactive CLI tool for importing contacts from physical Rolodex to CSV format.
 * Integrated with CodeIgniter 4 Spark command system.
 */
class ContactImport extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Import';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'import:contacts';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Import contacts from physical Rolodex cards to CSV format';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'import:contacts';

    /**
     * CSV file path
     *
     * @var string
     */
    private $csvFilePath;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->csvFilePath = WRITEPATH . 'contacts.csv';
    }

    /**
     * Actually execute the command
     *
     * @param array $params
     */
    public function run(array $params)
    {
        // Display welcome banner
        CLI::write('===========================================', 'green');
        CLI::write('  📇 Rolodex Contact Importer', 'green');
        CLI::write('===========================================', 'green');
        CLI::newLine();
        CLI::write('Enter contact information from your physical Rolodex.');
        CLI::write('Type "exit" or "quit" at the Name prompt to finish.');
        CLI::newLine();

        // Initialize CSV file with header if needed
        $this->initializeCsvFile();

        // Main input loop
        $contactCount = 0;
        while (true) {
            CLI::write('-------------------------------------------', 'yellow');
            
            // Prompt for Full Name
            $name = CLI::prompt('Full Name');
            
            // Check for exit condition
            if (strtolower(trim($name)) === 'exit' || strtolower(trim($name)) === 'quit') {
                CLI::newLine();
                CLI::write("✓ Import session completed. Total contacts added: {$contactCount}", 'green');
                CLI::write("📁 CSV file location: {$this->csvFilePath}", 'cyan');
                CLI::newLine();
                break;
            }

            // Skip if name is empty
            if (empty(trim($name))) {
                CLI::error('✗ Name cannot be empty. Please try again or type "exit" to quit.');
                CLI::newLine();
                continue;
            }

            // Prompt for Phone Number
            $phone = CLI::prompt('Phone Number (optional)');

            // Prompt for Email Address
            $email = CLI::prompt('Email Address (optional)');

            // Validate email if provided
            if (!empty(trim($email)) && !filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                CLI::error('✗ Invalid email format. Contact saved without email.');
                $email = '';
            }

            // Append contact to CSV
            if ($this->appendContactToCsv($name, $phone, $email)) {
                $contactCount++;
                CLI::write("✓ Contact saved successfully! ({$contactCount} total)", 'green');
            } else {
                CLI::error("✗ Failed to save contact. Please try again.");
            }

            CLI::newLine();
        }

        // Show summary
        if ($contactCount > 0) {
            CLI::write('===========================================', 'green');
            CLI::write("📊 Session Summary:", 'white');
            CLI::write("   • Total contacts added: {$contactCount}", 'white');
            CLI::write("   • CSV file: {$this->csvFilePath}", 'cyan');
            CLI::write('===========================================', 'green');
        }
    }

    /**
     * Initialize CSV file with header if it doesn't exist or is empty
     */
    private function initializeCsvFile(): void
    {
        // Check if file exists and is not empty
        if (!file_exists($this->csvFilePath) || filesize($this->csvFilePath) === 0) {
            // Create directory if it doesn't exist
            $directory = dirname($this->csvFilePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Write header row
            $file = fopen($this->csvFilePath, 'w');
            if ($file !== false) {
                fputcsv($file, ['Name', 'Phone', 'Email']);
                fclose($file);
                CLI::write("📄 CSV file initialized: {$this->csvFilePath}", 'cyan');
                CLI::newLine();
            } else {
                CLI::error("✗ Failed to initialize CSV file at: {$this->csvFilePath}");
                CLI::newLine();
            }
        } else {
            // Count existing contacts
            $existingContacts = $this->countExistingContacts();
            CLI::write("📄 Using existing CSV file with {$existingContacts} contact(s)", 'cyan');
            CLI::newLine();
        }
    }

    /**
     * Count existing contacts in CSV file
     *
     * @return int
     */
    private function countExistingContacts(): int
    {
        $count = 0;
        $file = fopen($this->csvFilePath, 'r');
        
        if ($file !== false) {
            // Skip header
            fgetcsv($file);
            
            // Count remaining rows
            while (fgetcsv($file) !== false) {
                $count++;
            }
            
            fclose($file);
        }
        
        return $count;
    }

    /**
     * Append a contact row to the CSV file
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @return bool
     */
    private function appendContactToCsv(string $name, string $phone, string $email): bool
    {
        // Open file in append mode
        $file = fopen($this->csvFilePath, 'a');
        
        if ($file === false) {
            return false;
        }

        // Write the contact data as a CSV row
        $result = fputcsv($file, [
            trim($name),
            trim($phone),
            trim($email)
        ]);

        fclose($file);

        return $result !== false;
    }
}
