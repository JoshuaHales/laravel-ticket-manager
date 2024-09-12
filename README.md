<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Ticket Manager Application

This Laravel application demonstrates a ticket management system integrated with a React frontend. It features real-time updates using Pusher and includes functionality to create and process tickets. It also includes comprehensive API endpoints and tests, making it a robust solution.

## Key Features

- **Ticket Creation**: A console command generates a ticket with dummy data every minute.
- **Ticket Processingt**: A console command processes an unprocessed ticket every five minutes, changing its status.
- **API Endpoints**: Multiple endpoints for retrieving open and closed tickets, user-specific tickets, and application stats.
- **Frontend Integration**: React components to display tickets, filter open and closed tickets, and paginate results.
- **Real-time Updates**: Tickets update in real-time using Pusher.
- **Testing**: PHPUnit tests, including both unit and feature tests, with 80%+ code coverage.

## Installation

- **PHP 8.2 or higher**
- **Composer**
- **Node.js and npm**
- **PHP 8.2 or higher**
- **SQLite for testing (or MySQL for local development)**

1. Clone the repository:

```bash
git clone https://github.com/JoshuaHales/laravel-ticket-manager.git cd laravel-ticket-manager
cd laravel-ticket-manager
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Set up environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

Make sure the database and other necessary configurations are correctly set in the .env file:

```bash
DB_CONNECTION=mysql 
DB_HOST=127.0.0.1 
DB_PORT=3306 
DB_DATABASE=laravel_ticket_manager 
DB_USERNAME=root 
DB_PASSWORD= 
```

5. Set up the database:

Run the following command to set up the database:

```bash
php artisan migrate --seed
```

This will run the migrations and seed the database with dummy users and tickets using model factories.

6. Serve the application:

To start the Laravel development server, run:

```bash
php artisan serve
```

By default, the app will be available at http://127.0.0.1:8000.

7. Compile the assets:

To compile the frontend React components, run:

```bash
npm run dev
```

This will bundle the JavaScript and CSS files.


## Features and Routes
1. API Endpoints
The application provides several API endpoints for managing and viewing tickets.

Retrieve Open Tickets
Returns a paginated list of all unprocessed tickets.

```bash
GET /api/tickets/open 
```

Retrieve Closed Tickets
Returns a paginated list of all processed tickets.

```bash
GET /api/tickets/closed
```

Retrieve User Tickets
Returns a paginated list of all tickets that belong to a user (searchable by ID or email).

```bash
GET /api/users/{userIdOrEmail}/tickets 
```

Retrieve Application Stats
Provides overall statistics about tickets and the user who has submitted the most tickets.

```bash
GET /api/stats 
```

2. Console Commands
The application includes two console commands for ticket generation and processing.

Generate a Ticket Every Minute

```bash
php artisan ticket
```

This command generates a new ticket with dummy data.

Process a Ticket Every Five Minutes

```bash
php artisan ticket
```

This command processes the oldest unprocessed ticket by updating its status.

3. Frontend Views
The frontend, built with React, allows users to view tickets, paginate results, and filter between open and closed tickets.

Open Tickets View
Displays a table of all open (unprocessed) tickets.

```bash
http://your-laravel-app.test/tickets?status=open
```

Closed Tickets View
Displays a table of all closed (processed) tickets.

```bash
http://your-laravel-app.test/tickets?status=closed 
```

User-Specific Tickets View
Displays a table of all tickets associated with a specific user by either their ID or email.

```bash 
http://your-laravel-app.test/users/{userIdOrEmail}/tickets 
```

## Testing

The application includes a comprehensive test suite using PHPUnit. You can run all tests, including unit and feature tests, by running the following command:

```bash 
php artisan test 
```

This includes tests for:

- **API endpoints**
- **Console commands**
- **Unit tests for models and relationships**

## Code Coverage

To generate a code coverage report, use the following command:

```bash 
php artisan test --coverage
```

Make sure you have Xdebug or PCOV installed to generate the coverage report.

## Code Coverage

The application uses Pusher for real-time updates. Ensure that your Pusher credentials are set up correctly in the .env file:

```bash 
PUSHER_APP_ID= PUSHER_APP_KEY= PUSHER_APP_SECRET= PUSHER_APP_CLUSTER=
```

If you don't have a Pusher account, you can set one up by visiting [Pusher](https://pusher.com/). and following their registration process. Once registered, create a new app in the Pusher dashboard to obtain your credentials.

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/license/mit).
