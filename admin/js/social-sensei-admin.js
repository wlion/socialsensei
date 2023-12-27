(function( $ ) {
	'use strict';

	document.addEventListener('DOMContentLoaded', function() {
		const tabButtons = document.querySelectorAll('.nav-tab');
		const sections = document.querySelectorAll('.settings-section');
	
		tabButtons.forEach(button => {
			button.addEventListener('click', function() {
				// Hide all sections
				sections.forEach(section => {
					section.style.display = 'none';
				});
	
				// Get the target tab and corresponding section
				const targetTab = this.getAttribute('data-tab-target');
				const targetSection = document.getElementById(targetTab);
	
				// Show the selected section
				if (targetSection) {
					targetSection.style.display = 'block';
				}
	
				// Update active state for tabs
				tabButtons.forEach(tab => {
					tab.classList.remove('nav-tab-active');
				});
				this.classList.add('nav-tab-active');
			});
		});
	});	

})( jQuery );
