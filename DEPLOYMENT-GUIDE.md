# 🚀 BloodView Deployment Guide

## 📋 Pre-Deployment Checklist

### ✅ Essential Files (Clean Structure)
- [x] `index.php` - Main entry point
- [x] `vercel.json` - Vercel configuration
- [x] `.env` - Environment variables template
- [x] `.gitignore` - Git ignore rules
- [x] `database-schema-postgresql.sql` - Database schema
- [x] `connect.php` - Database connection
- [x] `security-config.php` - Security configuration
- [x] `homepage.php` - Main application page
- [x] `loginexample.php` - Login system
- [x] `registerexample.php` - User registration
- [x] `deposit.php` - Blood deposit functionality
- [x] `withdraw.php` - Blood withdrawal functionality
- [x] `record1.php` - Records management
- [x] `logout.php` - Logout functionality
- [x] `test-connection.php` - Database connection test

### ✅ Database Schema Fixed
- [x] Added `blood_stock` table (matches PHP code)
- [x] Added `withdrawal_records` table (matches PHP code)
- [x] Updated triggers and indexes
- [x] Updated RLS policies

## 🗄️ Step 1: Supabase Database Setup

### 1.1 Access Your Supabase Project
1. Go to [supabase.com](https://supabase.com)
2. Sign in and select project: `wrktgrdplrdlviqlmbwc`

### 1.2 Get Database Credentials
1. Go to **Settings** → **Database**
2. Copy your **Database password** (you'll need this)
3. Copy the **Connection string** (URI format)

### 1.3 Import Database Schema
1. Go to **SQL Editor** in Supabase dashboard
2. Click **New query**
3. Copy the entire content of `database-schema-postgresql.sql`
4. Paste and click **Run**

### 1.4 Verify Tables Created
Go to **Table Editor** and confirm these tables exist:
- `users`
- `blood_stock` ⭐ (newly added)
- `withdrawal_records` ⭐ (newly added)
- `blood_inventory`
- `blood_requests`
- `blood_donations`
- `admin_users`
- `audit_log`
- `sessions`

## 🔑 Step 2: Environment Variables Setup

### 2.1 Get Supabase API Keys
1. Go to **Settings** → **API**
2. Copy these values:
   - **Project URL**: `https://wrktgrdplrdlviqlmbwc.supabase.co`
   - **anon public** key (starts with `eyJ...`)
   - **service_role** key (starts with `eyJ...`)

### 2.2 Update Environment Variables
Replace the placeholders in your `.env` file:

```bash
# Replace [YOUR_DB_PASSWORD] with your actual Supabase database password
DATABASE_URL=postgresql://postgres:YOUR_ACTUAL_PASSWORD@db.wrktgrdplrdlviqlmbwc.supabase.co:5432/postgres
DB_PASSWORD=YOUR_ACTUAL_PASSWORD

# Replace with your actual Supabase URL
APP_URL=https://your-app-name.vercel.app
```

## 🚀 Step 3: Deploy to Vercel

### 3.1 Prepare Your Repository
1. **Commit all changes** to your Git repository
2. **Push to GitHub** (or your preferred Git provider)

### 3.2 Deploy with Vercel

#### Option A: One-Click Deploy (Recommended)
1. Click the "Deploy with Vercel" button in your README.md
2. Connect your GitHub account
3. Select your repository
4. Configure environment variables (see Step 3.3)

#### Option B: Manual Deploy
1. Go to [vercel.com](https://vercel.com)
2. Sign in with GitHub
3. Click **New Project**
4. Import your repository
5. Configure settings (see Step 3.3)

### 3.3 Configure Environment Variables in Vercel
In your Vercel project dashboard, go to **Settings** → **Environment Variables** and add:

```bash
DATABASE_URL=postgresql://postgres:YOUR_PASSWORD@db.wrktgrdplrdlviqlmbwc.supabase.co:5432/postgres
DB_HOST=db.wrktgrdplrdlviqlmbwc.supabase.co
DB_PASSWORD=YOUR_PASSWORD
DB_USERNAME=postgres
DB_NAME=postgres
SUPABASE_URL=https://wrktgrdplrdlviqlmbwc.supabase.co
SUPABASE_ANON_KEY=your_anon_key_here
SUPABASE_SERVICE_ROLE_KEY=your_service_key_here
APP_ENV=production
APP_DEBUG=false
USE_DB_SESSIONS=true
```

### 3.4 Deploy
1. Click **Deploy**
2. Wait for deployment to complete
3. Note your deployment URL

## 🧪 Step 4: Testing Your Deployment

### 4.1 Test Database Connection
1. Visit: `https://your-app.vercel.app/test-connection.php`
2. Should show: ✅ **SUCCESS: Connected to Supabase database!**

### 4.2 Test Application Features
1. **Registration**: Create a new user account
2. **Login**: Sign in with your credentials
3. **Blood Management**: Add blood deposits and withdrawals
4. **Records View**: Check blood availability display

### 4.3 Default Admin Access
- **Username**: `admin`
- **Password**: `admin123`
- ⚠️ **Change these credentials in production!**

## 🔧 Step 5: Post-Deployment Configuration

### 5.1 Update App URL
1. In Vercel dashboard, copy your deployment URL
2. Update `APP_URL` environment variable
3. Redeploy if necessary

### 5.2 Security Hardening
1. **Change default admin password**
2. **Enable HTTPS** (automatic with Vercel)
3. **Review RLS policies** in Supabase
4. **Monitor logs** for any issues

### 5.3 Performance Optimization
1. **Enable Cloudflare CDN** (optional)
2. **Monitor database performance**
3. **Set up monitoring alerts**

## 🆘 Troubleshooting

### Database Connection Issues
- ✅ Verify `DB_PASSWORD` is correct
- ✅ Check `DATABASE_URL` format
- ✅ Ensure Supabase project is not paused
- ✅ Test connection with `test-connection.php`

### Deployment Issues
- ✅ Check all environment variables are set
- ✅ Verify `vercel.json` configuration
- ✅ Check Vercel build logs for errors
- ✅ Ensure all PHP files are committed

### Application Issues
- ✅ Check browser console for JavaScript errors
- ✅ Verify database tables exist
- ✅ Test with default admin credentials
- ✅ Check Supabase logs for database errors

## 📊 Monitoring & Maintenance

### Regular Tasks
- [ ] Monitor application performance
- [ ] Check database usage
- [ ] Review security logs
- [ ] Update dependencies
- [ ] Backup database regularly

### Scaling Considerations
- **Vercel**: Automatic scaling (free tier: 100GB bandwidth/month)
- **Supabase**: Monitor usage (free tier: 500MB database, 50K users/month)
- **Cloudflare**: Unlimited bandwidth (free tier)

## 🎉 Success!

Your BloodView application should now be live and fully functional! 

### Next Steps
1. **Share your application** with users
2. **Monitor performance** and usage
3. **Plan for scaling** as your user base grows
4. **Consider premium features** if needed

---

**Need Help?** Check the troubleshooting section above or create an issue in your repository.
