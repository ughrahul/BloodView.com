@echo off
echo 🩸 BloodView - Vercel Ready Deployment
echo ====================================
echo.

echo ✅ Your project is 100%% Vercel ready!
echo.
echo 📋 Quick Deployment Steps:
echo.
echo 1. Push to GitHub:
echo    git add .
echo    git commit -m "Vercel ready deployment"
echo    git push
echo.
echo 2. Go to https://vercel.com
echo    - Sign in with GitHub
echo    - Click "New Project"
echo    - Import your repository
echo    - Click "Deploy"
echo.
echo 3. Add Environment Variables:
echo    - DATABASE_URL: postgresql://postgres:Rhunk9808*#@db.wrktgrdplrdlviqlmbwc.supabase.co:5432/postgres
echo    - DB_HOST: db.wrktgrdplrdlviqlmbwc.supabase.co
echo    - DB_PASSWORD: Rhunk9808*#
echo    - DB_USERNAME: postgres
echo    - DB_NAME: postgres
echo    - SUPABASE_URL: https://wrktgrdplrdlviqlmbwc.supabase.co
echo    - APP_ENV: production
echo    - APP_DEBUG: false
echo.
echo 4. Import Database Schema:
echo    - Go to Supabase SQL Editor
echo    - Copy content from database-schema-postgresql.sql
echo    - Paste and run
echo.
echo 5. Test your app:
echo    - Visit your Vercel URL
echo    - Register new account
echo    - Login and test features
echo.
echo 🎉 Your BloodView app will be live!
echo.
echo 📖 For detailed instructions, see VERCEL-READY.md
echo.
pause
