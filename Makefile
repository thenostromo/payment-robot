php-cs-fixer-fix:
	vendor/bin/php-cs-fixer fix src --rules=@PSR1,@PSR12,full_opening_tag,indentation_type

run-tests:
	symfony php ./vendor/bin/phpunit --testdox --group unit,integration
