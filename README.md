#Threespot Beer Fund

The Threespot Beer Fund app. Built using Require.js + Knockout with a simple PHP backend.

##Versions

- `src/` : All raw source files for development.
- `dist/` : Built application, with require modules concatenated and minified.

All development should be done within `src/`, then built (see instructions below) and the `dist/` files deployed.

##Installation

1. Import `src/bf-schema.sql` into a new MySQL database. Default app config:
	- DB name: "beerfund"
	- user: "root"
	- pass: "root"

2. You should be up and running if you used the default app config. Otherwise, adjust the database connection info in `src/bf-connection.php`.

##Build
	
The application builds using Grunt's Require.js packager. You'll need to install these tools once before making your first build. First, `cd` into the Beerfund root directory and then run:

	npm install -g grunt
	npm install

Then to create builds, `cd` into the Beerfund root directory and run:

	grunt

Building the application will assemble Require.js modules into named, minified, and concatenated scripts, and copy all built assets over into the `dist/` directory.

*Note: the Require.js build process is **NOT** the same as simply minifying and concatenating scripts the way you would with a service such as Rails' asset pipeline. Require's build process also assigns unique IDs to each module based on the script file it was pulled from. Using other min/concat services will require that you manually assign module IDs based on filename.*