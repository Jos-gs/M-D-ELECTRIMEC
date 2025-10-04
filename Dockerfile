# Usa una imagen oficial de Apache con PHP
FROM php:8.2-apache

# Instala extensiones necesarias (puedes agregar más si tu app lo requiere)
RUN docker-php-ext-install mysqli

# Habilita mod_rewrite para Apache si lo necesitas
RUN a2enmod rewrite

# Copia todo el contexto del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Da permisos de escritura a las carpetas donde se guardan logs y archivos generados
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/docs || true

# Expone el puerto 80
EXPOSE 80

# Opcional: configura el directorio de trabajo
WORKDIR /var/www/html

# Opcional: variables de entorno para PHP (ajusta según tus necesidades)
ENV TZ=America/Lima

# Opcional: configura el error reporting para desarrollo
RUN echo "error_reporting = E_ALL\n\
display_errors = On\n\
date.timezone = America/Lima" > /usr/local/etc/php/conf.d/docker-php-custom.ini