# FoodLoop

**Surplus food donation and reservation platform**

FoodLoop is a web application that helps reduce food waste by connecting food businesses with charities and other organizations that can use surplus food. Restaurants, cafes, bakeries and supermarkets publish food that is still safe to use but would otherwise be wasted. Charities browse the available listings and reserve the quantity they need. The platform helps both sides manage listings and reservations, and records when food has been collected.

Built by **Min Khant Kyaw** as the project for the course _From idea to MVP_ (MWA1, 2026).

## Who uses it

| Role                      | What they do                                                                         |
| ------------------------- | ------------------------------------------------------------------------------------ |
| **Donor** (food business) | Creates organizations, publishes and manages surplus food listings, confirms pickups |
| **Recipient** (charity)   | Browses listings, reserves a quantity, follows and cancels reservations              |
| **Admin**                 | Manages users, organizations, food categories and listings                           |
| **Visitor**               | Browses the public pages without an account                                          |

## Features

- Public welcome page and browsable food listings with search and filters
- Registration, login and profile management
- Organization management (create, edit, deactivate)
- Food listings with categories, quantity, dates and status
- Reservations with quantity validation
- Pickup records with a pickup code and collection confirmation
- Admin area for users, organizations, categories and listings
- Role-based access (authorization in controllers, user info shown in views)
- Server-side validation on every form, with error feedback

## Data model

Six main models:

| Model          | Key fields                                                        |
| -------------- | ----------------------------------------------------------------- |
| `User`         | name, email, password, role, email_verified_at                    |
| `Organization` | user_id, name, slug, type, contact details, is_active             |
| `FoodCategory` | name, slug, description, is_active                                |
| `FoodListing`  | organization_id, food_category_id, title, quantity, dates, status |
| `Reservation`  | food_listing_id, user_id, quantity, status, reserved_at           |
| `Pickup`       | reservation_id, confirmed_by, pickup_code, status, collected_at   |

Relationships:

- User 1–N Organization
- Organization 1–N FoodListing
- FoodCategory 1–N FoodListing
- FoodListing 1–N Reservation
- User 1–N Reservation
- Reservation 1–1 Pickup
- A User can confirm many Pickups (`confirmed_by`)

Every model has a migration and a factory, and all factories are used in `DatabaseSeeder`.

## Pages and routes

| Page                 | URL                   | Access                                           |
| -------------------- | --------------------- | ------------------------------------------------ |
| Home                 | `/`                   | Public                                           |
| Food listings        | `/food-listings`      | Public                                           |
| Food listing details | `/food-listings/{id}` | Public view, actions need a signed-in role       |
| My organizations     | `/organizations`      | Signed-in donor / recipient, admin manages all   |
| Organization details | `/organizations/{id}` | Signed-in users, edits limited to owner or admin |
| My reservations      | `/reservations`       | Signed-in recipient                              |
| Pickup confirmation  | `/pickups`            | Relevant donor / recipient and admin             |
| Admin management     | `/admin`              | Admin only                                       |
| Login / register     | `/login`, `/register` | Public                                           |
| Profile settings     | `/profile`            | Signed-in user                                   |

## Tech stack

- PHP 8.5
- Laravel 13
- Blade templates (no front-end framework)
- Tailwind CSS 4 and Alpine.js (CDN fallback, so no build is required)
- SQLite
- Pest for tests

The project is built on an educational Laravel starter pack (Breeze-style Blade authentication).

## Installation

Requirements: PHP 8.5, Composer.

```bash
git clone <repository-url> foodloop
cd foodloop

composer install
cp .env.example .env
php artisan key:generate

touch database/database.sqlite

php artisan migrate:fresh --seed

php artisan serve
```

Then open <http://127.0.0.1:8000>.

No front-end build is needed. If you want the compiled assets, run `npm install && npm run build`.

## Demo accounts

The seeder creates these users (all with the password `password`):

| Role  | Email             | Password   |
| ----- | ----------------- | ---------- |
| Admin | `admin@admin.com` | `password` |

Other seeded donors and recipients use random emails generated by the factory.

## Running the tests

```bash
php artisan test
```

## Git workflow

The project is developed in small, atomic commits, each adding one functional increment (for example: one model with its migration and factory, one controller method, one view).

## License

This project was created for educational purposes.
