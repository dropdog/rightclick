# TODO: Add more options with variables
# TODO: Add scripts to enable domains and dev mode

FROM dropdog/docker:latest
MAINTAINER HostDog <info@hostdog.eu>

ENV DEBIAN_FRONTEND=noninteractive GITPASS=passGITHUB2016 BRANCH=develop PROFILE=dropdog

# Start services
RUN service supervisor start

# Clean www to clone Drupal inside
RUN rm -rf /var/www && \
    # Clone from online repository.
    git clone https://dropdoguser:${GITPASS}@github.com/dropdog/full-drupal.git --branch ${BRANCH} /var/www && \

    # Prepare for installation
    mkdir -p /var/www/sites/default/files && \
    chmod -R a+w /var/www/sites/default && \
    cp /var/www/sites/default/default.settings.php /var/www/sites/default/settings.php && \
    cp /var/www/sites/default/default.services.yml /var/www/sites/default/services.yml && \
    chmod 0664 /var/www/sites/default/settings.php && \
    chmod 0664 /var/www/sites/default/services.yml && \
    chown -R www-data:www-data /var/www/sites/default && \

    # Project specific folders
    chown -R www-data:www-data /var/www/local-dev/config_customdev && \
    chmod -R a+w /var/www/local-dev/config_customdev && \
    chmod -R 644 /var/www/local-dev/config_customdev/sync/README.txt && \
    chmod -R 644 /var/www/local-dev/config_customdev/staging/README.txt

WORKDIR /var/www
# Drupal profile to install
RUN /etc/init.d/mysql start && \
    /usr/local/bin/drupal site:install ${PROFILE} \
    --site-name="Dropdog in Docker" \
    --db-type=mysql \
    --db-user=root \
    --db-pass="" \
    --db-name=drupal \
    --site-mail=admin@example.com \
    --account-name=admin \
    --account-mail=admin@example.com \
    --account-pass=admin && \

    # Common cleaning tasks and updates
    /etc/init.d/mysql start && \
    /usr/local/bin/drush entity-updates -y && \
    /usr/local/bin/drush php-eval 'node_access_rebuild();'

EXPOSE 80 3306 22

#CMD exec supervisord -n
ENTRYPOINT service supervisor restart && bash
