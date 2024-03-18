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

![image](https://github.com/firewall004/url-shortner/assets/37473661/a8012060-7250-41a0-892e-9a8ee10b739b)

### Login

![image](https://github.com/firewall004/url-shortner/assets/37473661/7287627f-0ed2-4ee1-ba93-2854f5bec0e1)

### Url Shortener

![image](https://github.com/firewall004/url-shortner/assets/37473661/f8e2b089-655f-414a-9784-8a4f29e3a92b)

### Home

![image](https://github.com/firewall004/url-shortner/assets/37473661/c7e8aec7-a714-481b-9562-2dec85788ecf)
