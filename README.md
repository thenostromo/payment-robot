# REQUIREMENTS
php 8.1

# INSTALLATION

1. Run ```composer install```
2. Copy the file ```.env -> .env.local```
3. Change the key ```EXCHANGE_RATE_API_KEY```. 
More details: https://apilayer.com/marketplace/exchangerates_data-api#documentation-tab

# USING
run command:
```symfony console CalculateCommisionsCommand <project_path>/files/input.txt```

# TESTS
1. Change the key ```EXCHANGE_RATE_API_KEY``` in the file ```.env.test```
2. Run command:
```make run-tests```

# UTILS
Fix code by coding standards:
```make php-cs-fixer-fix```
