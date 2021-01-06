# Cloud & Docker 

LUYA has been proofenly used in different cloud environments using Docker and f.e. Kubernetes. This ensures your application runs in a stateless context, which means that your application does not store any informations inside the webserver itself. This makes it possible to scale LUYA into an infinite number of websites (PODs) where the load balancer can randomly send traffic to and the user won't notce anything, but actually jumping between webserver. This section explains how you have to configure LUYA in order to achieve this behavior.

## Overview

[![](https://mermaid.ink/img/eyJjb2RlIjoiZ3JhcGggVERcbiAgICBBW1VzZXIgdmlzaXRzIHlvdXIgV2Vic2VpdGVdXG4gICAgQSAtLT4gQntMb2FkIEJhbGFuY2VyfVxuICAgIEIgLS0-IERbTFVZQSBQT0QgIzFdXG4gICAgQiAtLT4gRVtMVVlBIFBPRCAjMl1cbiAgICBCIC0tPiBGW0xVWUEgUE9EICMzXVxuICAgIEQgLS0-IEdbRGF0YWJhc2VdXG4gICAgRSAtLT4gR1xuICAgIEYgLS0-IEdcbiAgICBEIC0tPiBIW0NhY2hpbmddXG4gICAgRSAtLT4gSFxuICAgIEYgLS0-IEhcbiAgICBEIC0tPiBJW1MzIFN0b3JhZ2VdXG4gICAgRSAtLT4gSVxuICAgIEYgLS0-IElcbiAgICAgICAgICAgICIsIm1lcm1haWQiOnt9LCJ1cGRhdGVFZGl0b3IiOmZhbHNlfQ)](https://mermaid-js.github.io/mermaid-live-editor/#/edit/eyJjb2RlIjoiZ3JhcGggVERcbiAgICBBW1VzZXIgdmlzaXRzIHlvdXIgV2Vic2VpdGVdXG4gICAgQSAtLT4gQntMb2FkIEJhbGFuY2VyfVxuICAgIEIgLS0-IERbTFVZQSBQT0QgIzFdXG4gICAgQiAtLT4gRVtMVVlBIFBPRCAjMl1cbiAgICBCIC0tPiBGW0xVWUEgUE9EICMzXVxuICAgIEQgLS0-IEdbRGF0YWJhc2VdXG4gICAgRSAtLT4gR1xuICAgIEYgLS0-IEdcbiAgICBEIC0tPiBIW0NhY2hpbmddXG4gICAgRSAtLT4gSFxuICAgIEYgLS0-IEhcbiAgICBEIC0tPiBJW1MzIFN0b3JhZ2VdXG4gICAgRSAtLT4gSVxuICAgIEYgLS0-IElcbiAgICAgICAgICAgICIsIm1lcm1haWQiOnt9LCJ1cGRhdGVFZGl0b3IiOmZhbHNlfQ)

This chart illustrates what is required to make your Webserver stateless:

1. Database
2. Caching Server (f.e. Memcached)
3. S3 compataible Storage (For file uploads, assets, etc.) working as a CDN

> There different solutions you can use, for example its not required to have a shared caching system, but its strongly required as a single request can warm a cache state for all webservers!

## Dockerize your Application

## Configure your Application

## Hints
