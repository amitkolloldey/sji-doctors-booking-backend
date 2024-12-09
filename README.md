# SJI Doctor's Appointment Booking API Backend

## Setup Instructions

    Follow these steps to set up the SJI Doctor's Appointment Booking API Backend project locally.

### Prerequisites

    Ensure you have the following installed:

    - PHP (version 8.0 or higher)
    - Composer
    - MySQL
    - Laravel Installer (optional)
    - Mailtrap account (for local email testing)

### 1. Clone the Repository

    Clone the repository from GitHub:

    git clone https://github.com/amitkolloldey/sji-doctors-booking-backend.git

    cd sji-doctors-booking-backend

### 2. Create the .env File

    Create a copy of the .env.example file and rename it to .env:

    cp .env.example .env

### 3. Install PHP Dependencies

    Run the following command to install PHP dependencies using Composer:

    composer install    

### 4. Generate the Application Key

    Generate the application key for your project by running the following command:

    php artisan key:generate

    This command will automatically generate and set the APP_KEY in your .env file.

###  5. Set Up Your .env File

    php artisan serve

    Open the .env file in the project root and add the following configuration:

    Set the Backend URL

    APP_URL=http://127.0.0.1:8000

    Set the Frontend URL

    Add the URL for your frontend application (assuming it's running locally on port 3000):

    FRONT_URL=http://localhost:3000

    Set Up Database Connection

    Configure the database connection details:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=8889
    DB_DATABASE=sji_doctors_booking
    DB_USERNAME=root
    DB_PASSWORD=

    Set Up Mailtrap for Email Testing

    To test email functionality locally, sign up for a Mailtrap account. Once you have your test credentials, configure the .env file for Mailtrap as follows:

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=587
    MAIL_USERNAME=username
    MAIL_PASSWORD=password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@sjidoctorsbooking.com
    MAIL_FROM_NAME="${APP_NAME}"

### 6. Migrate the Database

    After setting up the database, run the migrations to set up the necessary database tables:

    php artisan migrate

    This will apply the migrations and create the necessary tables in your database.

### 7. Serve the Application

    Run the Laravel development server to start the backend API:

    php artisan serve

    By default, the server will be available at http://127.0.0.1:8000.

### 8. Access the API

    Once the server is running, you can access the backend API at http://127.0.0.1:8000.

    If you have a react frontend running, it should be able to connect to this API at http://localhost:3000 (or the relevant URL you set in the .env file).

### 9. Update cors allowed_origins if needed in config/cors.php

    'allowed_origins' => [
        'http://localhost:3000',   // Replace with your frontend domain
        'http://localhost:3001',
        'http://localhost:3002',
    ],
