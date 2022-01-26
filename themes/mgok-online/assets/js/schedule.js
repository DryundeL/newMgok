$(document).ready(function() {
	(function( $ ) {
	  $(function() {
	    $('.cab__input').mask('000')
	   
	
	    // $('pre').each(function(i, e) {hljs.highlightBlock(e)});
	  });
	})(jQuery);
})

let remove = document.querySelectorAll(".remove__div")
const urlParams = document.URL
console.log(urlParams);

if(urlParams=="https://new.mgok.moscow/raspisanie-klassa"){
	let image = document.createElement("img");
	image.setAttribute('src', './themes/mgok-online/assets/icons/remove.png')
	image.setAttribute('class', 'remove-event')
	image.setAttribute('id', 'remove-event')
	remove.innerHTML = image;
}

// schedule.addEventListener('click', event => {
// 	const target = event.target
	
// 	if (target.closest('.schedule__element-li')) {
// 		const form = target.closest('.schedule__lessons-list').lastElementChild
// 		const addBtn = form.querySelector('#add-event-button')
		
// 		pluses.forEach(plus => {
// 			plus.parentNode.style.display = 'none'
// 		})
// 		form.style.display = "flex"
		
// 		cancelBtnOnClick()
// 		validationFields(form, addBtn)
// 	}
// })


// individual raspisanie
// change student
$('#student-select').change(function () {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('student', $(this).val());
	window.location.search = urlParams.toString()
})



$('.schedule').on('click', '.schedule__element-li', function() {
	
	// hide all plus divs
	$('.event-plus__div').each((i, plus) => $(plus).hide())
	// form addEvent
	const formWrapper = $(this).next()
	const form = $(formWrapper.children()[0])
	formWrapper.show()
	$('.time-field').mask('00:00');
	
	// form send
	form.submit(function (e) {
		e.preventDefault();
		
		const day = form.data('day')
		const student = $('.student__select').val()
		const inputs = form.find('.field')
		const alertEmpty = form.find('#alert-empty')
		const alertWrong = form.find('#alert-wrong')
		let validation = true
		
		alertEmpty.removeClass('alert__span_active')
		alertWrong.removeClass('alert__span_active')
		
		// validation
		inputs.each(function() {
			
			if (!$(this).val()) {
				alertEmpty.addClass('alert__span_active')
				validation = false
			}
			
			else if ($(this).val() == '00:00'){
				alertWrong.addClass('alert__span_active')
				validation = false
			}
			
			else if ($(this).hasClass('time-field') && !checkTimeFields($(this).val())) {
				alertWrong.addClass('alert__span_active')
				validation = false
			}
			
			else if (!checkTimeFields(inputs[0].value, inputs[1].value)) {
				alertWrong.addClass('alert__span_active')
				validation = false
			}
		})
			// form send
			if (validation) {
				form.request('onAddEvent', {
					data: { 
						date: day, 
						student: student,
					},
			    // update: {'schedule/schedule-edit': '#schedule'},
				})
				formWrapper.hide()
			}
		})
	
	// cancel form
	$('.cancel__button').click(() => {
	  formWrapper.hide()
	  $('.event-plus__div').each((i, plus) => $(plus).show())
	});
});




$('.schedule').on('click', '#remove-event', function() {
	$(this).closest('li').remove()
});

function checkTimeFields(timeString, secondTimeString) {
	const hours = parseInt(timeString.split('').slice(0, 2).join(''))
	const minutes = parseInt(timeString.split('').slice(3, 5).join(''))
	if (!secondTimeString) {
		if (timeString.length <= 4) return false
		else {
			if (hours > 23 || hours <= 0) return false
			else if (minutes >= 60 || minutes < 0) return false
			else return true
		}
	}
	else {		
		const secondHours = parseInt(secondTimeString.split('').slice(0, 2).join(''))
		const secondMinutes = parseInt(secondTimeString.split('').slice(3, 5).join(''))
		
		if (hours > secondHours || (hours >= secondHours && minutes >= secondMinutes))
			return false
		else return true
	}
}

$('main').on('click', '.change-week', function() {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const numberWeek = urlParams.get('number_of_week') ?? 0;
	const newNumberWeek = $(this).hasClass('next-week') ? parseInt(numberWeek) + 1 : parseInt(numberWeek) - 1
	console.log(newNumberWeek)
	if (newNumberWeek >= 0 && newNumberWeek < 4) {
		urlParams.set('number_of_week', newNumberWeek);
		window.location.search = urlParams.toString()
	}
})

const input = $('.event-target__input')
const searchForm = $('.schedule-search__wrapper')
const resList = $('.schedule-search__hints')
const select = $('.event-target__select')

resList.on('click', 'li', function(e) {
	console.log($(this))
	input.val($(this).text())
})

input.on('focusin', function() {
	resList.addClass('schedule-search__hints_active')
	
	$('.schedule-search__hints li').each(function(li) {
		$(this).on('click', function(event) {
			input.val($(event.target).text())
		})
	})
})

input.on('focusout', function(e) {
	setTimeout(() => resList.removeClass('schedule-search__hints_active'), 200)
})

searchForm.on('keyup', function() {
	resList.html('')
	$(this).request('onPromptSearch', {
		data: { 
			text: input.val(),
		},
		success: function(data) {
    	this.success(data).done(function() {
    		$(data).each((index, prompt) => {
    			const text = prompt.full_name ?? prompt.class
					resList.append(`<li>${text}</li>`)
    		})
	    });
		}
	})
})

searchForm.on('submit', function(e){
	e.preventDefault();
	
	if (input.val() === '') {
		alert('Поле поиска не может быть пустым');
	} else {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		urlParams.set('role', select.val());
		urlParams.set('text',	input.val());
		window.location.search = urlParams.toString()	
	}
	// $(this).request('onSearch', {
	// 	data: {
	// 		text: input.val(),
	// 		role: select.val()
	// 	},
	// 	// update: {'schedule/schedule-edit': '#schedule'}
	// })
})