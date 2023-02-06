## Specs

- PHP 8.1
- MYSQL is 8.0.15
- Laravel version is 9.0


## Install and use
- Clone the repo
- run composer install
- run npm install
- run npm run build or npm run dev


## Project Code

### Controller
- [ItemController](app/Http/Controllers/ItemController.php)

### Model
- [Item](app/Models/Item.php)
- [Price](app/Models/Price.php)

### Database
- [ItemFactory](database/factories/ItemFactory.php)
- [PriceFactory](database/factories/PriceFactory.php)
- [Items Scheme](database/migrations/2023_02_06_173544_items.php)
- [Price Scheme](database/migrations/2023_02_06_173631_prices.php)
- [Price Seeder](database/seeders/PriceSeeder.php)

### Views
- [Button Component](resources/js/Components/Button/SmallRedButton.vue)
- [Group Component](resources/js/Components/Filter/GroupForm.vue)
- [Rule Component](resources/js/Components/Filter/GroupRule.vue)
- [Application Page](resources/js/Pages/QueryGenerator/App.vue)
