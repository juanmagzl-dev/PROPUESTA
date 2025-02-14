# Usa la imagen oficial de PHP con Apache
FROM php:apache

# Copia todo el código de tu proyecto al servidor Apache
COPY . /var/www/html/

# Exponer el puerto 80 para recibir tráfico HTTP
EXPOSE 80

# Iniciar Apache cuando se ejecute el contenedor
CMD ["apache2-foreground"]
