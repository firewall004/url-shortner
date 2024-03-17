# URL Shortener

This is a simple URL shortener application built with Laravel and Vue.js. It allows users to shorten long URLs into shorter, more manageable links.

## Features

- Shorten long URLs into randomly generated short links.
- View a list of all shortened URLs with details such as original URL, shortened URL, and status.
- Edit and update existing shortened URLs.
- Delete URLs and restore them if needed.
- Deactivate or activate shortened URLs. This will prevent to link the short URL to original URL
- Upgrade user plan to increase URL quota limit.
- Secure authentication and authorization system.
- Error handling and validation for a smooth user experience.

## Technologies Used

- MySQL 5.7
- PHP 8.x
- Laravel 8.x
- Vue.js
- Bootstrap
- Node 16

## Installation

1. Clone the repository: `git clone https://github.com/username/url-shortener.git`
2. Install dependencies: `composer install && npm install`
3. Set up environment variables: Copy `.env.example` to `.env` and configure database settings.
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`
6. Access the application in your browser: `http://localhost:8000`

## Screenshots

### Register

![image](https://github.com/firewall004/url-shortner/assets/37473661/ec4fc0c7-ef3d-4e8f-9595-7fa362c07f02)

### Login

![image](https://github.com/firewall004/url-shortner/assets/37473661/53b2e9e8-3bdb-4f33-a193-18d459cf8840)

### Url Shortener

![image](https://github.com/firewall004/url-shortner/assets/37473661/d4e48e46-1e1f-47c8-9aca-cfde019d05e0)

### Home

![image](https://github.com/firewall004/url-shortner/assets/37473661/972cf062-3c24-490a-99b8-557fc3887f1e)
