# Usa una imagen oficial de Apache con PHP
FROM php:8.2-apache

# Instala extensiones necesarias (puedes agregar más si tu app lo requiere)
RUN docker-php-ext-install mysqli

# Habilita mod_rewrite para Apache si lo necesitas
RUN a2enmod rewrite

# Configura ServerName para evitar el warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Cambia el puerto de Apache a 8000 si tu plataforma lo requiere
RUN sed -i 's/80/8000/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Copia todo el contexto del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Da permisos de escritura a las carpetas donde se guardan logs y archivos generados
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/docs || true

# Crea los archivos necesarios si no existen y da permisos
RUN touch /var/www/html/contador_visitas.txt \
    && touch /var/www/html/cotizaciones.csv \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Expone el puerto 8000
EXPOSE 8000

# Opcional: configura el directorio de trabajo
WORKDIR /var/www/html

# Opcional: variables de entorno para PHP (ajusta según tus necesidades)
ENV TZ=America/Lima

# Opcional: configura el error reporting para desarrollo
RUN echo "error_reporting = E_ALL\n\
display_errors = On\n\
date.timezone = America/Lima" > /usr/local/etc/php/conf.d/docker-php-custom.ini