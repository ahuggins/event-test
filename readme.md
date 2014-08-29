# Events

Events is a web application built by the contributors listed on Github. Supposed to be a simple easy way to list the events of a city. Currently still a work in progress, but is being worked on (albeit slowly, because we all have day jobs). The main purpose of the project was to learn about the excellent Laravel framework, as well as practicing a Git workflow with multiple contributors. 


## Short Term To Do's

* User
    * Profile
        * integrate social networks
    * "attend" an event
    * Dashboard
* Event
    * Add Mapping to an event.
* Emails
    * Sign Up
    * Password Reset
    * Event Notices
    * Weekly Notices
* Tags
    * Follow a tag to be notified of new events
* When user logs in, should show them a "Dashboard" with the events they are "attending." Then they can view All Events to add more to their attendlist. Attendlist could be used to send email notifications.
* Way to limit image upload size.

* ~~Ability to add custom images to an event. Probably limit to a few. Sponsored events would be able to add more.~~
* ~~Add Auto-complete for tags, add limitation of the tags in the DB Tags table~~
* ~~Ability to add tags to an event when creating an event...using the events-tags-relation table~~
* ~~Getting actual Date information on Events (no longer using the seed data)~~
* ~~Organizing events correctly when viewing "All Events". By "today", "Tomorrow","Next Week","Later"~~
* ~~Develop an Event View~~


## Long Term To Do's

* Would be awesome to integrate with Facebook
	* Bring in events from Facebook data (pulling from people who have allowed access by Events)
	* Allow people to RSVP to an event using Facebook profile
* Add a "Specials" or "Deals" offering to the site
	* This could be handled as advertising (pay to have a special listed)
* Along the same lines, perhaps a "Job Listing" area as well
	* Pay to have job listed
	* Or, cover charges for the events?
* Notifications: Email and/or Text
	* Thinking each week an email is sent reminding people of events they have said they are going to, or would just be interested in


## Installing

### Composer
You will need to have [Composer](https://getcomposer.org/) installed. 

Anytime you do a pull, remember to run Composer Update.

Familiarity with Laravel and running Migrations and Seeds is going to help.

### Vagrant
A Vagrant file is provided, so you should be able to pull master, command line into the folder and run Vagrant Up...assuming you have Vagrant and Virtual Box installed: [Vagrant](http://www.vagrantup.com/)  and [Virtual Box](https://www.virtualbox.org/)

I would also recommend using Homestead provided by Laravel. A great article on how to set that up is [here](http://scotch.io/tutorials/php/getting-started-with-laravel-homestead)


### Database
Be aware, that when using Homestead, your Laravel application will be running in local mode on it. Therefore you should set up a DB according to the config in the app/config/local/database.php file. If you use the Vagrant file in the root of the project, you would probably need to setup a DB following the app/config/database.php file.

### Environment Settings
Configuration is set through dotfiles. This is currently only implemented for your database settings. After creating your database, create a file in the root directory named `.env.local.php` and set your `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` values in the `$_ENV` global variable. Laravel will automatically load these files for you. 

### Seeds & Migrations
After getting your DB set up, you will need to run seeds and migrations on the DB. You can do this with `php artisan migrate --seed`
If you happen to be using homestead, make sure you aren't an idiot and running migrations on your local machine instead of on the VM (like @oflannabhra did)

-- This section may not be complete. So if any other contributors would like to elaborate...feel free.
