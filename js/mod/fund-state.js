// Threespot Beer Fund App
// Beer Fund state manager.
// Tracks balance, average deduction, and outlook weeks; manages visual display accordingly.

/*jslint browser:true */

define([
	"mod/fund-state-meter"
],
function( fundMeter ) {
	"use strict";
	
	var FundState = function( balance, deduction, weeks ) {
		this.balance = ( balance || 0 );
		this.averageDeduction = ( deduction || 40 );
		this.outlookWeeks = ( weeks || 4 );
		this.update();
	};
	
	FundState.prototype = {
		setBalance: function( balance ) {
			this.balance = balance;
			this.update();
		},
		setAverageDeduction: function( deduction ) {
			this.averageDeduction = deduction;
			this.update();
		},
		setOutlookWeeks: function( weeks ) {
			this.outlookWeeks = weeks;
			this.update();
		},
		update: function() {
			var balance = parseFloat(this.balance),
				full = parseInt(this.averageDeduction, 10) * parseInt(this.outlookWeeks, 10);

			// Render pint glass meter.
			fundMeter.render( Math.min(Math.max(0, balance), full) / full );
			
			// Format the fund balance display.
			balance = balance.toFixed(2).split('.');
			document.getElementById('fund-balance').innerHTML = '$'+ balance[0] +'<sup>.'+ balance[1] +'</sup>';
		}
	};
	
	return FundState;
});