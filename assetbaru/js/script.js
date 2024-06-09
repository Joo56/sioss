$(document).ready(function(){
	$('.dtpickerdemo').datetimepicker({
			// defaultDate: new Date(),
			format:'YYYY-MM-DD',
		icons: {
		 time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
		},
	});	
	
	$('select.select2').each(function () {
		$(this).select2({
			dropdownParent: $(this).parent()
		});
	});
	
	$('select').on('change', function() {
        $(this).valid();
    });	
	
	$('select.select2-multi').each(function () {
		$(this).select2({
			dropdownParent: $(this).parent(),
			matcher: matchCustom,
			templateResult: formatCustom
		});
		
		function stringMatch(term, candidate) {
			return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
		}
		
		function matchCustom(params, data) {
			// If there are no search terms, return all of the data
			if ($.trim(params.term) === '') {
				return data;
			}
			// Do not display the item if there is no 'text' property
			if (typeof data.text === 'undefined') {
				return null;
			}
			// Match text of option
			if (stringMatch(params.term, data.text)) {
				return data;
			}
			// Match attribute "data-foo" of option
			if (stringMatch(params.term, $(data.element).attr('data-foo'))) {
				return data;
			}
			// Return `null` if the term should not be displayed
			return null;
		}
		
		// function get_value(state){
			// return state.text;
		// }

		function formatCustom(state) {
			return $(
				'<div>' + state.text +' - '+ $(state.element).attr('data-foo')+ '</div>'
			);
		}
			
	});
	
	$(document).on('select2:close', '.my-select2', function (e) {
		var evt = "scroll.select2"
		$(e.target).parents().off(evt)
		$(window).off(evt)
	})
	
});
	// SELECT2
	
	// END SELECT 2
	
	function reset_validate(id){
		$(id).validate().resetForm();
	}
	
	function convertToAngka(rupiah){
		return parseInt(rupiah.replace(/[^0-9]/g, ''), 10);
	}
	function convertToRupiah(angka){
		let num = angka;
		let rupiahFormat = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
		return rupiahFormat; 
		
		// var rupiah = '';		
		// var angkarev = angka.toString().split('').reverse().join('');
		// for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		// return rupiah.split('',rupiah.length-1).reverse().join('');
	}
	// Membersihkan inputan
	// $(this).closest('form').find("input[type=text], textarea").val("");
	function input_bersih(){
		$('input[type=text], textarea').val("");
	}
	
	// MEMBERI EFEK SPLASH PADA BUTTON (HANYA BISA DIGUNAKAN SEKALI PADA HALAMAN)
	var ableToClick = true;
	function buttonClick(){
		if(!ableToClick) return;
		ableToClick=false;

		let splash = document.getElementById("splash");
		splash.style.width="80px";
		splash.style.height="80px";

		setTimeout(function(){
		splash.style.opacity="0";
		}, 400);

		setTimeout(function(){
		splash.style.transitionDuration="0s";
		}, 1000);

		setTimeout(function(){
		splash.style.width="0";
		splash.style.height="0";
		splash.style.opacity="1";
		}, 1100);

		setTimeout(function(){
		ableToClick = true;
		splash.style.transitionDuration=".5s";
		}, 1200);
	}

		
	
	
	
	
	
	