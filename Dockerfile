# Usa una imagen oficial de Apache con PHP
FROM php:8.2-apache

# Instala extensiones necesarias (puedes agregar más si tu app lo requiere)
RUN docker-php-ext-install mysqli

# Habilita mod_rewrite para Apache si lo necesitas
RUN a2enmod rewrite

# Configura ServerName para evitar el warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configura DirectoryIndex para que index.php sea el archivo por defecto
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Asegura que solo un MPM esté activo - elimina todos y crea enlaces manualmente solo para prefork
RUN a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null || true && \
    rm -f /etc/apache2/mods-enabled/mpm_*.conf /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null || true && \
    rm -f /etc/apache2/conf-enabled/*mpm*.conf 2>/dev/null || true && \
    # Crea enlaces simbólicos manualmente solo para mpm_prefork
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf && \
    ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load && \
    # Verifica que solo prefork esté habilitado
    echo "MPM modules enabled:" && \
    ls -la /etc/apache2/mods-enabled/ | grep mpm || echo "No MPM modules found" && \
    MPM_COUNT=$(ls -1 /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null | wc -l) && \
    echo "Total MPM modules: $MPM_COUNT" && \
    if [ "$MPM_COUNT" -ne 1 ]; then \
        echo "ERROR: Expected 1 MPM, found $MPM_COUNT"; \
        exit 1; \
    fi

# Copia todo el contexto del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Da permisos de escritura a las carpetas donde se guardan logs y archivos generados
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/docs || true

# Crea los archivos necesarios si no existen y da permisos
RUN touch /var/www/html/contador_visitas.txt \
    && touch /var/www/html/cotizaciones.csv \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Crea un script de inicio que configura el puerto dinámicamente desde la variable PORT
RUN echo '#!/bin/bash' > /usr/local/bin/start-apache.sh && \
    echo 'set -e' >> /usr/local/bin/start-apache.sh && \
    echo '' >> /usr/local/bin/start-apache.sh && \
    echo '# Verifica que solo un MPM esté habilitado' >> /usr/local/bin/start-apache.sh && \
    echo 'MPM_COUNT=$(ls -1 /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null | wc -l)' >> /usr/local/bin/start-apache.sh && \
    echo 'if [ "$MPM_COUNT" -gt 1 ]; then' >> /usr/local/bin/start-apache.sh && \
    echo '  echo "ERROR: Multiple MPMs detected. Disabling all and enabling only prefork..."' >> /usr/local/bin/start-apache.sh && \
    echo '  a2dismod mpm_event mpm_worker 2>/dev/null || true' >> /usr/local/bin/start-apache.sh && \
    echo '  rm -f /etc/apache2/mods-enabled/mpm_*.conf /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null || true' >> /usr/local/bin/start-apache.sh && \
    echo '  a2enmod mpm_prefork' >> /usr/local/bin/start-apache.sh && \
    echo 'fi' >> /usr/local/bin/start-apache.sh && \
    echo '' >> /usr/local/bin/start-apache.sh && \
    echo '# Obtiene el puerto de la variable de entorno PORT (Railway lo proporciona)' >> /usr/local/bin/start-apache.sh && \
    echo 'PORT=${PORT:-8000}' >> /usr/local/bin/start-apache.sh && \
    echo '' >> /usr/local/bin/start-apache.sh && \
    echo '# Configura Apache para escuchar en el puerto especificado' >> /usr/local/bin/start-apache.sh && \
    echo 'sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf' >> /usr/local/bin/start-apache.sh && \
    echo 'sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf' >> /usr/local/bin/start-apache.sh && \
    echo '' >> /usr/local/bin/start-apache.sh && \
    echo '# Inicia Apache' >> /usr/local/bin/start-apache.sh && \
    echo 'exec apache2-foreground' >> /usr/local/bin/start-apache.sh && \
    chmod +x /usr/local/bin/start-apache.sh

# Expone el puerto (Railway usará la variable PORT)
EXPOSE 8000

# Opcional: configura el directorio de trabajo
WORKDIR /var/www/html

# Opcional: variables de entorno para PHP (ajusta según tus necesidades)
ENV TZ=America/Lima

# Opcional: configura el error reporting para desarrollo
RUN echo "error_reporting = E_ALL\n\
display_errors = On\n\
date.timezone = America/Lima" > /usr/local/etc/php/conf.d/docker-php-custom.ini

