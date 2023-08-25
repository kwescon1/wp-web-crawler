# Explanation of Solution

## Problem Statement

The task involves building a PHP application or WordPress plugin that allows administrators to manually trigger a crawl of their website's home page, extract internal hyperlinks, store the results temporarily in a database, and display them on an admin page. Additionally, the solution should allow viewing the results and sitemap by both admins and visitors.

## Technical Specification

To achieve the desired outcome, the solution involves the following technical steps:

1. **Backend Admin Page:** A backend admin page is created where administrators can log in and manually trigger a crawl.
2. **Crawl Task Scheduling:** Upon triggering a crawl, a task is scheduled to run immediately and then every hour.
3. **Crawl Process:**
   - The results from the previous crawl and sitemap.html are deleted.
   - The crawl starts at the website's root URL (home page).
   - Internal hyperlinks are extracted using regular expressions.
   - Extracted links are stored temporarily in a MySQL database.
   - Results are displayed on the admin page.
   - The home page's `.php` file is saved as `.html`.
4. **Sitemap Generation:** A `sitemap.html` file is generated, displaying the results as a sitemap list structure.
5. **View Results:** Administrators can view the results stored in the database on the admin page.
6. **Error Handling:** If errors occur, error notices are displayed to guide administrators.
7. **Front-End Access:** Visitors can view the sitemap.html page.

## Technical Decisions And Why

### Object-Oriented Programming (OOP) Approach

An object oriented programming approach was embraced for the core application architecture. This decision offers a more organized, modular, and maintainable codebase, enhancing code readability and reducing complexities.

### PHP App

The decision to build a PHP app was driven by several key factors. Building a PHP app provides the scalability required for potential future expansion or integration with diverse systems and platforms beyond the scope of WordPress. This approach emphasizes simplicity and clarity, leading to a more focused codebase without unnecessary overhead or complexity associated with integrating into WordPress's extensive ecosystem. The isolation offered by a standalone PHP app ensures that it operates autonomously, minimizing conflicts with existing plugins, themes, or customizations. Moreover, the choice to develop a PHP app offers unparalleled flexibility and control over the application's architecture, design, and functionalities, enabling precise implementation of the required features to achieve the desired outcome.

1. **Dockerization:** Docker containers were leveraged to ensure a uniform development and deployment environment. This encompassed the configuration of PHP, MariaDB/MySQL, and the web server components.

   - The below services were defined

     - Database service (db) : The choice was made to utilize MySQL as the database within this service for storing temporary crawl results and user information due to its reliability and compatibility with PHP

     - DB Management Service (adminer) : The choice to utilize Adminer in this service as the database management tool is because of it user-friedly interface, support for various db systems and security features. It is lightweight and convenient for managing databases, particularly for smaller projects where a full-fledged database management system might be excessive.

     - Webserver service (wp_webserver) : Nginx with PHP-FPM is often a preferred choice for its memory efficiency, scalability, and performance.

     - PHP service (app) : Since the application is a PHP application, there was a need to build a service that would be dedicated to running the application

     - Dependency Management Service (composer) : A dedicated service was built for the purposes of installing application dependencies

## Code Explanation

The solution comprises the following main components:

1. **Login Page (`login.php`):** This page provides a login form that allows the administrator to login to trigger a crawl.

and a button to trigger the crawl. On submission, the crawl process is initiated, and results are displayed.

2. **Admin Page (`index.php`):** This page provides a form that and a button to trigger the crawl. On submission, the crawl process is initiated, and results are displayed.

## Achieving the Desired Outcome

- Administrators can log in

## Problem-Solving Approach

## Conclusion
