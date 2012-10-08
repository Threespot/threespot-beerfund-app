beerfund
========

The Threespot Beer Fund app. Built using Require.js + Knockout on the frontend, and PHP for the backend.

Build manifest is included for optimizing script loads (most application modules will be concatenated into the "main" module). To build, run the following from the root application directory (requires Node.js):

	node js/app.r.js -o js/app.build.js
	
