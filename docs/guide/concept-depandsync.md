**WIP**

Deployment and Sync
===

As part of LUYA we have build an eco system in order to sync and deploy your website. Therefore this guide explains the best practice of how to bring your website online and sync it back to your local dev.

Those things are required for this guide:
+ Git repository (we use GitHub)
+ Server with SSH access (Prod environment)
+ Your local dev machine with LAMP or WAMP Stack.


**We never sync data into the ProdServer, only the oposite way!**

When starting to build a Website you are developing on your local dev machine, create the Git Repository, checkout the LUYA kickstarter project, add those files into Git and start develop your Website.

We recommend you to deploy the website to the Server in a very early stadium of the development cycle. So use dummy text data on your local system.

Deployment
---

1. Setup your Server Prod environment (create database, enable ssh, etc.)
2. Change the `env-prod.php` config.
3. Install the [LUYA DEPLOYER](https://luya.io/guide/module/luyadev---luya-deployer) so you can deploy your website with `./vendor/bin/dep luya prod`.

You are now ready to deploy your website into the server and can now start add content on the production env.

Sync
---

We have built a sync command to sync the database and files from PROD to any local client. In order to setup this command log in to the admin interface of your PROD / Server website, navigat to System -> Machines and create a new one, you will need the identfier and token.

Now run `./vendor/bin/luya admin/proxy` you will have to enter the url of your prod env like `https://luya.io` and then enter machine and identifier you get from the previous step.
