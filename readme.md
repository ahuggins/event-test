# Events

Events is a web application built by the contributors listed on Github. Supposed to be a simple easy way to list the events of a city. Currently still a work in progress, but is being worked on (albeit slowly, because we all have day jobs). The main purpose of the project was to learn about the excellent Laravel framework, as well as practicing a Git workflow with multiple contributors. 


## Short Term To Do's

* Ability to add tags to an event when creating an event...using the events-tags-relation table
* Getting actual Date information on Events (no longer using the seed data)
* Add Mapping to an event
* Develop an Event View
* A way to update Tag options (Create Tag)
* Organizing events correctly when viewing "All Events". By "today", "Tomorrow","Next Week","Later"
* When user logs in, should show them a "Dashboard" with the events they are "watching." Then they can view All Events to add more to their watchlist. Watchlist could be used to send email notifications.
* Ability to add custom images to an event. Probably limit to a few. Sponsored events would be able to add more.

## Long Term To Do's

* Would be awesome to integrate with Facebook
	* Bring in events from Facebook data (pulling from people who have allowed access by Events)
	* Allow people to RSVP to an event using Facebook profile
* Add a "Specials" or "Deals" offering to the site
	* This could be handled as advertising (pay to have a special listed)
* Along the same lines, perhaps a "Job Listing" area as well
	* Pay to have job listed
* Notifications: Email and/or Text
	* Thinking each week an email is sent reminding people of events they have said they are going to, or would just be interested in


## Installing

You will need to have Composer installed. https://getcomposer.org/

Anytime you do a pull, remember to run Composer Update.

Familiarity with Laravel and running Migrations and Seeds is going to help.

A Vagrant file is provided, so you should be able to pull master, command line into the folder and run Vagrant Up...assuming you have Vagrant and Virtual Box installed: http://www.vagrantup.com/  and https://www.virtualbox.org/

I would also recommend using Homestead provided by Laravel. A great article on how to set that up is here: http://scotch.io/tutorials/php/getting-started-with-laravel-homestead    Recommended because you can run multiple sites on the one VM versus having a different VM for each site. Saves resources on your local computer.

Be aware, that when using Homestead, your Laravel application will be running in local mode on it. Therefore you should set up a DB according to the config in the app/config/local/database.php file. If you use the Vagrant file in the root of the project, you would probably need to setup a DB following the app/config/database.php file.

-- This section may not be complete. So if any other contributors would like to elaborate...feel free.