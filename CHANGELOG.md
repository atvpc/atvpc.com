## 0.5 (2014-09-02)
    - Switched from SQLite database to serialized arrays stored in .dat files
    - Simple visitor logger with currently online support
    - PSR-3 compatible logger

## 0.4 (2014-08-21)
    - txtbuch core live, running first ecommerce website
    - engine seperated from website content so changes can be tracked 
      easier from a git repo, using softlinks to include engine into 
      website

## 0.3 (2014-07-05)
    - Javascript init system lazy loads needed libraries and CSS based 
      on each page's content. Site theme can also lazy load additional 
      components as needed.

## 0.2 (2014-06-23)
    - Simple theme engine using {{ var }}. Special variables for calling 
      a function {{ func_$name }} and including a file {{ inc_$name }}
      
## 0.1 (2014-02-14)
    - Redesigned old txtbuch engine to be more modular. Somewhat MVC; 
      site content is located in a seperate content/ folder.
    - Reusable code organized into file libraries based on what they 
      do (ie: func_arr.php has functions that operate on arrays)
