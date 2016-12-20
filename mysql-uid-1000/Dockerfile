FROM mariadb:10.1

# Run MariaDB with user id 1000. This is usually the uid of the user who works on the host.
# The result is that the /var/lib/mysql folder will be read-/writeable to this user.
# If it causes any trouble on your system, just comment out all lines below, then run
# "docker-compose build" again.
RUN usermod --uid 1000 mysql; \
	groupmod --gid 1000 mysql; \
	find / -uid 999 2>/dev/null | xargs -r chown mysql \
	find / -gid 999 2>/dev/null | xargs -r chgrp mysql
