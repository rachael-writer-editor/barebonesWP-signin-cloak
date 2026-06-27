# About barebonesWP-signin-cloak

I’m by no means a developer but I wanted to share this script built with AI that prevents predictable access to wp-login.php using falsified admin accounts.

This mu-plugin implementation ties WordPress login access to a short-lived (time-limited) cookie that's issued via a custom-slug URL.

** We edit .htaccess on Apache ** so it can check the cookie. Without this change wp-login.php remains accessible to the bots.

Note: This does not include two-factor authentication (2FA). It is not a security fortress; rather, a lightweight safeguard for the plugin weary.

## The Cloak Components

The mu_plugin - barebonesWP-signin-cloak.php

The .htacess insertion - login-cloak.htaccess

## Security Hardening Strategy

To minimise the site's attack surface, I team this script with: 

Restricted access to REST API - concealing username endpoints.

Profile Masking - I have obscured my internal usernames from public-facing author archives to prevent bot profiling. 


## Important Disclaimers

Not a Security Fortress - This is not a replacement for Two-Factor Authentication (2FA). 

Maintenance Responsibility - Because this hooks into WordPress core, you must test compatibility after major core updates. 

As is, the .htacess amendment blocks access to WordPress' password-reset function.

The "Lockout" Risk - If you forget your custom slug you must have access to your server via FTP/SSH to rename or remove the mu-plugin file to regain entry. 

Contra indicators 
* Some pre-packaged templates may require unfettered access to WordPress's mandated url.
* Cloudflare/CDNs/proxies may intercept requests before they hit Apache, causing this rule to silently not apply.
* Nginx - this rule is Apache-only (mod_rewrite). Won't work as-is on Nginx.

**Note:** if testing shows inconsistent results, try incognito/private browsing or clear your cache first — cached pages or stale cookies can yield false results.


## How to Use

* Download the barebonesWP-signin-cloak.php
* Open in a txt editor
* Locate: define( 'SECRET_LOGIN_SLUG', 'my-secret-entry-point' );
* IMPORTANT: Replace 'my-secret-entry-point' with your unique string (e.g., i-love-potatoes'). Then save.
* Upload the file to your /wp-content/mu-plugins/ directory.
* Back up your site's existing .htaccess. 
* Introduce login-cloak.htaccess edits above this line: '# BEGIN WordPress'

**Test:**
In private browsing:

Visit wp-login.php directly. You should get a 404, not the login form.

Visit your site with the custom url, typed as a clean path — e.g. yoursite.com/your-chosen-url. You should land on the real login form.


Aussie - Aussie - Aussie
 
