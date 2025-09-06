FROM php:8.1-apache

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . /var/www/html/

# Définir les permissions appropriées
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Port exposé
EXPOSE 80

# Configuration Apache pour PHP
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Démarrage d'Apache
CMD ["apache2-foreground"]