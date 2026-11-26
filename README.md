# FoodLoop

**Surplus food donation and reservation platform**

FoodLoop is a web application that helps reduce food waste by connecting food businesses with charities. Restaurants, cafés, bakeries and supermarkets publish surplus food that is still safe to eat. Charities browse the available food and reserve the quantity they need. The platform records the reservation and confirms the pickup with a code.

Built by **Min Khant Kyaw** for the course _From idea to MVP_ (MWA1, 2026).

## Roles

| Role                      | What they do                                                                                         |
| ------------------------- | ---------------------------------------------------------------------------------------------------- |
| **Donor** (food business) | Creates an organization, publishes food listings with a photo, confirms pickups with the code        |
| **Recipient** (charity)   | Creates an organization, reserves food, shows the pickup code when collecting                        |
| **Admin**                 | Sees the platform overview, manages categories, organizations and food listings, follows all pickups |
| **Visitor**               | Browses the public pages without an account                                                          |

Both donors and recipients must create an organization before they can publish or reserve food. The seeded demo accounts already have one.

## Features

- Welcome page with live numbers and the latest available food
- Public pages: food listings (search and category filter), listing details, categories, category details
- Register (as a food business or a charity), log in, profile settings
- Full CRUD for **food listings** (with photo upload), **organizations** and **food categories**
- Reservations with quantity checks, cancel while pending
- Pickups with a unique code: the recipient sees the code, the donor types it to confirm
- Email notifications: the donor is told when food is reserved, the recipient when the pickup is confirmed
- Role-based dashboards (donor, recipient, admin with a sidebar)
- Authorization with policies, and validation with error messages on every form

## Data model

| Model          | Main fields                                                                                                   |
| -------------- | ------------------------------------------------------------------------------------------------------------- |
| `User`         | name, email, password, role                                                                                   |
| `Organization` | user_id, name, slug, type, contact details, is_active                                                         |
| `FoodCategory` | name, slug, description, is_active                                                                            |
| `FoodListing`  | organization_id, food_category_id, title, description, photo_path, quantity, pickup times, expires_at, status |
| `Reservation`  | food_listing_id, user_id, quantity, status, reserved_at                                                       |
| `Pickup`       | reservation_id, confirmed_by, pickup_code, status, collected_at                                               |

Relationships:

- User 1–N Organization
- Organization 1–N FoodListing
- FoodCategory 1–N FoodListing
- FoodListing 1–N Reservation
- User 1–N Reservation
- Reservation 1–1 Pickup
- User 1–N Pickup (`confirmed_by`)
  Every model has a migration and a factory, and the factories are used in `DatabaseSeeder`.

## Pages

| Page                     | URL                                 | Access                                         |
| ------------------------ | ----------------------------------- | ---------------------------------------------- |
| Home                     | `/`                                 | Public                                         |
| Food listings            | `/food-listings`                    | Public                                         |
| Listing details          | `/food-listings/{id}`               | Public (reserving needs a recipient account)   |
| Categories               | `/categories`, `/categories/{slug}` | Public                                         |
| Dashboard                | `/dashboard`                        | Signed in (different content per role)         |
| My listings              | `/my-listings`                      | Donor, admin                                   |
| Organizations            | `/organizations`                    | Signed in (edit: owner or admin)               |
| My reservations          | `/reservations`                     | Recipient                                      |
| Pickups                  | `/pickups`                          | Signed in (donor confirms, admin only watches) |
| Category management      | `/admin/categories`                 | Admin only                                     |
| Login, register, profile | `/login`, `/register`, `/profile`   | Public / signed in                             |

## Tech stack

- PHP 8.5, Laravel 13
- Blade templates
- Tailwind CSS 4 and Alpine.js (loaded from a CDN when there is no build)
- Blade Heroicons
- SQLite
- Pest for tests

## Installation

Requirements: PHP 8.5, Composer.

```bash
git clone https://github.com/Rowannnk/Foodshare.git foodloop
cd foodloop

composer install
cp .env.example .env
php artisan key:generate

touch database/database.sqlite

php artisan migrate:fresh --seed
php artisan storage:link

php artisan serve
```

Open <http://127.0.0.1:8000>.

- `php artisan storage:link` is needed so uploaded food photos are visible.
- No front-end build is needed. The design loads Tailwind from a CDN, so an internet connection is required. For compiled assets run `npm install && npm run build`.

## Demo accounts

All accounts use the password `password`.

| Role      | Email                     |
| --------- | ------------------------- |
| Admin     | `admin@admin.com`         |
| Donor     | `donor@donor.com`         |
| Recipient | `recipient@recipient.com` |

The seeder also creates other donors, recipients, organizations, food listings, reservations and pickups with random data.

## Emails

Emails are queued (`QUEUE_CONNECTION=database`). Start a worker in a second terminal to send them:

    php artisan queue:work

Without a worker the emails wait in the `jobs` table. Sent emails are written to `storage/logs/laravel.log` (`MAIL_MAILER=log`).

## Tests

```bash
php artisan test
```

## Git workflow

The project was built in small, atomic commits. Each commit adds one functional step, for example one model with its migration and factory, one controller, or one view.

## License

Created for educational purposes.
