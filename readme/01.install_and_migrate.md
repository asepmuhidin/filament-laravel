#instalasi laravel dan filament
- install composer
- install laravel 
  composer create-project --prefer-dist laravel/laravel project_name
- migration
  cd project_name
  php artisan migrate  
- install filament
  composer require filament/filament:"^3.2" -W  
- install filament panel
  php artisan filament:install --panels 
- create user panel
  php artisan make:filament-user
- Running laravel : php artisan serve
- akses http://localhost:8000/admin
- login dengan user panel sebelumnya


# make model and migration
  php artisan make:model Category -m
  nama model : singular (Catgory)
  nama tabel yang digenerate : Plural (categories)
  nama file migration : Plural (???_create_catgories_table.php )
  
  untuk model dengan 2 kata, contoh : order detail
  php artisan make:model OrderDetail -m
  nama model : singular (OrderDetail)
  nama tabel yang digenerate : Plural (order_details)
  nama file migration : Plural (???_create_order_details_table.php )

Lebih mudah dimulai dari make model dari pada dari make:migration
  ** Models **
    - Category
    - Brand
    - Product
    - Customer
    - Order
    - OrderDetail  

jika ada error pada proses migration, maka bisa rollback, lalu migrate kembali
php artisan migrate -->error
php artisan migrate:rollback -->kembali ke awal, sebelum migrate
perbaiki error file migration, simpan
php artisan migrate -->lakukan migrate kembali

# migrate-spes-file
php artisan migrate:refresh --path="database/migrations/Your_Migration_File_Name_table.php"

# create resource model
    - Category
    - Brand
    - Product
    - Customer
    - Order
    - OrderDetail  
