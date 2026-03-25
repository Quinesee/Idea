# Idea

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![PHP](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)

Idea is an application where users can sign up and keep track of ideas and the steps to bringing those ideas to completion. This is the example project from the [**Laravel From Scratch (2026 Edition)**](https://laracasts.com/series/laravel-from-scratch-2026) on Laracasts.com. I am using this project to get back up to speed with Laravel and to see what the latest version has to offer. I am also using it to practice writing tests using PEST.

## What I'm Learning

This project is giving me practical experience with:

- **Laravel 13 MVC** - resources, routing, RESTful controllers, and view rendering
- **Eloquent ORM** - model validations, associations (`has_many`, `belongs_to`),
- **Session management** - user authentication and authorization, access control of their own ideas
- **Testing** - Using PEST to do browser testing
- **Tooling** - Using Laravel Pint, Rector, and CodeRabbit in workflow to improve code quality and conform to best practices

## Features

- User registration, authentication, and authorization
- Idea capture including adding an image, description, steps, and links
- Idea CRUD interface
- Input validation with user-friendly error messages

## Tech Stack

| Layer     | Technology              |
| --------- | ----------------------- |
| Language  | PHP 8.4                 |
| Framework | Laravel 13              |
| Database  | SQLite3                 |
| Frontend  | Tailwind CSS, Alpine.js |

## Getting Started

```bash
git clone git@github.com:Quinesee/Idea.git
cd idea
npm install && npm run build
composer run dev
npm run dev
```

Then open [http://localhost:8000](http://localhost:8000).

## Running Tests

```bash
php artisan test
```
