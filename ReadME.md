# HealthConnect - WebProject

## Getting Started (For Developers)

Follow these instructions to set up the project locally on your machine.

### 1. Requirements

- **XAMPP** (or any local server environment with PHP 8+ and MySQL)

### 2. Project Setup

1. Move or clone this project repository directly into your XAMPP `htdocs` directory.
   - The folder should be named `WebProject` (Path: `C:\xampp\htdocs\WebProject`).
2. Open the **XAMPP Control Panel**.
3. Click **Start** for both the **Apache** and **MySQL** modules.

### 3. Database Setup

1. Open your web browser and go to `http://localhost/phpmyadmin/`.
2. Click on **Databases** in the top menu.
3. Create a new database named **`dbproject`** (leave the collation as default or `utf8mb4_general_ci`).
   > **Note on Case Sensitivity:** MySQL on Windows is case-insensitive by default, so both `DBProject` and `dbproject` will work. However, on Linux or macOS, MySQL is case-sensitive by default. The database name must exactly match what you created.
4. Select the newly created `dbproject` on the left sidebar.
5. Click the **Import** tab at the top.
6. Click **Choose File** and locate the file `backend/database.sql` from this project.
7. Click **Import** (or **Go**) at the bottom of the page. This will set up the tables and populate all sample data!

### 4. Running the Application

Once the database is ready, you can start developing and testing the application by visiting:
**`http://localhost/WebProject/homepage/index.php`**

### 5. Code Formatting (Prettier)

This project uses **Prettier** to keep code style consistent.

- **Option 1 (Recommended):** Install the Prettier extension in your IDE.
  - Enable **Format on Save** so your code is automatically formatted every time you save a file.

- **Option 2 (If you can’t use the extension):**
  - Install Prettier locally in the project (one time):
    ```bash
    npm install --save-dev prettier
    ```
  - Then manually format all files before pushing:
    ```bash
    npx prettier --write .
    ```
