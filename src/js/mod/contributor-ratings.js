// Threespot Beer Fund App
// Contributor Ratings.
// Manages a collection of contributor values and their distribution of range breaks.

/*jslint browser:true, vars:true */

define([
	"lib/underscore"
],
function( _ ) {
	"use strict";
	
	var distribution = {
		min: function(a) {
			return Math.min.apply(Math, a);
		},
		max: function(a) {
			return Math.max.apply(Math, a);
		},
		sort: function(a) {
			return a.sort(function(b, c) { return b - c; });
		},
		// Equal-interval distribution
		equalInterval: function(series, numClasses) {
			var breaks = [],
				low = this.min(series),
				interval = (this.max(series) - low) / numClasses,
				i;

			for (i = 0; i <= numClasses; i++) {
				breaks.push(low);
				low += interval;
			}

			return breaks;
		},
		// Quantile distribution
		quantile: function(series, numClasses) {
			series = this.sort(series);

			var breaks = [],
				inc = (series.length-1) / numClasses,
				i;

			for (i = 0; i <= numClasses; i++) {
				breaks.push( series[ Math.round(i * inc) ] );
			}

			return breaks;
		}
	};

	var RatingsManager = function() {
		this.reset();
	};
	
	RatingsManager.prototype = {
		// Resets all range configuration.
		reset: function() {
			this.breaks = [];
			this.values = [];
			this.maxValue = 0;	
		},
		
		// Adds a new value to the collection.
		addValue: function( val ) {
			val = parseInt( val, 10 );
			this.values.push( val );
			this.maxValue = Math.max( this.maxValue, val );
		},
		
		// Applies breaks across the collection.
		setBreaks: function() {
			var values = _.uniq( this.values );
			values = _.compact( values );
			values = distribution.quantile( values, 4 );
			this.breaks = _.uniq( values );
		},
		
		// Plots a value within the breaks series.
		plot: function( val ) {
			var i;
			for (i = this.breaks.length-1; i >= 0; i--) {
				if (val >= this.breaks[i]) {
					return i;
				}
			}
			return -1;
		}
	};
	
	return new RatingsManager();
});