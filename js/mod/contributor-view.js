// Threespot Beer Fund App
// Contributor table view model for Knockout.js.
// Manages the sortable table of contributors.

/*jslint browser:true */

define([
	"lib/knockout",
	"mod/contributor-ratings"
],
function( ko, contributorRatings ) {
	"use strict";
	
	var ContributorViewModel = function( donors ) {
		var self = this,
			sort = 1,
			sortDefaults = {
				'name': 1,
				'rating': -1,
				'last': -1
			};
			
		this.donorList = ko.observableArray(donors);
		this.sortField = ko.observable('');
		this.sortAsc = ko.observable(false);
		
		this.formatDate = function(date) {
			return (date.getMonth()+1) +'/'+ date.getDate() +'/'+ date.getFullYear();
		};
		this.formatAmount = function(amount) {
			return '$' + parseFloat(amount).toFixed(2);
		};
		this.formatRank = function(total) {
			return (1 + contributorRatings.plot( total )) * 16;
		};
		
		this.toggleSort = function(field) {
			// Reset default sort value when switching fields.
			// Otherwise, just toggle sort value when resetting a single field.
			if (self.sortField() !== field) {
				self.sortField(field);
				sort = sortDefaults[field] = (sortDefaults[field] || 1);
			} else {
				sort = -sort;
			}
			self.sortAsc(sort !== sortDefaults[field]);
		};
		
		this.sortName = function() {
			self.toggleSort('name');
			self.donorList.sort(function(a, b) {
				if (a.name > b.name) {
					return sort;
				} else if (a.name < b.name) {
					return -sort;
				}
				return 0;
			});
		};
		
		this.sortRating = function() {
			self.toggleSort('rating');
			self.donorList.sort(function(a, b) {
				return (a.total - b.total) * sort;
			});
		};
		
		this.sortLast = function() {
			self.toggleSort('last');
			self.donorList.sort(function(a, b) {
				var dif = (a.lastDate - b.lastDate);
				if (dif === 0) {
					dif = a.lastAmount - b.lastAmount;
				}
				return dif * sort;
			});
		};
		
		// Default to sorting by last contribution.
		this.sortLast();
	};
	
	return ContributorViewModel;
});