# House Rent Search Website

A simple and elegant house rent search website built with **PHP** and **MySQL**. This project includes a user-friendly frontend for searching houses and a complete admin panel for managing listings.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

---

## Table of Contents

- [Features](#-features)
- [Demo Screenshots](#-demo-screenshots)
- [Technologies Used](#-technologies-used)
- [Installation](#-installation)
- [Database Setup](#-database-setup)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Admin Panel](#-admin-panel)
- [Project Structure](#-project-structure)
- [Security Features](#-security-features)
- [Contributing](#-contributing)
- [License](#-license)

---

## Features

### 🔍 User Side (Frontend)
- **Advanced Search**: Filter houses by location, maximum rent, and number of rooms
- **House Listings**: Beautiful card-based layout displaying available properties
- **Detailed View**: Complete house information with images, description, and contact details
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Clean UI**: Modern and intuitive user interface

### Admin Panel (Backend)
- **Secure Login**: Password-protected admin access with encrypted passwords
- **Dashboard**: Overview with statistics (total houses, total rent value, average rent)
- **CRUD Operations**:
  -  Add new houses
  -  Edit existing houses
  -  Delete houses
- **Image Management**: Upload and manage house images
- **Data Table**: View all houses in an organized table format

---

##  Demo Screenshots

### Frontend
- Home page with search functionality
- House listings grid
- Detailed house view

### Admin Panel
- Login page
- Dashboard with statistics
- Add/Edit house forms

---

##  Technologies Used

| Technology | Purpose |
|------------|---------|
| **PHP** (Procedural) | Backend logic and server-side processing |
| **MySQL** | Database management |
| **HTML5** | Structure and markup |
| **CSS3** | Styling and responsive design |
| **JavaScript** | Form validation and interactivity |
| **mysqli** | Database connectivity with prepared statements |

---

##  Installation

### Prerequisites
- **XAMPP** / **WAMP** / **LAMP** installed
- **PHP** version 7.4 or higher
- **MySQL** version 5.7 or higher
- Web browser (Chrome, Firefox, Safari, etc.)

### Step-by-Step Installation

1. **Clone or Download the Repository**
   ```bash
   git clone https://github.com/yourusername/house-rent-search.git
   ```
   Or download as ZIP and extract to your local machine.

2. **Move to Web Server Directory**
   ```bash
   # For XAMPP (Windows/Mac/Linux)
   Move the folder to: C:/xampp/htdocs/house-rent/
   
   # For WAMP (Windows)
   Move the folder to: C:/wamp64/www/house-rent/
   
   # For LAMP (Linux)
   Move the folder to: /var/www/html/house-rent/
   ```

3. **Create Upload Directory**
   ```bash
   # Create the following folder structure:
   house-rent/
   └── uploads/
       └── house-images/
   ```
   
   **Important**: Set proper permissions (chmod 777) for the `uploads` folder:
   ```bash
   chmod -R 777 uploads/
   ```

4. **Start Web Server**
   - Start Apache and MySQL from XAMPP/WAMP Control Panel
   - Or use command line:
     ```bash
     sudo service apache2 start
     sudo service mysql start
     ```

---

##  Database Setup

### Method 1: Using phpMyAdmin (Recommended)

1. Open **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Click on **"New"** to create a new database
3. Enter database name: `house_rent`
4. Click **"Create"**
5. Select the `house_rent` database
6. Click on **"Import"** tab
7. Choose the `database.sql` file from the project
8. Click **"Go"** to import

### Method 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE house_rent;

# Use the database
USE house_rent;

# Import SQL file
SOURCE /path/to/database.sql;

# Exit
EXIT;
```

### Database Structure

The database includes two main tables:

#### 1. `users` Table (Admin)
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary Key |
| email | VARCHAR(100) | Admin email |
| password | VARCHAR(255) | Hashed password |
| created_at | TIMESTAMP | Registration date |

#### 2. `houses` Table
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary Key |
| title | VARCHAR(255) | House title |
| location | VARCHAR(255) | House location |
| rent | DECIMAL(10,2) | Monthly rent |
| rooms | INT | Number of rooms |
| bathrooms | INT | Number of bathrooms |
| description | TEXT | House description |
| image | VARCHAR(255) | Image filename |
| contact_number | VARCHAR(20) | Owner contact |
| created_at | TIMESTAMP | Created date |

---

##  Configuration

### Database Connection (db.php)

Edit the `db.php` file with your database credentials:

```php
define('DB_HOST', 'localhost');    // Database host
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password (empty for XAMPP)
define('DB_NAME', 'house_rent');   // Database name
```

**Note**: For production environments, use strong passwords and update these credentials accordingly.

---

##  Usage

### Accessing the Application

1. **Frontend (User Side)**
   ```
   http://localhost/house-rent/
   ```

2. **Admin Panel**
   ```
   http://localhost/house-rent/admin/login.php
   ```

### Default Admin Credentials

```
Email: admin@houserent.com
Password: admin123
```

** Important**: Change the default password after first login for security purposes.

### User Flow

1. **Search Houses**
   - Enter location, maximum rent, or minimum rooms
   - Click "Search Houses" button
   - View filtered results

2. **View House Details**
   - Click "View Details" on any house card
   - See complete information including images and contact details
   - Contact owner directly via phone

3. **Admin Management**
   - Login to admin panel
   - View dashboard statistics
   - Add/Edit/Delete houses
   - Upload house images

---

##  Admin Panel

### Login
- Navigate to: `http://localhost/house-rent/admin/login.php`
- Enter admin credentials
- Access the dashboard

### Dashboard Features

1. **Statistics Cards**
   - Total number of houses
   - Total rent value
   - Average rent

2. **House Management Table**
   - View all houses
   - Quick actions (View, Edit, Delete)
   - Image thumbnails

3. **Add New House**
   - Fill in house details
   - Upload house image (JPG, PNG, GIF)
   - Submit to database

4. **Edit House**
   - Update house information
   - Replace house image (optional)
   - Save changes

5. **Delete House**
   - Remove house from listings
   - Confirmation dialog for safety
   - Automatic image deletion

---

##  Project Structure

```
house-rent/
│
├── index.php                 # Home page with search and listings
├── house-details.php         # Individual house details page
├── db.php                    # Database connection file
├── database.sql              # SQL database structure and data
├── README.md                 # This file
│
├── admin/                    # Admin panel directory
│   ├── login.php            # Admin login page
│   ├── dashboard.php        # Admin dashboard
│   ├── add-house.php        # Add new house form
│   ├── edit-house.php       # Edit house form
│   ├── delete-house.php     # Delete house handler
│   └── logout.php           # Logout handler
│
├── assets/                   # Static assets
│   └── style.css            # Main stylesheet
│
└── uploads/                  # User uploads
    └── house-images/        # House images directory
```

---

## Security Features

### Implemented Security Measures

1. **SQL Injection Prevention**
   - Uses `mysqli_real_escape_string()` for all user inputs
   - Prepared statements for database queries
   - Input validation on both client and server side

2. **Password Security**
   - Passwords hashed using `password_hash()` with bcrypt
   - Verification using `password_verify()`
   - Never stored in plain text

3. **Session Management**
   - Secure session-based authentication
   - Session validation on each admin page
   - Proper session destruction on logout

4. **File Upload Security**
   - Validates file types (only images allowed)
   - Generates unique filenames to prevent overwrites
   - Restricts upload directory permissions

5. **XSS Prevention**
   - Uses `htmlspecialchars()` for all output
   - Sanitizes user inputs before display

6. **Authentication**
   - Admin-only access to management features
   - Redirect to login if not authenticated
   - Session timeout handling

### Best Practices Followed

- No sensitive data in URLs
- Error messages don't reveal system information
- Proper file permissions on upload directories
- CSRF protection ready (can be enhanced)
- Database credentials in separate config file

---

## Customization

### Changing Colors

Edit `assets/style.css` and modify the CSS variables:

```css
/* Primary gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Primary color */
.btn-primary {
    background: #667eea;
}
```

### Adding More Fields

1. Update database table in `database.sql`
2. Modify forms in `add-house.php` and `edit-house.php`
3. Update display in `index.php` and `house-details.php`

### Email Notifications

You can extend the project by adding PHPMailer for email notifications when:
- New house is added
- User inquiries about a property
- Admin actions are performed

---

##  Troubleshooting

### Common Issues

1. **"Connection failed" error**
   - Check if MySQL is running
   - Verify database credentials in `db.php`
   - Ensure database `house_rent` exists

2. **Images not uploading**
   - Check if `uploads/house-images/` folder exists
   - Verify folder permissions (chmod 777)
   - Check PHP upload settings in `php.ini`

3. **Admin login not working**
   - Verify database import was successful
   - Check if `users` table has admin data
   - Clear browser cookies and try again

4. **CSS not loading**
   - Check file path in HTML `<link>` tag
   - Verify `assets/style.css` exists
   - Clear browser cache

---

##  Sample Data

The database includes 5 sample houses:

1. Modern 2BHK Apartment - Dhanmondi (৳25,000)
2. Spacious 3BHK House - Gulshan (৳45,000)
3. Cozy 1BHK Studio - Mirpur (৳12,000)
4. Family 4BHK Villa - Banani (৳60,000)
5. Budget 2BHK Flat - Mohammadpur (৳18,000)

---

## Future Enhancements

Potential features to add:

- [ ] User registration and login
- [ ] Wishlist/Favorites functionality
- [ ] Advanced filters (furnished, parking, etc.)
- [ ] Image gallery (multiple images per house)
- [ ] Email inquiry system
- [ ] Property comparison feature
- [ ] Map integration (Google Maps)
- [ ] Review and rating system
- [ ] Pagination for listings
- [ ] Search history
- [ ] PDF report generation
- [ ] SMS notifications

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Author

**Your Name**
- GitHub: [@Mribrahimkhan360]([https://github.com/yourusername](https://github.com/Mribrahimkhan360))
- Email: mribrahimkhan360@gmail.com
- LinkedIn: [LinkedIn Profile](https://www.linkedin.com/in/ibrahim-khan-a72462239/)

---

## Acknowledgments

- Icons from Emoji
- Inspiration from various real estate websites
- PHP and MySQL documentation
- Stack Overflow community

---

## Support

If you encounter any issues or have questions:

1. Check the [Troubleshooting](#-troubleshooting) section
2. Open an issue on GitHub
3. Contact via email

---

## Show Your Support

If this project helped you, please give it a ⭐️!

---

**Made with using PHP & MySQL**

---

## Project Statistics

- **Files**: 12 PHP files
- **Database Tables**: 2
- **Lines of Code**: ~1,500+
- **Development Time**: Educational purpose
- **Last Updated**: December 2024

---

**Happy Coding! =**
