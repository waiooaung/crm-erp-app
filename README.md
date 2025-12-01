<p align="center"><a href="https://filamentphp.com" target="_blank"><img src="https://www.google.com/search?q=https://filamentphp.com/images/og.jpg" width="400" alt="Filament Logo"></a></p>

AI-Powered Asset Management System

An intelligent IT Asset Management (ITAM) system built with Laravel 11 and Filament V3. This application leverages OpenAI to automate data entry, classify maintenance issues, and generate natural language summaries for assets.

🚀 Key AI Features

This is not just a CRUD application. It includes several AI-powered modules:

✨ AI Asset Summarizer: Automatically generates concise, human-readable status summaries based on asset history and transaction logs.

🤖 Smart Categorization: Auto-suggests asset categories based on model names during data entry.

🔧 AI Issue Classifier: Analyzes user-reported issue descriptions to determine if the problem is Hardware, Software, or User Error, and assigns an appropriate Priority Level (Low/High/Critical).

🔍 Natural Language Search: (Optional) Interpret complex user queries like "Show me all broken laptops assigned to John" into database filters.

🧾 Audit Logs: Detailed, readable activity logs tracking exactly what changed (e.g., "Status changed from In Stock → Assigned").

🛠️ Prerequisites

Before you begin, ensure you have the following installed:

PHP 8.2 or higher

Composer

MySQL or MariaDB

Node.js & NPM (for building assets)

OpenAI API Key (Required for AI features)

📦 Installation Guide

Follow these steps to get the project running on your local machine.

1. Clone the Repository

git clone [git@github.com:waiooaung/crm-erp-app.git]
cd crm-erp-app


2. Install Dependencies

Install PHP and JavaScript dependencies:

composer install
npm install && npm run build


3. Environment Setup

Copy the example environment file:

cp .env.example .env


4. Generate Application Key

Generate the unique application encryption key:

php artisan key:generate


5. Configure Database & API Key

Open the .env file in your code editor and update the following lines:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

# Add your OpenAI Key here
OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxxxxxxxxxxxxx


6. Migrate and Seed Database

Run the migrations to create the tables (assets, issues, activities, etc.) and seed sample data:

php artisan migrate --seed


7. Link Storage

Create the symbolic link for uploading images/receipts:

php artisan storage:link


8. Create an Admin User

If you didn't seed a specific user, create a Filament admin user manually:

php artisan make:filament-user
# Follow the prompts to enter Name, Email, and Password


🏁 Running the Application

Start the local development server:

php artisan serve
