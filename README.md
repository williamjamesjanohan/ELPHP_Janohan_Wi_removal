# PINOY RECIPES BACKEND API

## Setup Instructions

Follow these steps to set up the backend REST API application on your local machine:

### Prerequisites
- PHP >= 8.0
- Composer
- A database (e.g., MySQL, PostgreSQL, SQLite)

### Steps

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd ELPHP_Janohan_Wi_removal
   ```

2. **Install Dependencies**
   - Install PHP dependencies:
     ```bash
     composer install
     ```

3. **Set Up Environment Variables**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database and other configuration details.

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Run the Application**
   - Start the development server:
     ```bash
     php artisan serve
     ```

7. **Access the API**
   Use Postman and import ELPHP_Janohan_Wi_removal.json to test the API routes.