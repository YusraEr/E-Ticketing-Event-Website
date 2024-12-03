# EventHub - Modern Event Management Platform

## Description
EventHub is an e-ticketing system designed to manage events, allowing admins, event organizers, and attendees to interact easily in event management and ticket booking.

Admins have full access to manage events, users, and view sales reports, while organizers can add, update, and view bookings for their events.

Registered attendees can book tickets, view booking history, and save favorite events.

With additional features such as a ticketing system, real-time ticket availability tracking, event review system, payment integration, and analytics, this system is designed to provide an organized and efficient experience for all users.

## Core Features

### Event Management
- Event CRUD operations
- Image uploads
- Ticketing system
- Categorization

### User System
- Authentication
- Booking system
- Favorites
- Dashboard
- History

### Search Features
- Advanced search
- Filters
- Featured events

## Tech Stack
- **Frontend:** Laravel Blade, TailwindCSS, Alpine.js, Swiper.js
- **Backend:** Laravel 11, MySQL, PHP 8.1+
- **Tools:** Laravel Auth, Image Processing, Payment Gateway

## Requirements
- PHP 8.1+
- Composer
- MySQL
- Node.js & NPM

## Installation
1. Clone the repository
    ```sh
    git clone https://github.com/yourusername/eventhub.git
    ```
2. Navigate to the project directory
    ```sh
    cd eventhub
    ```
3. Install PHP dependencies
    ```sh
    composer install
    ```
4. Install Node.js dependencies
    ```sh
    npm install
    ```
5. Copy the example environment file and configure the environment
    ```sh
    cp .env.example .env
    ```
6. Generate the application key
    ```sh
    php artisan key:generate
    ```
7. Create a MySQL database for the project

8. Update the `.env` file with your database information

9. Run database migrations and seed the database
    ```sh
    php artisan migrate --seed
    ```
10. Start the local development server
     ```sh
     php artisan serve
     ```
11. Compile the frontend assets
     ```sh
     npm run dev
     ```

## Support
For any issues or support, please contact:
- **Email:** yusraerlangg@gmail.com

## Folder Structure
```
/app                - Application core code
    /Http            - Controllers and Middleware
    /Models          - Database models
    /Services        - Business logic services
/config            - Configuration files
/database          - Migrations and seeders
/public            - Publicly accessible files
/resources         - Views, assets, lang files
    /views          - Blade templates
    /js             - JavaScript files
    /css            - Stylesheet files
/routes            - Application routes
/storage           - Uploaded files, logs, cache
/tests             - Application tests
```
## Security Features
- Laravel Sanctum authentication
- CSRF protection
- XSS prevention
- SQL injection protection
- Input validation
- Secure file uploads

## Preview

### Landing Page


*Home page with featured events and search functionality*

### Event Discovery
![Event Discovery](https://via.placeholder.com/800x400.png)


*Browse and filter events with advanced search options*

### Event Details


*Detailed event information and booking interface*

### User Dashboard


*Personal dashboard showing bookings and favorites*

### Admin Panel




*Administrative interface for managing events and users*

### Booking Process


*Streamlined ticket booking and payment flow*


<!-- *Responsive design for mobile devices* -->
