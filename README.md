# Hospital Management System (Core PHP)

## Overview
A role-based hospital management system built with Core PHP, MySQL, HTML, CSS, and JavaScript. It includes OPD/Pathology billing workflows, commission tracking, and reports.

## Requirements
- PHP 8.1+
- MySQL 8+
- Apache (XAMPP/WAMP/LAMP)

## Setup (XAMPP/WAMP)
1. **Clone or copy** the project into your web root (e.g., `htdocs/hms`).
2. **Create the database** by importing the SQL file:
   - Open phpMyAdmin → Import → `database/hms.sql`.
3. **Configure database credentials** in `config/database.php`.
4. Ensure Apache has **mod_rewrite enabled** and `AllowOverride All` for `.htaccess`.
5. Open the app in the browser: `http://localhost/hms`.

## Sample Users
All sample users use the password: **Password@123**

| Role | Email |
| --- | --- |
| Super Admin | superadmin@hms.local |
| Admin | admin@hms.local |
| Receptionist | reception@hms.local |
| Doctor | doctor@hms.local |
| Nurse | nurse@hms.local |
| Pathologist | pathologist@hms.local |
| Pharmacist | pharmacist@hms.local |

## Folder Structure
```
assets/
config/
controllers/
core/
models/
views/
index.php
.htaccess
database/
```

## Security Notes
- Uses **PDO prepared statements** for SQL queries.
- Passwords are stored with **bcrypt hashes**.
- RBAC permissions are enforced at the controller level.

## Next Steps
- Add CRUD screens for OPD/Pathology items.
- Implement invoice PDF generation.
- Extend reports with date filters and export.
