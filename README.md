
[//]: # (todo  Изменить пути сохраниения media по модели и разбивать на подкатегории по типу 
            media/users/10/101)
Запуск проекта

1. git clone https://github.com/DanilShchepelin/learning-laravel.git <название_папки>
2. создать файл .env скопировать в него .env.example
3. composer install
4. поменять DB_HOST на mysql
5. alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
6. sail up -d
7. sail php artisan migrate --seed
