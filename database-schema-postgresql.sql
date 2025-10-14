-- BloodView PostgreSQL Database Schema for Supabase
-- This file contains the complete database structure optimized for PostgreSQL

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    blood_type VARCHAR(10),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Blood inventory table (renamed to match PHP code)
CREATE TABLE IF NOT EXISTS blood_stock (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    blood_type VARCHAR(10) NOT NULL,
    blood_pints INTEGER NOT NULL DEFAULT 0,
    record_date DATE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Blood inventory table (keep original for future use)
CREATE TABLE IF NOT EXISTS blood_inventory (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    blood_type VARCHAR(10) NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 0,
    location VARCHAR(255),
    expiry_date DATE,
    status VARCHAR(20) DEFAULT 'available' CHECK (status IN ('available', 'reserved', 'used', 'expired')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Blood requests table
CREATE TABLE IF NOT EXISTS blood_requests (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    requester_name VARCHAR(255) NOT NULL,
    requester_email VARCHAR(255),
    requester_phone VARCHAR(20),
    blood_type VARCHAR(10) NOT NULL,
    quantity INTEGER NOT NULL,
    urgency VARCHAR(20) DEFAULT 'medium' CHECK (urgency IN ('low', 'medium', 'high', 'critical')),
    hospital_name VARCHAR(255),
    doctor_name VARCHAR(255),
    request_date DATE NOT NULL,
    required_date DATE,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected', 'fulfilled')),
    notes TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Blood donations table
CREATE TABLE IF NOT EXISTS blood_donations (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    donor_name VARCHAR(255) NOT NULL,
    donor_email VARCHAR(255),
    donor_phone VARCHAR(20),
    blood_type VARCHAR(10) NOT NULL,
    donation_date DATE NOT NULL,
    quantity INTEGER NOT NULL,
    location VARCHAR(255),
    status VARCHAR(20) DEFAULT 'scheduled' CHECK (status IN ('scheduled', 'completed', 'cancelled')),
    notes TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Withdrawal records table (for PHP compatibility)
CREATE TABLE IF NOT EXISTS withdrawal_records (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    blood_type VARCHAR(10) NOT NULL,
    withdrawn_pints INTEGER NOT NULL DEFAULT 0,
    record_date DATE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    email VARCHAR(255),
    role VARCHAR(20) DEFAULT 'staff' CHECK (role IN ('super_admin', 'admin', 'staff')),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Audit log table for tracking changes
CREATE TABLE IF NOT EXISTS audit_log (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    table_name VARCHAR(100) NOT NULL,
    record_id UUID NOT NULL,
    action VARCHAR(10) NOT NULL CHECK (action IN ('INSERT', 'UPDATE', 'DELETE')),
    old_values JSONB,
    new_values JSONB,
    user_id UUID,
    ip_address INET,
    user_agent TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Sessions table for serverless session management
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT,
    expires_at TIMESTAMP WITH TIME ZONE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Create updated_at trigger function
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create triggers for updated_at (drop if exists first)
DROP TRIGGER IF EXISTS update_users_updated_at ON users;
DROP TRIGGER IF EXISTS update_blood_stock_updated_at ON blood_stock;
DROP TRIGGER IF EXISTS update_blood_inventory_updated_at ON blood_inventory;
DROP TRIGGER IF EXISTS update_blood_requests_updated_at ON blood_requests;
DROP TRIGGER IF EXISTS update_blood_donations_updated_at ON blood_donations;
DROP TRIGGER IF EXISTS update_withdrawal_records_updated_at ON withdrawal_records;
DROP TRIGGER IF EXISTS update_admin_users_updated_at ON admin_users;

CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_blood_stock_updated_at BEFORE UPDATE ON blood_stock FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_blood_inventory_updated_at BEFORE UPDATE ON blood_inventory FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_blood_requests_updated_at BEFORE UPDATE ON blood_requests FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_blood_donations_updated_at BEFORE UPDATE ON blood_donations FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_withdrawal_records_updated_at BEFORE UPDATE ON withdrawal_records FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_admin_users_updated_at BEFORE UPDATE ON admin_users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Insert default admin user (password: admin123 - change in production)
INSERT INTO admin_users (username, password, full_name, email, role) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin@bloodview.com', 'super_admin')
ON CONFLICT (username) DO NOTHING;

-- Insert sample blood inventory
INSERT INTO blood_inventory (blood_type, quantity, location, expiry_date, status) VALUES
('A+', 50, 'Main Blood Bank', '2024-12-31', 'available'),
('A-', 30, 'Main Blood Bank', '2024-12-31', 'available'),
('B+', 45, 'Main Blood Bank', '2024-12-31', 'available'),
('B-', 25, 'Main Blood Bank', '2024-12-31', 'available'),
('AB+', 20, 'Main Blood Bank', '2024-12-31', 'available'),
('AB-', 15, 'Main Blood Bank', '2024-12-31', 'available'),
('O+', 60, 'Main Blood Bank', '2024-12-31', 'available'),
('O-', 35, 'Main Blood Bank', '2024-12-31', 'available')
ON CONFLICT DO NOTHING;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_blood_stock_type ON blood_stock(blood_type);
CREATE INDEX IF NOT EXISTS idx_blood_stock_date ON blood_stock(record_date);
CREATE INDEX IF NOT EXISTS idx_withdrawal_records_type ON withdrawal_records(blood_type);
CREATE INDEX IF NOT EXISTS idx_withdrawal_records_date ON withdrawal_records(record_date);
CREATE INDEX IF NOT EXISTS idx_blood_inventory_type ON blood_inventory(blood_type);
CREATE INDEX IF NOT EXISTS idx_blood_inventory_status ON blood_inventory(status);
CREATE INDEX IF NOT EXISTS idx_blood_requests_type ON blood_requests(blood_type);
CREATE INDEX IF NOT EXISTS idx_blood_requests_status ON blood_requests(status);
CREATE INDEX IF NOT EXISTS idx_blood_donations_type ON blood_donations(blood_type);
CREATE INDEX IF NOT EXISTS idx_audit_log_table_record ON audit_log(table_name, record_id);
CREATE INDEX IF NOT EXISTS idx_audit_log_created_at ON audit_log(created_at);

-- Row Level Security (RLS) policies for Supabase
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE blood_stock ENABLE ROW LEVEL SECURITY;
ALTER TABLE withdrawal_records ENABLE ROW LEVEL SECURITY;
ALTER TABLE blood_inventory ENABLE ROW LEVEL SECURITY;
ALTER TABLE blood_requests ENABLE ROW LEVEL SECURITY;
ALTER TABLE blood_donations ENABLE ROW LEVEL SECURITY;
ALTER TABLE admin_users ENABLE ROW LEVEL SECURITY;

-- Basic RLS policies (customize based on your needs)
-- Drop existing policies first
DROP POLICY IF EXISTS "Users can view their own data" ON users;
DROP POLICY IF EXISTS "Public can view blood stock" ON blood_stock;
DROP POLICY IF EXISTS "Public can view withdrawal records" ON withdrawal_records;
DROP POLICY IF EXISTS "Public can view blood inventory" ON blood_inventory;
DROP POLICY IF EXISTS "Public can create blood requests" ON blood_requests;
DROP POLICY IF EXISTS "Public can create blood donations" ON blood_donations;

CREATE POLICY "Users can view their own data" ON users FOR SELECT USING (auth.uid()::text = id::text);
CREATE POLICY "Public can view blood stock" ON blood_stock FOR SELECT USING (true);
CREATE POLICY "Public can view withdrawal records" ON withdrawal_records FOR SELECT USING (true);
CREATE POLICY "Public can view blood inventory" ON blood_inventory FOR SELECT USING (true);
CREATE POLICY "Public can create blood requests" ON blood_requests FOR INSERT WITH CHECK (true);
CREATE POLICY "Public can create blood donations" ON blood_donations FOR INSERT WITH CHECK (true);
