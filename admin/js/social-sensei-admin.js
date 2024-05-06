(function( $ ) {
	'use strict';

	document.addEventListener('DOMContentLoaded', function() {
		const tabButtons = document.querySelectorAll('.nav-tab');
		const sections = document.querySelectorAll('.settings-section');
	
		tabButtons.forEach(button => {
			button.addEventListener('click', function() {
				sections.forEach(section => {
					section.style.display = 'none';
				});
	
				const targetTab = this.getAttribute('data-tab-target');
				const targetSection = document.getElementById(targetTab);
	
				if (targetSection) {
					targetSection.style.display = 'block';
				}
	
				tabButtons.forEach(tab => {
					tab.classList.remove('nav-tab-active');
				});
				this.classList.add('nav-tab-active');
			});
		});
	});	
})( jQuery );
