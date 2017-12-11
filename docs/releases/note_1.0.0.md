# LUYA 1.0.0 Release Notes

Today, after more than two years of development, we are proud to announce the release of version 1.0 of LUYA. Along the way to this milestone, the system has seen 6'500 commits, 16 alpha releases, 8 beta releases and 4 release candidates. 35 developers have contributed to the source code and provided translations for 10 languages. LUYA has been downloaded 79565 (overall) times and has been used for more than 100 web projects, some popular high-traffic websites among them. But more important than looking back is looking forward to the further development and adoption of LUYA and the growth of its community in the months and years to come!

**Why use LUYA for your next web project?**

These are just some of the advantages:

- building upon the solid and popular Yii framework, LUYA offers a clear and modular architecture that can easily be extended to any needs
- console commands for scaffolding, content synchronization, deployment and other tasks let developers (and clients) save time and money
- pro-active error reporting helps discovering and ironing out bugs
- LUYA is well-tested and includes state-of-the-art security measures
- a comprehensive and continually extended guide and API documentation makes learning the ins and outs of LUYA a breeze
- the administration UI is clearly structured and easy to use
- LUYA is and will always be free to use

Give LUYA a try! We provide kickstarter repositories as well as a an online demo ([https://demo.luya.io/)].

**LUYA 1.0 includes the following components in stable release:**

+ **core**: is the foundation upon which all modules build their specific functionality
 + **admin**: provides an administration user interface with login screen, user and permission management, CRUD views, full text search and many other features that can be extended by other modules
 + **cms**: extends the web application framework to be a powerful and versatile content management system
 + **deployer**: makes it painless to deploy projects to several environments using console commands (and to roll back to the previous version within seconds should anything go wrong)
 + **testsuite**: provides PHPUnit test cases and a built-in web server to test applications, modules, components, APIs and classes
 + **errorapi**: sends exceptions to custom error APIs, enabling notifications through email, Slack and other channels
 + **frontendgroup**: allows to restrict web page access in the frontend to specific user groups and their users
 + **crawler**: feeds the full-text search of a website by crawling its pages and creating an index that can be influenced by special markup in the source code of the pages
 + **remoteadmin**: collects data from multiple LUYA installations (that can be located on different hosting environments) and combines it on an overview screen
 - **styleguide**: creates a visual catalog of all design modules implemented as luya/web/Element components
 + **contactform**: makes the creation of contact forms (as well as other types of online forms) a simple and quick task
 + **gallery**: extends LUYA with the possibility to place image galleries on web pages
 + **news**: provides basic news features with overview and detail views, categories and tags

LUYA 1.0 includes common content blocks and widgets that are available in two flavors as separate repositories: generic and bootstrap3. Complement these with your own specific blocks and widgets.

**Additions and enhancements since RC4 include:**

+ Cross Origin Resource Sharing (CORS) can be enabled to accept AJAX requests from other domains
+ The local file system can be swapped for other storages like Amazon's EC2
+ The link plugin can target mail addresses and storage files besides menu items and external URLs
+ Web pages can be scheduled to become active and inactive at specific dates and times
+ Web page content can be accompanied by microdata in JSON-LD format 
+ The tabs to open relational data in CRUD views have been improved (they open automatically and are labelled)
+ The administration UI includes the feature to define variables (key/value) that can be used throughout the frontend and elsewhere
+ URL redirections can be defined directly in the administration UI (e.g. to forward old URLs or to provide short URLs for communication purposes)
+ The administration's UI has seen many other improvements and bug fixes
+ Security has been enhanced
