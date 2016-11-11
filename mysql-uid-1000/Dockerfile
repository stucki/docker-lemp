FROM mariadb:10.1

RUN usermod --uid 1000 mysql; \
	groupmod --gid 1000 mysql; \
	find / -uid 999 2>/dev/null | xargs -r chown mysql \
	find / -gid 999 2>/dev/null | xargs -r chgrp mysql
