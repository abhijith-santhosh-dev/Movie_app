# Movie App Setup Instructions

## Prerequisites
- PHP 8.0 or above
- MySQL 8.0 or above
- Composer
- Node.js and NPM
- OMDB API key from https://www.omdbapi.com

## Installation Steps

1. **Clone the repository**
   ```bash
   git https://github.com/abhijith-santhosh-dev/Movie_app.git
   cd Movie_app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   npm run dev
   ```

4. **Configure environment variables**
   - Copy `.env.example` to `.env`
   ```bash
   cp .env.example .env
   ```
   - Update the database configuration in `.env`
   ```
    DB_CONNECTION=mysql
    DB_HOST=sql12.freesqldatabase.com
    DB_PORT=3306
    DB_DATABASE=sql12768660
    DB_USERNAME=sql12768660
    DB_PASSWORD=jhhuVTNLAr

   ```
   - Add your OMDB API key
   ```
   OMDB_API_KEY=your_omdb_api_key
   ```
   KEY=e6bc4258
5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create the custom CSS file**
   - Create `public/css/custom.css` and copy the CSS contents provided

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Visit `http://localhost:8000` in your browser

## Testing

- Register a new user
- Search for movies using the search form
- Add movies to favorites
- View movie details
- Remove movies from favorites

## Security Considerations

- Passwords are hashed using Laravel's built-in hashing mechanism
- CSRF protection is enabled for all forms
- Validation is implemented for all user inputs
- SQL injection protection via Laravel's query builder and Eloquent ORM
