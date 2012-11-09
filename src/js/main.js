// Threespot Beer Fund App
// (c) 2011-2012 Threespot.

/*global require */
/*jslint browser:true */

define([
	"lib/knockout",
	"lib/underscore",
	"mod/contributor-ratings",
	"mod/fund-state"
],
function( ko, _, contributorRatings, FundState ) {
	"use strict";
	
	var donorList = (window.donorList || []),
		uiContributors = document.getElementById('contributors'),
		uiContribution = document.getElementById('contribution');

	// Format donor list data items.
	_.map(donorList, function(item) {
		var date = (item.lastDate ? item.lastDate.split('-') : [2012, 9, 1]);
		item.total = parseFloat(item.total || 0);
		item.lastAmount = parseFloat(item.lastAmount || 0);
		item.lastDate = new Date(parseInt(date[0], 10), parseInt(date[1], 10)-1, parseInt(date[2], 10));
		contributorRatings.addValue( item.total );
		return item;
	});
	
	// Apply breaks to contributor ratings.
	contributorRatings.setBreaks();

	if (uiContributors) {
		// Apply bindings to contributors table, if present within document.
		require(['mod/contributor-view'], function( ContributorViewModel ) {
			ko.applyBindings( new ContributorViewModel( donorList.slice() ), uiContributors );
		});
	}

	if (uiContribution) {
		// Apply bindings to contribution admin, if present within document.
		require(['mod/contribution-view'], function( ContributionViewModel ) {
			ko.applyBindings( new ContributionViewModel( donorList.slice() ), uiContribution );
		});
	}

	// Create fund-state visualization control.
	window.fund = new FundState(window.fundBalance, window.averageDeduction, 4);
});
