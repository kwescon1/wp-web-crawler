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

     - Cron Service (cron) : A dedicated service for the purpose of executing cron jobs in the application.

## Code Explanation

The solution comprises the following main components:

1. **Login Page (`login.php`):** This page provides a login form that allows the administrator to login to their dashboard in order to trigger a crawl.

2. **Admin Page (`dashboard.php`):** This page provides a form and a button to trigger the crawl. On submission, the crawl process is initiated, and the results are stored. Also, on the page, there is a button that enables the admin to view results after crawling and there is a logout button to enable admins logout.

3. **Guest Page (`index.php`):** This page is the first page that a user accesses if not logged into the system. In essence, it is a page for guests. This page provides a button that can be used to view the latest content of the current sitemap.

## Achieving the Desired Outcome

In response to the user story, the application has been designed and implemented to precisely address the administrator's needs for improving website SEO rankings and gaining insights into internal link structures. Here's how the solution achieves these desired outcomes:

1. **Website Crawling Capability:** The application provides a web crawling feature that allows the administrator to initiate a crawl of their website's internal hyperlinks. This capability ensures that the administrator can systematically examine the website's internal structure.

2. **Internal Link Analysis:** After the crawl, the application presents the administrator with the results, specifically the internal links found on the website. These internal links show how web pages are interconnected with the homepage, fulfilling the requirement of understanding the website's link structure.

3. **Sitemap Generation:** The application not only displays internal links but also generates a sitemap for manual analysis. This sitemap provides an overview of the website's structure, making it easier for the administrator to identify opportunities for SEO improvement.

4. **Saving Homepage as .html:** As part of the website crawling process, the solution not only analyzes internal links but also generates a static .html file representing the homepage of the website. This .html snapshot allows administrators to:

   - Track Changes Over Time: It provides a snapshot of the homepage at a specific point in time, enabling administrators to track changes in content and structure over time.

   - Conduct SEO Analysis: Administrators can inspect the .html file for metadata, headings, and other SEO-related elements, contributing to better search engine rankings.

   - Offline Accessibility: The saved .html file allows offline access for SEO audits, report sharing, and annotations.

   - Historical Records: Multiple versions of the homepage can be saved as .html files, creating historical records for tracking website changes and their impact on SEO.

   - Improved Efficiency: Serving the homepage as a static .html file can enhance website performance by reducing dynamic page generation.

5. **Ease of Use:** The solution is user-friendly, with a straightforward interface for initiating crawls. The administrator simply enters the URL they want to crawl, and the application takes care of the rest, automating the crawling process.

6. **Error Handling:** Robust error handling and logging mechanisms are in place to ensure that the administrator is aware of any issues that may occur during crawling or data storage. This enhances the application's transparency and usability.

7. **Security:** The application includes security features, such as user authentication and session management, to protect the administrator's data and ensure privacy.

8. **Feedback Mechanism:** The application provides immediate feedback to the administrator, alerting them to the success or failure of the crawl. This ensures that the administrator is always informed about the status of the SEO analysis.

9. **Logging and Debugging:** Detailed error logs are maintained, helping the administrator and developers diagnose and troubleshoot any issues efficiently.

Overall, this solution empowers the administrator to achieve the desired outcome of analyzing internal link structures, identifying SEO improvement opportunities, and enhancing their website's search engine ranking. It does so by providing a user-friendly, automated, and secure platform for website crawling, data analysis, and sitemap generation.

## Problem-Solving Approach

**Analyzing the Problem:** Begin by thoroughly understanding the problem statement, its requirements, and potential challenges.

**Research and Learning:** Conduct research to gain insights into best practices and technologies related to the problem.

**Breaking Down Complexity:** Break down complex problems into smaller, manageable tasks or modules, making it easier to tackle them step by step.

**Planning and Design:** Create a high-level plan or design, outlining the architecture, technologies, and key components required.

**Testing and Validation:** Implement iterative development, continuously testing and validating solutions to ensure they meet the problem's requirements.

**Collaboration and Feedback:** If applicable, collaborate with team members or seek feedback from peers to improve the proposed solutions.

## Thought Process

**User-Centric Approach:** Prioritize understanding the end-users' needs and experiences, ensuring that the solution addresses their pain points effectively.

**Scalability and Flexibility:** Consider future scalability and flexibility, designing solutions that can adapt to changing requirements and growing user bases.

**Efficiency and Performance:** Focus on optimizing code and system performance to deliver responsive and efficient solutions.

**Security and Reliability:** Embed security best practices into solutions to protect against vulnerabilities and ensure data integrity.

**Maintainability:** Strive to create clean, well-documented code that is easy to maintain and extend, reducing technical debt.

## Choice of Direction

**Efficiency and Resource Optimization:** Docker containers efficiently package and deploy applications, saving resources and ensuring consistency across environments.

**Scalability:** Docker's containerization allows for easy scaling by running multiple instances of the same container as needed.

**Technology Alignment:** Leveraging technologies like PHP and Guzzle for web crawling aligns with industry standards and best practices.

**Error Handling:** Implementing error handling and logging with PHP ensures better visibility into issues during development and production.

## Why This Solution Is Superior

**Portability:** Docker containers are highly portable, enabling consistent deployment across various environments, including development, testing, and production.

**Isolation:** Containers offer process isolation, reducing conflicts between dependencies and enhancing application stability.

**Efficiency:** The use of PHP and Guzzle for web crawling is resource-efficient and allows for effective data retrieval from websites.

**Logging and Error Handling:** Implementing proper error handling and logging practices ensures better debugging and troubleshooting capabilities.

Overall, this approach ensures that the crawling application is well-structured, efficient, and robust, meeting both current and future needs effectively.

## Conclusion

The implemented solution offers administrators the ability to manually trigger crawls, store and display results, and generate a sitemap. While simplifying the crawl process, the solution meets the desired outcome outlined in the user story.
