# WP-WEB-CRAWLER

A PHP-based application designed to help administrators enhance their website's SEO rankings. This tool facilitates website crawling, internal link analysis, and sitemap generation. Powered by Docker for effortless setup, wp-web-crawler offers an intuitive interface for evaluating internal link structures."

## Software Requirements

- **Docker**

## Additional Development Tools (Optional)

- **Make (Optional):** We recommend installing the "make" utility to simplify common development tasks.

## Installation

To install the WP-WEB-CRAWLER, follow these steps:

### Installation Via "make"

1. Ensure the "make" utility has been installed on your local machine.

2. Clone the repository to your local machine.

3. Navigate to the project directory.

4. Run the following command

   - make setup

   **NB: After running the command, the application would be installed.**

   - Use "**make help**" to access the list of available make commands

### Alternatively

1. Install Docker and Docker Compose on your system.

2. Clone the repository to your local machine.

3. Navigate to the project directory

4. Create a .env file based off .env.example

5. Start docker engine

6. Build containers

   - docker-compose build

7. Bring up containers in detached mode

   - docker-compose up -d

8. SSH into the wp-web-crawler app container

   - docker exec -it -u ubuntu wp-web-crawler /bin/bash

9. Run the following commands

   - composer install

## Accessing the application

- Visit the following urls to ensure everything is correctly setup:

  - **[WP-WEB-CRAWLER](http://localhost:7005)**

  ### Login Details

  - **Username:** test_user
  - **Password:** password

## Database management

To manage the database, use Adminer, which can be accessed at **[DB Management Interface](http://localhost:7002)**. Login with the following credentials:

- System: MySQL
- Server: db
- Username: wp_user
- Password: wp_root
- Database: wp

## Exploring How It Works

For a more detailed explanation of how the WP-WEB-CRAWLER application functions, you can refer to our [Explanation.md](explanation.md) document. This document provides insights into the internal workings of the application and can be a valuable resource for understanding its functionality.
