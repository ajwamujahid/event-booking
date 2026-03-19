# EventBook — Laravel Event Booking System

A full-featured Event Booking Application built with Laravel 12 that allows users to discover events, reserve seats, and manage their bookings.

---

## Project Description

EventBook is a web application that enables:
- **Event Management** — Create, view, edit, and delete events
- **Seat Booking** — Reserve seats for upcoming events
- **Booking Management** — View and cancel your own bookings
- **Authentication** — Register, login, and logout securely
- **Filtering** — Search events by location or date

---

## Requirements

- PHP 8.1+
- Composer 2+
- MySQL / MariaDB
- Laravel 12

---

## Installation Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/YOUR_USERNAME/event-booking.git
cd event-booking
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Copy Environment File
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

---

## Environment Setup

Open `.env` file and update the following:

```env
APP_NAME="Event Booking"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_booking
DB_USERNAME=root
DB_PASSWORD=
```

>  Create a database named `event_booking` in phpMyAdmin or MySQL before running migrations.

---

## Database Migration Steps

### Run Migrations
```bash
php artisan migrate
```

### Run Seeders
```bash
php artisan db:seed
```

This will create:
- 1 Admin user
- 4 Regular users
- 20+ Sample events

---

##  Test Login Credentials

### Admin User

 Email     admin@example.com   
 Password  password            

> You can also register a new account from the Register page.

---

## Running the Application

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Application Flow

### 1. Authentication
- Visit `/register` to create a new account
- Visit `/login` to sign in
- Click your name in navbar → Logout to sign out

### 2. Browsing Events
- Homepage redirects to `/events`
- All upcoming events are listed with location, date, and available seats
- Use the **Filter** form to search by **location** or **date**
- Click **"View Details"** to see full event information

### 3. How Event Booking Works
- Open any event detail page
- On the right side, a **booking card** is shown
- Enter the number of seats you want
- Click **"Book Now"** — booking is confirmed instantly
- A success message is shown and you are redirected to **My Bookings**

### 4. How Seat Availability is Handled
- When a booking is created → `available_seats` is **decremented** by the number of seats booked
- When a booking is cancelled → `available_seats` is **incremented** back
- A **progress bar** on each event card shows how filled the event is
- If an event is fully booked → booking form is replaced with **"Fully Booked"** message
- All seat operations run inside a **database transaction** to prevent race conditions

### 5. Managing Bookings
- Visit `/bookings` (My Bookings) to see all your reservations
- Each booking shows event name, date, location, seats, and status
- Click **"Cancel"** to cancel an active booking

### 6. Managing Events (Authenticated Users)
- Click **"Create Event"** in the navbar to add a new event
- On any event you created → **Edit** and **Delete** buttons are visible
- Only the event creator can edit or delete their events
