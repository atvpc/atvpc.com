## 3.2 (2019-05-29)
- Switched PicoCMS assets to use Composer
- Updated insecure jQuery version

## 3.1 (2018-09-05)
- Protocol relative URLs (HTTP / HTTPS)
- Diagram redesigns
- Anchor links in Howto
- Unused assets purged

## 3.0.0 (2018-04-24)
- PicoCMS backend
- Rewrite of CSS theme to Bootstrap 4
- Responsive theme for small screens / mobile devices
- Yarn to keep site dependances up-to-date
- Simplified JS code 

## 2.1.2 (2017-12-15)
- Security fix: the http referrer for all visitors is stored in a plaintext .dat file. Malicious PHP code could be injected if the webserver is set to interprete all file extensions for PHP code (non-standard setup)

## 2.1.1 (2017-10-13)
- Minor changes to content by Cory
- Relicensed under the MIT License
- Source Code / git repo uploaded to GitHub

## 2.1 (2014-08-21)
- Added events widget that shows the current show/event the company is at or selects the nearest one with a friendly 10 day countdown.
- Code to prevent FOUC on the jQuery sliders

## 2.0 (2014-08-19)
- New theme based off of Frooition theme for ChannelAdvisor webstore
- CMS is a rehaul of the txtbuch beta engine
- Pages coverted to markdown and images optimized
- Bugfixes for Internet Explorer div widths

## 1.0 (2013-12-09):
- background images reduced in size and tiled via CSS
- changed fixed width to fluid width
- header contact info image replaced with actual text for SEO
- newsletter page and signup form
- contact information in footer of webpage
- store hours JavaScript that identifies today's hours and any special holiday hours

## 0.5 (2014-09-02)
- Switched from SQLite database to serialized arrays stored in .dat files
- Simple visitor logger with currently online support
- PSR-3 compatible logger

## 0.4 (2014-08-21)
- txtbuch core live, running first ecommerce website
- engine seperated from website content so changes can be tracked easier from a git repo, using softlinks to include engine into website

## 0.3 (2014-07-05)
- Javascript init system lazy loads needed libraries and CSS based on each page's content. Site theme can also lazy load additional components as needed.

## 0.2 (2014-06-23)
- Simple theme engine using {{ var }}. Special variables for calling a function {{ func_$name }} and including a file {{ inc_$name }}

## 0.1 (2014-02-14)
- Redesigned old txtbuch engine to be more modular. Somewhat MVC; site content is located in a seperate content folder.
- Reusable code organized into file libraries based on what they do (ie: func_arr.php has functions that operate on arrays)
