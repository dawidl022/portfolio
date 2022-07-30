FROM mysql:8.0.30

ENV MYSQL_DATABASE portfolio
ENV MYSQL_ROOT_PASSWORD password

COPY data data
