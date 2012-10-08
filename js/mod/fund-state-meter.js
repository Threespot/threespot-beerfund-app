// Threespot Beer Fund App
// Fund Meter.
// Handles rendering of the SVG pint glass meter.

/*jslint browser: true */

define([], function() {
	"use strict";
	
	var FundMeter = function() {
		// Create path element and add it to the SVG container.
		this.shape = document.createElementNS('http://www.w3.org/2000/svg', 'path');
		document.getElementById('fund-meter').appendChild( this.shape );
	};
	
	FundMeter.prototype = {
		//shape: null,
		
		// Interpolate a percentage shade between two colors.
		// Accepts two hex values formatted as "#000000", and a percent (0-1).
		// Returns a new hex string formatted as "#000000".
		interpolateColor: function( c1, c2, perc ) {
			// Collect individual R/G/B components for base color.
			var r = parseInt(c1.substr(1, 2), 16),
				g = parseInt(c1.substr(3, 2), 16),
				b = parseInt(c1.substr(5, 2), 16);

			// Creates a two-digit hexidecimal string component.
			function hex(val) {
				val = val.toString(16);
				return val.length < 2 ? '0'+val : val;
			}

			// Offset base color by percentage of delta with secondary color.
			r = Math.round(r+(parseInt(c2.substr(1, 2), 16)-r)*perc);
			g = Math.round(g+(parseInt(c2.substr(3, 2), 16)-g)*perc);
			b = Math.round(b+(parseInt(c2.substr(5, 2), 16)-b)*perc);

			// Return mean color.
			return '#' + hex(r) + hex(g) + hex(b);
		},

		// Redraws the SVG pint glass fill.
		render: function( perc ) {
			var draw = 'M',
				tY = 30,
				tL = 11,
				tR = 230,
				bY = 372,
				bL = 44,
				bR = 194,
				pts,
				i;

			// Adjust top coordinates by fill percentage.
			tY = bY - ((bY-tY) * perc);
			tL += (bL-tL) * (1-perc);
			tR -= (tR-bR) * (1-perc);

			// Define drawing points.
			pts = [
				[tL, tY],
				[bL, bY],
				[bL+1, bY+13, bL+((bR-bL)/2), bY+16],
				[bR-1, bY+13, bR, bY],
				[tR, tY]
			];

			// Assemble drawing command string.
			for (i = 0; i < pts.length; i++) {
				// Assign drawing action as linear or quadratic.
				if (i > 0) {
					draw += pts[i].length > 2 ? ' Q' : ' L';
				}
				// Insert drawing coordinates.
				draw += pts[i].join(' ');
			}
			draw += ' Z';

			// Set fill attribute and add to SGV container.
			this.shape.setAttribute('d', draw);
			this.shape.setAttribute('style', 'fill:'+ this.interpolateColor('#e37626', '#eebc31', 1-perc) +';');
		}
	};
	
	return new FundMeter();
});