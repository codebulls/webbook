FROM eboraas/phalcon
MAINTAINER B-FACTOR "info@b-factor.de"

RUN export DEBIAN_FRONTEND=noninteractive && \
	apt-get update && \
	apt-get -y install imagemagick pdftk pngcrush && \
	cd /etc/apache2/sites-enabled && \
	rm -f *.conf && \
	ln -s ../sites-available/default 000-default.conf


WORKDIR /var/www/phalcon/public

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
