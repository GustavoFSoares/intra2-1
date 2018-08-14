git pull
cd .\server && composer db-update && cd .\..
cd .\client && npm run build && cd .\..
php autorun.php