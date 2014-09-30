# Makefile

SHELL := sh -e

SCRIPTS = cron/ts-yt-dl-cron

all: build

test:
	@echo -n "Checking for syntax errors"

	@for SCRIPT in $(SCRIPTS); \
	do \
		sh -n $${SCRIPT}; \
		echo -n "."; \
	done

	@echo " done."

	@echo -n "Checking for bashisms"

	@if [ -x /usr/bin/checkbashisms ]; \
	then \
		for SCRIPT in $(SCRIPTS); \
		do \
			checkbashisms -f -x $${SCRIPT}; \
			echo -n "."; \
		done; \
	else \
		echo "WARNING: skipping bashism test - you need to install devscripts."; \
	fi

	@echo " done."

build:
	@echo "Nothing to build."

install:
	@echo "Installing ts-yt-dl ..."

	# Installing html executables
	mkdir -p $(DESTDIR)/var/www/html/ts-yt-dl
	cp -a scripts/* $(DESTDIR)/var/www/html/ts-yt-dl
	chown -R www-data:www-data $(DESTDIR)/var/www/html/ts-yt-dl

	# Installing defaults
	mkdir -p $(DESTDIR)/var/www/ts-yt-dl-defaults
	install -D -m 0600 defaults/ts-yt-dl $(DESTDIR)/var/www/ts-yt-dl-defaults
	install -D -m 0600 defaults/mysql_security $(DESTDIR)/var/www/ts-yt-dl-defaults
	chown -R www-data:www-data $(DESTDIR)/var/www/ts-yt-dl-defaults

	# Create www storage and log folders
	mkdir -p $(DESTDIR)/srv/ts-yt-dl
	mkdir -p $(DESTDIR)/var/log/ts-yt-dl
	chown www-data:www-data $(DESTDIR)/srv/ts-yt-dl
	chown www-data:www-data $(DESTDIR)/var/log/ts-yt-dl

	@echo " done."

uninstall:
	@echo "Uninstalling ts-yt-dl ..."

	# Uninstalling html executables
	rm -rf $(DESTDIR)/var/www/html/ts-yt-dl
	rm -f $(DESTDIR)/var/www/mysql_security.php

	# Uninstalling defaults
	rm -rf $(DESTDIR)/var/www/ts-yt-dl-defaults

	# Uninstall www storage and log folders
	rm -rf $(DESTDIR)/srv/ts-yt-dl
	rm -rf $(DESTDIR)/var/log/ts-yt-dl

	@echo " done."

clean:

distclean:

reinstall: uninstall install
