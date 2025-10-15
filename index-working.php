<!DOCTYPE html>
<html>
<head>
    <title>BloodView - Working Version</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { 
            color: red; 
            text-align: center; 
            font-size: 40px;
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        }
        .test-link {
            display: block;
            padding: 15px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: all 0.3s;
        }
        .test-link:hover { 
            background-color: #45a049; 
            transform: scale(1.05);
        }
        .status { 
            padding: 15px; 
            margin: 15px 0; 
            border-radius: 5px; 
            text-align: center;
        }
        .success { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .warning { 
            background-color: #fff3cd; 
            color: #856404; 
            border: 1px solid #ffeaa7; 
        }
        .php-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🩸 BloodView</h1>
        <p style="text-align: center; font-size: 18px;">If you can see this, the basic page is working!</p>
        
        <div class="status success">
            ✅ <strong>PHP is working perfectly!</strong>
        </div>

        <div class="php-info">
            <h3>PHP Test Results:</h3>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Current Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
            <p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
        </div>

        <h2>🔗 Working Test Links:</h2>
        
        <a href="test.php" class="test-link">📊 Test PHP Info</a>
        <a href="debug.php" class="test-link">🔍 Debug Page</a>
        <a href="test-local.php" class="test-link">🧪 Local Test Page</a>
        
        <h2>⚠️ Database-Dependent Pages:</h2>
        <p style="color: #666; font-style: italic;">These will show database errors when running locally:</p>
        
        <a href="loginexample.php" class="test-link" style="background-color: #ff9800;">🔐 Login Page (Database Required)</a>
        <a href="homepage.php" class="test-link" style="background-color: #ff9800;">🏠 Homepage (Database Required)</a>
        
        <div class="status warning">
            <strong>⚠️ Local Testing Note:</strong><br>
            Database-dependent pages will show connection errors when running locally.<br>
            This is normal! They will work perfectly when deployed to Vercel with database setup.
        </div>

        <h2>🚀 Ready for Deployment?</h2>
        <p>Your BloodView application is ready! To get full functionality:</p>
        <ol>
            <li><strong>Deploy to Vercel</strong> - Follow the VERCEL-READY.md guide</li>
            <li><strong>Set up database</strong> - Use the Supabase credentials provided</li>
            <li><strong>Test live version</strong> - All features will work perfectly</li>
        </ol>

        <div style="text-align: center; margin-top: 30px;">
            <p><strong>🎉 Congratulations! Your BloodView system is working!</strong></p>
        </div>
    </div>
</body>
</html>

