# BloodView - Blood Bank Management System

A modern blood bank management system built with PHP, deployed on Vercel with Supabase database and Cloudflare CDN.

## 🚀 Live Demo
[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https://github.com/yourusername/bloodview)

## 🏗️ Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP 8.1+
- **Database**: PostgreSQL (Supabase)
- **Hosting**: Vercel (Serverless)
- **CDN**: Cloudflare
- **Security**: Built-in CSRF, XSS, SQL injection protection

## ✨ Features

- 🔐 **Secure Authentication**: User registration and login system
- 🩸 **Blood Inventory Management**: Track blood types and quantities
- 📊 **Blood Availability**: Real-time blood availability checking
- 👥 **User Management**: Admin panel for user management
- 📱 **Responsive Design**: Works on all devices
- 🛡️ **Security**: Enterprise-grade security features
- ⚡ **Performance**: Optimized for speed and scalability

## 🚀 Quick Deployment

### Option 1: One-Click Deploy (Recommended)
1. Click the "Deploy with Vercel" button above
2. Connect your GitHub account
3. Configure environment variables (see below)
4. Deploy!

### Option 2: Manual Deployment
Follow the detailed guide in [DEPLOYMENT-GUIDE.md](DEPLOYMENT-GUIDE.md)

## ⚙️ Environment Variables

Set these in your Vercel dashboard:

```bash
# Database (from Supabase)
DATABASE_URL=postgresql://postgres:[password]@[host]:5432/postgres
DB_HOST=your-supabase-host.supabase.co
DB_PASSWORD=your-supabase-password

# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

# Security
USE_DB_SESSIONS=true
```

## 🗄️ Database Setup

1. Create a Supabase project
2. Run the SQL script from `database-schema-postgresql.sql`
3. Copy connection details to environment variables

## 🛡️ Security Features

- ✅ CSRF Protection
- ✅ XSS Prevention
- ✅ SQL Injection Protection
- ✅ Rate Limiting
- ✅ Secure Sessions
- ✅ Input Validation
- ✅ Security Headers
- ✅ HTTPS Enforcement

## 📁 Project Structure

```
bloodview/
├── index.php                    # Main entry point
├── connect.php                   # Database connection
├── security-config.php          # Security configuration
├── homepage.php                 # Main application page
├── loginexample.php             # Login system
├── registerexample.php          # User registration
├── check_availability.php        # Blood availability checker
├── get_blood_availability.php   # API endpoint
├── deposit.php                  # Blood deposit functionality
├── withdraw.php                 # Blood withdrawal functionality
├── record1.php                  # Records management
├── logout.php                   # Logout functionality
├── test-connection.php          # Database connection test
├── vercel.json                  # Vercel configuration
├── database-schema-postgresql.sql # Database schema
├── DEPLOYMENT-GUIDE.md          # Detailed deployment guide
└── .gitignore                   # Git ignore rules
```

## 🎯 Default Credentials

**⚠️ Change these in production!**

- **Admin Username**: `admin`
- **Admin Password**: `admin123`

## 📊 Performance

- **Global CDN**: Cloudflare edge network
- **Serverless**: Automatic scaling with Vercel
- **Database**: Optimized PostgreSQL with Supabase
- **Caching**: Built-in caching strategies
- **Security**: Enterprise-grade protection

## 🔧 Development

### Local Development
1. Clone the repository
2. Set up local PHP environment
3. Configure local database
4. Update `env.example` to `.env`
5. Run the application

### Production Deployment
Follow the [DEPLOYMENT-GUIDE.md](DEPLOYMENT-GUIDE.md) for step-by-step instructions.

## 📈 Monitoring

- **Vercel Analytics**: Built-in performance monitoring
- **Supabase Dashboard**: Database performance metrics
- **Cloudflare Analytics**: Traffic and security insights

## 💰 Cost

### Free Tier (Sufficient for most projects):
- **Vercel**: 100GB bandwidth/month
- **Supabase**: 500MB database, 50K users/month
- **Cloudflare**: Unlimited bandwidth

### Paid Plans (If needed):
- **Vercel Pro**: $20/month
- **Supabase Pro**: $25/month
- **Cloudflare Pro**: $20/month

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 🆘 Support

- **Documentation**: Check [DEPLOYMENT-GUIDE.md](DEPLOYMENT-GUIDE.md)
- **Issues**: Create an issue on GitHub
- **Discussions**: Use GitHub Discussions for questions

## 🌟 Features Roadmap

- [ ] Real-time notifications
- [ ] Mobile app
- [ ] Advanced analytics
- [ ] Multi-language support
- [ ] API documentation
- [ ] Automated testing

---

**Built with ❤️ for blood bank management**