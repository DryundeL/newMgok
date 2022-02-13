const groupSel = document.querySelector('#group-select')

if (groupSel){
	groupSel.addEventListener("change", function(){
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		urlParams.set('group', $(this).val());
		window.location.search = urlParams.toString()
	})
}
var pickSub = ""
const semestrSelect = document.querySelector('#semester-select')

semestrSelect.addEventListener("change", function(){
	/*const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('semester', $(this).val());
	window.location.search = urlParams.toString()*/
})

const monthSelect = document.querySelector('#month-select')

monthSelect.addEventListener("change", function(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('month', $(this).val());
	window.location.search = urlParams.toString()
})

const subjectSelect = document.querySelector('#subject-select')

subjectSelect.addEventListener("change", function(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('subject', $(this).val());
	window.location.search = urlParams.toString()
})

new Swiper('.image-slider', {
	freeMode: true, 
	slidesPerView: 4,
});


const table = document.querySelector(".table")

// const subjectsBtn = document.querySelectorAll('.slide-text')
// const caruselForm = document.querySelector('.carusel-form')

// subjectsBtn.forEach(btn => {
// 	btn.addEventListener("click", (event) => {
// 		// subjectsBtn.forEach(el => {
// 		// 	el.classList.remove("choosenSub")
// 		// })
// 		pickSub = event.target.innerHTML
// 		if(table.classList.contains("table-hide")) table.classList.remove("table-hide")

// 		// $(caruselForm).request('onChangeSubject', {
			
// 		// 	data: {
// 		// 		subject: event.target.innerText,
// 		// 		month: monthSelect.value,
// 		// 	}
// 		// })

// 		// const activeSubject = event.target.closest('.swiper-slide').classList.contains('choosenSub');
// 		// if (!activeSubject) {
// 		// 	const queryString = window.location.search;
// 		// 	const urlParams = new URLSearchParams(queryString);
// 		// 	urlParams.set('subject', event.target.innerText);
// 		// 	window.location.search = urlParams.toString()
// 		// }
		
		
		
// 	})
// })

const saveBtn = document.querySelector(".save-btn")
const cont = document.querySelector(".EJ-container")
		
		cont.addEventListener("keyup", (event) => {
			const target = event.target.closest(".date-row__input")
			const addTarget = event.target.closest(".addTaskMark")
			if (target) {
				if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
			}
			if (addTarget) {
				if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
			}
		})

function checkScroll(elem)
{
	if (elem.scrollWidth > elem.clientWidth)
	{
		elem.style.top = '-17px'
	}
	else {
		elem.style.top = ''
	}
}

const fios = document.querySelectorAll(".stud-count")
let count = 0

fios.forEach(el => {
	count++
})

const markFieldLayout = () => `
	<div class="add-field__plus">
		<input class="addTaskMark" type="text">
	</div>`
	
const marksFields = count => {
	let fields = "";
	for(let i = 0; i < count; i++){
		fields += markFieldLayout()
	}
	return fields
}


cont.addEventListener("click", (event) => {
	const target = event.target
	if (target.closest(".add-field__img")) {
		target.parentNode.parentNode.insertAdjacentHTML("beforebegin", `
		<div class="add-fields-col">
			<div class="addTaskHead">
				<div class="addTaskInput__div">
					<select class="selectTask">
						<option>Кр</option>
						<option>Пр</option>
						<option>Пара</option>
						<option>Экз</option>
						<option>Зач</option>
					<input class="addTaskDate" placeholder="Число:" type="text">
				</div>
				<div class="plus-img__div">
					<svg class="addTaskDelete" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15 6L6 15" stroke="#CACACA" stroke-width="2" stroke-linecap="round"/>
						<path d="M15 15L6 6" stroke="#CACACA" stroke-width="2" stroke-linecap="round"/>
					</svg>
				</div>
			</div>
			${marksFields(count)}
		</div>
		`)
		$(document).ready(function(){
			$('.addTaskDate').mask('AB', {'translation':{
				A: {pattern: /[0-3]/},
				B: {pattern: /[0-9]/}
			}})
		})
		$(document).ready(function(){
			$('.addTaskName').mask('AAAAA', {'translation':{
				A: {pattern: /[А-Яа-я/]/}
			}})
		})
	}
	if (target.closest(".addTaskDelete")) {
		
		const inputsArr = target.closest(".add-fields-col").querySelectorAll(".addTaskMark")
		let marksArr = []
		inputsArr.forEach(input => {
			marksArr.push(input.value)
		})
		const dayMark = target.closest(".add-fields-col").querySelector(".addTaskDate").value
		const name = target.closest(".add-fields-col").querySelector(".selectTask").value
		const uniqueId = target.closest(".addictional-head")?.querySelector(".addTaskInput__div")?.dataset?.uniqueId;
		const surnamesSpanArr = document.querySelectorAll(".stud-count")
		const surnamesArr = []
		surnamesSpanArr.forEach(surname => {
			surnamesArr.push(surname.innerText)
		})
		if (!uniqueId)
		{
			target.closest(".add-fields-col").remove()
		}
		else {
			$(target.closest(".addTaskDelete")).request('onDeleteAddict', {
				data: {
					unique_id: uniqueId
				}
			})
			target.closest(".add-fields-col").remove()
			const elem = document.querySelector('.dates')
	
			checkScroll(elem)
		}
		
	}
})


const tableScroollable = document.querySelector('#table')



const monthName = document.querySelector('.sem-head')
const group = document.querySelector('.select-group')

let year = new Date().getFullYear();
const months = {
	Январь: 1,
	Февраль: 2,
	Март: 3,
	Апрель: 4,
	Май: 5,
	Июнь: 6,
	Июль: 7,
	Август: 8,
	Сентябрь: 9,
	Октябрь: 10,
	Ноябрь: 11,
	Декабрь: 12,
}

let month = months[`${monthName.innerText}`];

if (month > 8) {
	year--
}

function daysInMonth (month, year) {
  return new Date(year, month, 0).getDate();
}

if (saveBtn) {
	saveBtn.addEventListener('click', (event) => {
		const days = document.querySelectorAll('.date-head') 	
		const subject = document.querySelector('.choosenSub')
	
		//-- marks start
		const inputs = Array.from(document.querySelectorAll('.date-col .date-row__input'))
		const marksObjectCreate = input => {
			const headerColumn = input.closest('.date-col')?.querySelector('.date-head');
			const mark = input.value;
			const date = year + '.' + month + '.' + headerColumn.innerText;
			const numberLesson = headerColumn?.dataset?.numberLesson;
			const fio = fios[$(input).index() - 1]?.textContent;
			
			return {
				mark, 
				date,
				numberLesson,
				fio
			}
		}
		const marks = inputs.map(input => marksObjectCreate(input))
		//-- marks end
		
		//-- additional start
		const additionalInputs = Array.from(document.querySelectorAll('.add-fields-col .addTaskMark'));
		let uniqueId = Date.now();
		
		const marksAdditionalObjectCreate = input => {
			const headerColumn = input.closest('.add-fields-col')?.querySelector('.addTaskInput__div');
			const mark = input.value;
			const date = year + '.' + month + '.' + headerColumn.querySelector('input').value;
			const event = headerColumn.querySelector('.selectTask').value;
			const index = $(input).parent().index();
			const fio = fios[index - 1]?.textContent;
			
			if (index - 1 === 0) {
				uniqueId = Date.now();
			}
			const markUniqueId = headerColumn.dataset.uniqueId ?? uniqueId;
			
			return {
				mark, 
				date,
				event,
				fio,
				unique_id: markUniqueId
			}
		}

		const additionalMarks = additionalInputs?.map(input => marksAdditionalObjectCreate(input));
		//-- additional end
		
		//-- final start
		const finalInputs = Array.from(document.querySelectorAll('.res-cell__input'));
		const marksFinalObjectCreate = input => {
			const mark = input.value;
			const fio = fios[$(input).index() - 1]?.textContent;
			const monthTitle = document.querySelector('.sem-head').textContent;
			
			
			return {
				mark, 
				fio,
				month: monthTitle
			}
		}

		const finalMarks = finalInputs?.map(input => marksFinalObjectCreate(input))
		//-- final end
		
		//-- validate start
		const additionalDates = Array.from(document.querySelectorAll('.addTaskDate'));
		const marksInputs = Array.from(document.querySelectorAll('.date-row__input, .addTaskMark'));
		
		const isAdditionalValidate = validationAdditionalsDates(additionalDates);
		const isMarksValidate = validationAllowedMarks(marksInputs);
		//-- validate end

		if (isAdditionalValidate && isMarksValidate) {
			$(saveBtn).request('onSaveMarks', {
				data: {
					subject: subject.innerText,
					group: group.value,
					marks: marks,
					addictive: additionalMarks,
					final: finalMarks,
				}
			})
		}
	})
}



function validationAdditionalsDates(additionalDates) {
	let errors = 0;

	additionalDates.forEach(input => {
		const daysCount = daysInMonth (month, year);
		const day = input.value;
		
		if (day < 0 || day > daysCount || day === '00') {
			input.classList.add('validation-field');
			errors++;
		} else {
			input.classList.remove('validation-field');
		}
	})
	
	return errors === 0;
}

function validationAllowedMarks(markInputs) {
	let errors = 0;

	const allowedMarks = ['2', '3', '4', '5', 'нб'];
	markInputs.forEach(input => {
		const value = input.value;
		const isValidate = allowedMarks.includes(value) || value === '';
		
		console.log(value)
		if (isValidate) {
			input.classList.remove('validation-field');
		} else {
			input.classList.add('validation-field');
			errors++;
		}
	})
	
	return errors === 0;
}



document.addEventListener("DOMContentLoaded", function(){
	const body = document.querySelector("body")
	const subjArr = document.querySelectorAll(".slide-text")
	
	const elem = document.querySelector('.dates')
	
	checkScroll(elem)
	
	const saveBtn = document.querySelector(".save-btn")
	const cont = document.querySelector(".EJ-container")
	
	cont.addEventListener("keyup", (event) => {
		const target = event.target.closest(".date-row__input");
		const addTarget = event.target.closest(".addTaskMark");
		const changeDate = event.target.closest('.addTaskInput__div');
		const finalMark = event.target.closest('.res-cell__input');
		
		if ((target || addTarget || changeDate || finalMark) && saveBtn.classList.contains("hide")) {
			saveBtn.classList.remove("hide")
		}
	})
	
	cont.addEventListener("click", (event) => {
		const target = event.target;

		if (target.classList.contains('selectTask') && saveBtn.classList.contains("hide")) {
			target.addEventListener('change', () => {
				saveBtn.classList.remove("hide")
			})
		}
	})
	
	// subjArr[0].classList.add("choosenSub")
	// pickSub = subjArr[0].innerHTML
	// $(body).request('onLoadPage', {
	// 	data: {
	// 		month: monthSelect.value,
	// 		subject: pickSub
	// 	}
	// })
})


