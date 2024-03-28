
## Test Project

Simple application with vacancies and candidates.

**Technologies:** PHP8.3, Laravel 11, Vue.js 3, Inertia.js, TailwindCSS, MySQL.

Uses Laravel Sanctum for authentication (Web and API).

## Installation

1. Clone the repository
2. Use Laravel Sail to run the project. 
    ```bash
    ./vendor/bin/sail up -d
    ```
3. Install dependencies
    ```bash
    ./vendor/bin/sail composer install
    ./vendor/bin/sail npm install
    ```
4. Run migrations
    ```bash
    ./vendor/bin/sail artisan migrate
    ```
5. Seed the database
    ```bash
    ./vendor/bin/sail artisan db:seed
    ```
6. Start Vite server
    ```bash
    ./vendor/bin/sail npm run dev
    ```
7. Open the project in the browser at `http://localhost:9080`

## Task

You can find it in the `Senior PHP Developer Position (Laravel).pdf` file.
