<!DOCTYPE html>
<html>
<head>
    <title>BloodView - Local Test</title>
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
        h1 { color: red; text-align: center; }
        .test-link {
            display: block;
            padding: 15px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .test-link:hover { background-color: #45a049; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🩸 BloodView - Local Test Page</h1>
        
        <div class="status success">
            ✅ <strong>PHP is working!</strong><br>
            PHP Version: <?php echo phpversion(); ?><br>
            Current Time: <?php echo date('Y-m-d H:i:s'); ?>
        </div>

        <h2>🧪 Test Your Pages:</h2>
        
        <a href="test.php" class="test-link">Test PHP Info</a>
        <a href="debug.php" class="test-link">Debug Page (Check for errors)</a>
        <a href="loginexample.php" class="test-link">Login Page (May show database error)</a>
        <a href="homepage.php" class="test-link">Homepage (May show database error)</a>
        
        <h2>🔧 Database Status:</h2>
        <div class="status error">
            ⚠️ <strong>Database not connected locally</strong><br>
            This is normal when running locally without environment variables.<br>
            The pages will work when deployed to Vercel with proper database setup.
        </div>

        <h2>🚀 Next Steps:</h2>
        <ol>
            <li><strong>Test the links above</strong> - Click each one to see what happens</li>
            <li><strong>If you see errors</strong> - That's normal for database-dependent pages</li>
            <li><strong>For full functionality</strong> - Deploy to Vercel with database setup</li>
        </ol>

        <h2>📋 Quick Deployment Test:</h2>
        <p>To test the full application with database:</p>
        <ol>
            <li>Push your code to GitHub</li>
            <li>Deploy to Vercel</li>
            <li>Add the environment variables from VERCEL-READY.md</li>
            <li>Test the live version</li>
        </ol>
    </div>
</body>
</html>

