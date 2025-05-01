# Event Ticketing Platform API (Laravel)

A RESTful API for managing events, venues, and ticket bookings. Built using Laravel 10 and Sanctum for authentication.

---

## 🚀 Features

- User Registration, Login & Logout
- Browse Upcoming Events with Filters
- Book Tickets (Limited by Venue Capacity)
- View User's Booked Tickets (Upcoming First)
- Admins can:
  - Create/Update/Delete Events
  - Create/Update/Delete Venues
- Profile Management (Preferred Categories)
- ✅ **Bonus:**
  - Search Events by Name or Venue
  - Rate-Limiting (Max 3 Ticket Bookings per Minute)
  - Fake Confirmation Email Logged on Booking ( laravel.log )

---

## 🛠️ Tech Stack

- Laravel 10
- Sanctum (API Auth)
- MySQL
- Eloquent ORM
- Postman (API Testing)
- Blade (Email templates)
- Mail (log driver)

---

🔐 Authentication

-API uses Laravel Sanctum

-After registering or logging in, include your token in every request:

Authorization: Bearer your_token_here

Accept: application/json

📫 Postman API Collection

📁 [Download postman_collection.json](https://github.com/edberv1/codechallenge/blob/main/postman_collection.json)


## ⚙️ Setup Instructions

```bash
# 1. Clone the repo
git clone https://github.com/edberv1/codechallenge.git
cd codechallenge

# 2. Install dependencies
composer install

# 3. Create your .env file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Set up DB in .env
# DB_DATABASE=event_db
# DB_USERNAME=root
# DB_PASSWORD=yourpassword

# 6. Run migrations
php artisan migrate --seed

# 7. Serve
php artisan serve
