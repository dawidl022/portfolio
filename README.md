# Personal Website/Portfolio

[Live Website](https://dawidlachowicz.com/)


Portfolio created as part of [ECS417U - Fundamentals of Web Technology](http://www.eecs.qmul.ac.uk/undergraduate/programmes/module-information/items/ecs417u-fundamentals-of-web-technology.html)
coursework at [Queen Mary University of London](https://www.qmul.ac.uk/). Made using the [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) software stack. 

## Local development

1. Ensure you have [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) installed
2. Start the Apache web server and MySQL by running:
  ```bash
  cd docker
  docker compose up -d
  ```
3. Migrate the schema (still in the docker directory):
  ```bash
  docker compose exec database mysql -u root --password=password --database=portfolio -e 'source data/schema.sql'
  ```
4. Go to http://localhost:8080/register and create an account.
5. Seed the database with initial blog posts and grant the first user admin permissions:
  ```bash
  docker compose exec database mysql -u root --password=password --database=portfolio -e 'source data/seed.sql' 
  ```
