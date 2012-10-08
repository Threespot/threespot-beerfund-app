// Threespot Beer Fund App
// Contribution admin view model for Knockout.js.
// Manages the contribution admin interface.

/*jslint browser:true */

define([
	"lib/knockout"
], 
function( ko ) {
	"use strict";
	
	var ContributionViewModel = function(donors) {
		var self = this;
		
		// Selected donor/ID from existing list.
		this.donorList = donors;
		this.donor = ko.observable( donors.length ? donors[0] : null );
		this.donorId = ko.computed(function() {
			if (this.donorList.length) {
				return this.donor().id;
			}
			return '';
		}, this);
		
		// Type of donor (new or existing)
		this.donorType = ko.observable('existing');
		this.isExisting = ko.computed(function() {
			return this.donorType() === 'existing';
		}, this);
		
		// First and last name of a new donor.
		this.donorFirst = ko.observable('');
		this.donorLast = ko.observable('');
		
		// Amount of contribution.
		this.amount = ko.observable(0);
		
		// Reported errors within the form.
		this.errors = ko.observable('');

		// Validates and submits the form.
		this.submit = function() {
			var name = self.donorFirst() +' '+ self.donorLast(),
				amount = parseFloat(self.amount()),
				errors = [];
			
			if ( !self.isExisting() && (!self.donorFirst() || !self.donorLast()) ) {
				errors.push('enter a complete name');
			}
			
			if (isNaN(amount) || amount <= 0) {
				errors.push('enter a valid amount');
			}
			
			if (errors.length) {
				self.errors('Required: '+errors.join(', '));
			} else {
				self.errors('');
				document.getElementById('contribution').submit();
			}
		};
	};
	
	return ContributionViewModel;
});