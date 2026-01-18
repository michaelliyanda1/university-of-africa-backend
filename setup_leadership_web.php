<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Management Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1C60A4;
            text-align: center;
            margin-bottom: 30px;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            border-left: 4px solid #1C60A4;
            background: #f8f9fa;
        }
        .step h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .btn {
            background: #1C60A4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #145a8a;
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .output {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            margin: 10px 0;
            max-height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
        }
        .success {
            color: #38a169;
            font-weight: bold;
        }
        .error {
            color: #e53e3e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👑 Leadership Management Setup</h1>
        
        <div class="step">
            <h3>Step 1: Create Database Table</h3>
            <p>Run the migration to create the leadership_items table in your database.</p>
            <button class="btn" onclick="runMigration()">Run Migration</button>
            <div id="migration-output" class="output" style="display:none;"></div>
        </div>

        <div class="step">
            <h3>Step 2: Populate with Dummy Data</h3>
            <p>Add the sample leadership data to the database (4 leaders with their information).</p>
            <button class="btn" onclick="runSeeder()">Run Seeder</button>
            <div id="seeder-output" class="output" style="display:none;"></div>
        </div>

        <div class="step">
            <h3>Step 3: Link Storage</h3>
            <p>Create the symbolic link for file uploads (leadership images).</p>
            <button class="btn" onclick="linkStorage()">Link Storage</button>
            <div id="storage-output" class="output" style="display:none;"></div>
        </div>

        <div class="step">
            <h3>🎉 Setup Complete!</h3>
            <p>Once all steps are completed, you can:</p>
            <ul>
                <li><strong>Manage Leadership:</strong> <a href="/admin/leadership" target="_blank">http://localhost:3000/admin/leadership</a></li>
                <li><strong>View Leadership Page:</strong> <a href="/about/leadership" target="_blank">http://localhost:3000/about/leadership</a></li>
                <li><strong>Upload Images:</strong> Edit each leader in the CMS to add their photos</li>
            </ul>
        </div>
    </div>

    <script>
        function showOutput(elementId, output, isError = false) {
            const element = document.getElementById(elementId);
            element.style.display = 'block';
            element.textContent = output;
            element.className = isError ? 'output error' : 'output';
        }

        function runMigration() {
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Running...';
            
            fetch('setup_leadership_web.php?action=migrate')
                .then(response => response.text())
                .then(data => {
                    showOutput('migration-output', data);
                    btn.textContent = '✓ Migration Complete';
                    btn.style.background = '#38a169';
                })
                .catch(error => {
                    showOutput('migration-output', 'Error: ' + error.message, true);
                    btn.disabled = false;
                    btn.textContent = 'Run Migration';
                });
        }

        function runSeeder() {
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Running...';
            
            fetch('setup_leadership_web.php?action=seeder')
                .then(response => response.text())
                .then(data => {
                    showOutput('seeder-output', data);
                    btn.textContent = '✓ Seeder Complete';
                    btn.style.background = '#38a169';
                })
                .catch(error => {
                    showOutput('seeder-output', 'Error: ' + error.message, true);
                    btn.disabled = false;
                    btn.textContent = 'Run Seeder';
                });
        }

        function linkStorage() {
            const btn = event.target;
            btn.disabled = true;
            btn.textContent = 'Running...';
            
            fetch('setup_leadership_web.php?action=storage')
                .then(response => response.text())
                .then(data => {
                    showOutput('storage-output', data);
                    btn.textContent = '✓ Storage Linked';
                    btn.style.background = '#38a169';
                })
                .catch(error => {
                    showOutput('storage-output', 'Error: ' + error.message, true);
                    btn.disabled = false;
                    btn.textContent = 'Link Storage';
                });
        }
    </script>
</body>
</html>

<?php
// Handle AJAX requests
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'migrate':
            $output = shell_exec('php artisan migrate --force 2>&1');
            echo $output;
            break;
            
        case 'seeder':
            $output = shell_exec('php artisan db:seed --class=LeadershipItemSeeder 2>&1');
            echo $output;
            break;
            
        case 'storage':
            $output = shell_exec('php artisan storage:link 2>&1');
            echo $output;
            break;
    }
    exit;
}
?>
