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

	# Install templates
	mkdir -p $(DESTDIR)/usr/share/ts-yt-dl/templates
	cp -a templates/* $(DESTDIR)/usr/share/ts-yt-dl

	# Create www storage, tmp request, and log folders
	mkdir -p $(DESTDIR)/srv/ts-yt-dl/www
	mkdir -p $(DESTDIR)/srv/ts-yt-dl/tmp
	mkdir -p $(DESTDIR)/var/log/ts-yt-dl
	chown www-data:www-data $(DESTDIR)/srv/ts-yt-dl/www
	chown www-data:www-data $(DESTDIR)/srv/ts-yt-dl/tmp
	chown www-data:www-data $(DESTDIR)/var/log/ts-yt-dl

	# Install crontab
	install -D -m 0644 cron/ts-yt-dl-crontab $(DESTDIR)/etc/cron.d/ts-yt-dl
	install -D -m 0755 cron/ts-yt-dl-cron $(DESTDIR)/etc/cron.hourly/ts-yt-dl

	@echo " done."

uninstall:
	@echo "Uninstalling ts-yt-dl ..."

	# Uninstalling html executables
	rm -rf $(DESTDIR)/var/www/html/ts-yt-dl

	# Uninstall templates
	rm -rf $(DESTDIR)/usr/share/ts-yt-dl/templates

	# Uninstall www storage, tmp request, and log folders
	rm -rf $(DESTDIR)/srv/ts-yt-dl/www
	rm -rf $(DESTDIR)/srv/ts-yt-dl/tmp
	rm -rf $(DESTDIR)/var/log/ts-yt-dl

	# Uninstall crontab
	rm -f $(DESTDIR)/etc/cron.d/ts-yt-dl
	rm -f $(DESTDIR)/etc/cron.hourly/ts-yt-dl

	@echo " done."

clean:

distclean:

reinstall: uninstall install
