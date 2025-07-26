

# Backend Setup

## PHP configuration

1. Set the Upload size to 5-10 MB 
```
upload_max_filesize	10M 
post_max_size	10M
```

##  Environment Variable Configuration [.env]
1. Configure the .env for the 'APP_NAME='

```
APP_NAME='Laravel Name'
```

2. Configure the Database Configuration on the .env

```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

# Installation Process and Running the Laravel Application

Required Applications and install this all application
- **PHP Version**: [8.4.10](https://www.php.net/downloads.php)
- **Composer version**[2.8.10](https://getcomposer.org/download/)
- **Nodejs Version** [24](https://nodejs.org/en)
- **Git** [Latest](https://git-scm.com/downloads) Version

Instruction :
1. Download the Source Code from the Github Repository 
```
git clone https://github.com/140053/laravel_research_repo.git
```
2. Navigate to the source code 
```
cd laravel_research_repo
```
3.Run Composer Install to Install Modules
```
composer install
```
4. Install Node Modules & Build 
```
npm install & npm run build
```
5. Run Migration to Initialized the Database
```
php artisan migrate
```
6. Run Migration With Seed to populate the database admin and user account
```
php artisan migrate:fresh --seed
```
7. Run the Application 
```
php artisan serve
```



## Seeder Option 

```
php artisan db:seed --class=DevSeed
```



