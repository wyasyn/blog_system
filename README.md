# Blog System Project

A simple blog system built using PHP, MySQL, and the LAMP stack.

## Features

- **Public Access**: Users can view all blogs without authentication.
- **Roles**:
  - **Admin**: Approves author accounts and manages the system.
  - **Author**: Can create, edit, and delete their blogs after approval by an admin.
- **Blog Features**:
  - Blogs include a title, content, category, tags, images, and publication date.
  - Images are stored in an `uploads` directory.
- **Authentication**: Authors and admins must log in to access their respective features.
- **Admin Panel**: Admin can manage authors and approve or reject accounts.

## Project Structure

```bash
/blog-system
├── /public
│   ├── index.php            # Homepage displaying all blogs
│   ├── login.php            # Login page for authors and admins
│   ├── register.php         # Registration page for new authors
│   ├── create_blog.php      # Form for creating a new blog
│   ├── admin.php            # Admin panel for managing authors
│   ├── /uploads             # Directory for uploaded images
│
├── /includes
│   ├── db.php               # Database connection file
│   ├── header.php           # Reusable header component
│   ├── footer.php           # Reusable footer component
│   ├── auth.php             # Authentication helper functions
│
├── /assets
│   ├── /css
│   │   └── styles.css       # Stylesheet for the project
│   ├── /js
│       └── scripts.js       # JavaScript functionality (if needed)
│
├── /migrations
│   ├── create_users_table.sql  # SQL script to create `users` table
│   ├── create_blogs_table.sql  # SQL script to create `blogs` table
│
├── .env                     # Environment variables (e.g., database credentials)
├── README.md                # Project documentation
└── .htaccess                # Apache settings (optional)
```

## Installation

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   ```

2. **Configure the database**:

   - Create a new database: `blog_system`.
   - Import the SQL files from `/migrations` folder:

     ```bash
     mysql -u root -p blog_system < migrations/create_users_table.sql
     mysql -u root -p blog_system < migrations/create_blogs_table.sql
     ```

## Using Postgresql

Log in to PostgreSQL and create the database

```bash
sudo -u postgres psql
CREATE DATABASE blog_system;
\q
```

3. **Set file permissions**:

   ```bash
   chmod -R 755 public/uploads
   ```

4. **Run the application**:

   ```bash
   php -S localhost:8000 -t public
   ```

5. **Access the application**:
   - Open your browser and navigate to: `http://localhost:8000`.

## Contributing

Feel free to submit issues or pull requests to improve this project.

## License

This project is licensed under the MIT License.

```bash
sudo -u postgres psql
\c blog_system;
psql -U postgres -d blog_system -f ./migrations/create_users_table.sql
psql -U postgres -d blog_system -f ./migrations/create_blogs_table.sql
\dt

```

```bash
php run_migrations.php
```

driver for ubuntu

```bash
sudo apt-get install php-pgsql
```
