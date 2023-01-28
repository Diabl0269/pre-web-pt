FROM mysql:8.0.32

COPY forum.sql /docker-entrypoint-initdb.d/