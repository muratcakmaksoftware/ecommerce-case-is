## Installation

### Database Create
Veritabanı otomatik oluşmaz ise manuel oluşturabilirsiniz:
```
CREATE DATABASE ecommerce
```
### Migration
```
php artisan migrate
```

### Seed ( Dummy Data )
```
php artisan db:seed
```

### Migrate Fresh & Seed
Veritabanını dummy data ile birlikte tekrar oluşturmak için
```
php artisan migrate:fresh --seed
```
## About
Postman API ve Example Request için:\
https://documenter.getpostman.com/view/14752307/UzR1J2f9
- Case olduğundan Authentication eklenmemiştir bunun yerine Test için app/Helpers/helpers.php içerisinde CustomerId belirtilmiştir.
- Repository Design Pattern kullanılmıştır.\
 (Controller => Service => RepositoryInterface => Repository)
- Trait, Stubs, Requests(FormRequest), Enums kullanılmıştır
- Dependency Injection kullanılmıştır.

### Preview

#### Database
![db!](./docs/db.jpg)

#### Postman API
![postman!](./docs/orders.jpg)

#### DB Connection
![db connection!](./docs/db-connection.jpg)
