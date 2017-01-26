
================
Additional Notes
================

.. highlight:: shell
.. default-role:: code


Expose MySQL-like Database Server to the Host System
====================================================

You may want to use a non-default port like `4306` to avoid conflicts with the host system.
Here is an example snippet from :file:`docker-compose.yml`::

  db:
    image: mariadb:10.1
    environment:
      - MYSQL_ROOT_PASSWORD=secret
    volumes:
      - ./mysql:/var/lib/mysql
    ports:
      - "4306:3306"


Start daemonized and list containers::

    cd docker-lemp
    docker-compose up -d
    docker ps

Test the connection to the database server::

    ➜  docker-lemp git:(master) ✗ mysql -h 127.0.0.1 -P 4306 -u root -psecret

    Welcome to the MySQL monitor.  Commands end with ; or \g.
    Your MySQL connection id is 3
    Server version: 5.5.5-10.1.19-MariaDB-1~jessie mariadb.org binary distribution

    Copyright (c) 2000, 2016, Oracle and/or its affiliates. All rights reserved.

    Oracle is a registered trademark of Oracle Corporation and/or its
    affiliates. Other names may be trademarks of their respective
    owners.

    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

    mysql> quit
    Bye

Success!

You can now use database connections. An example of Python-Flask notation is::

    mysql+mysqldb://root:secret@127.0.0.1:4306/my_database_001


.. attention::

   Pitfall! **Do write `127.0.0.1`.** Do not write `localhost`!


With `localhost` you'll get an ERROR similar to::

    ➜  docker-lemp git:(master) ✗ mysql -h localhost -P 4306 -u root -psecret
    ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)

The reason for this is that with `localhost` a socket connection will be tried instead
of a TCP/IP connection.


Log all Database Queries
========================

While developing and debugging there may be times when you want to log all database queries.

Make sure you can edit the configuration file :file:`/etc/mysql/my.cnf`::

    # go to the shell of the db container
    docker exec -it dockerlemp_db_1 bash

    # update packages list
    apt-get update

    # install editor
    apt-get install vim

    # edit
    vi /etc/mysql/my.cnf

    # return
    exit

Read about `MariaDB's general logging facility <https://mariadb.com/kb/en/mariadb/general-query-log/>`__.
In :file:`my.cnf` update the `mysqld` section::

    [mysqld]
    general-log
    general-log-file=queries.log
    log-output=file

Restart the database container. Afterwards watch out for :file:`docker-lemp/mysql/queries.log` on the host system.


phpMyAdmin
==========

Use an extra Docker container to run `phpMyAdmin`:

#. Bring up the `docker-lemp` stack::

      cd docker-lemp
      docker-compose up -d

#. List the docker containers and verify that the container `dockerlemp_db_1` is there.
   Remember that name::

      docker ps

#. List the networks and verify that the container `dockerlemp_default` is there.
   Remember that name::

      docker network ls


#. Run phpMyAdmin in a Docker container with the name `phpadmin_dockerlemp`. Run as a daemon,
   remove the container after stopping, link to the container with the DB server
   in the appropriate network and show up as `http://localhost:8181
   <http://localhost:8181>`__::

      DBSERVER=dockerlemp_db_1
      DBNETWORK=dockerlemp_default
      docker run --name phpadmin_ter -d --rm  \
         --link=${DBSERVER}:db --network=${DBNETWORK} \
         -p 8181:80  phpmyadmin/phpmyadmin


#. Go to http://localhost:8181 on the host system. Use `root` and `secret` to login into
   phpMyAdmin as database root user.

#. Stop the container when done, thereby removing it::

      ➜ docker stop phpadmin_dockerlemp

Have fun!
