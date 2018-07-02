Projekt pro RTSoft



note: htaccess se na git nechce uploadnout



Order Allow,Deny

Deny from all

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f

RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule !\.(pdf|js|ico|gif|jpg|png|css|rar|zip|tar\.gz)$ index.php [L]


