# Hospital Management System (Core PHP)

## Overview
This project delivers a secure, role-based Hospital Management System covering patient registration, OPD and pathology billing, unified invoices, reporting, and user management.

## Requirements
- PHP 8.0+
- MySQL 5.7+
- Apache (XAMPP/WAMP/LAMP)

## Setup (XAMPP/WAMP)
1. Copy the project into your web root (e.g., `htdocs/hospital`).
2. Create a database and import the SQL:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
3. Update database credentials in `app/config/config.php`.
4. Start Apache + MySQL.
5. Visit: `http://localhost/hospital/public/index.php`

## Sample Users (Password: `Password@123`)
| Username | Role |
|---|---|
| superadmin | Super Admin |
| admin | Admin |
| reception | Receptionist |
| doctor | Doctor |
| nurse | Nurse |
| pathologist | Pathologist |
| pharmacist | Pharmacist |

## Key Features
- Role-based access control (RBAC)
- Patient registration and history
- OPD and pathology item management
- Unified billing with auto invoice ID (YYYYMM-XXXX)
- Invoice printing
- Reports (daily, monthly, due collection)

## Folder Structure
- `app/` Core MVC-like application
- `public/` Public assets and front controller
- `database/` SQL schema and seed data

## Security Notes
- Uses prepared statements and password hashing
- Sessions required for access
- Permissions enforced per action
