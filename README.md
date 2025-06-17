# 📓 Personal Journal App (Laravel 12 + TALL Stack)

A secure, rich-featured journaling app built with the TALL stack. Designed for privacy, mood tracking, and insightful reflection.

## 🚀 Tech Stack

- **Laravel 12** (PHP 8.2+)
- **Tailwind CSS 3.3+**
- **Alpine.js 3.12+**
- **Livewire 3**
- **MySQL 8**
- **Spatie MediaLibrary** (images, PDFs)
- **Laravel Scout + Meilisearch** (search)
- **Chart.js** (analytics)
- **DomPDF** (export entries)
- **Cloudinary** (media storage)

## 🔐 Key Features

- Rich text journal entries (Trix Editor)
- Image & PDF upload support
- Mood tagging (😊 😢 😐)
- End-to-end encryption for entry content
- Mood analytics dashboard (Chart.js)
- Full-text search (Scout)
- PDF export
- Email verification, 2FA-ready
- Session auto-expiry after 30 minutes
- Clean UI with Alpine.js interactivity

## 📦 Setup

```bash
git clone https://github.com/your-username/journal-app.git
cd journal-app

# Install dependencies
composer install
npm install && npm run dev

# Copy environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Migrate DB
php artisan migrate

# Start dev server
php artisan serve
