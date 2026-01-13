# Sistem Pengelolaan Laporan Monitoring dan Evaluasi Program Studi


set up lingkungan docker pada ubuntu:

1. masuk ke bash container ci_app : docker exec -it ci_app bash
2. install composer terlebih dahulu : composer install
3. ubah kepemilikan foldernya : chown -R www-data:www-data /var/www/codeigniter/writable
4. set permission aman : chmod -R 775 /var/www/codeigniter/writable