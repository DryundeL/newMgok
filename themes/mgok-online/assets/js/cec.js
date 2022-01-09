document.addEventListener("DOMContentLoaded", () => {
	const tds = document.querySelectorAll('tr td')
	
	tds.forEach(td => {
		if (td.classList.contains('weight-cell') || td.classList.contains('res-cell')) {
			if (td.innerHTML % 1 === 0) td.innerHTML = parseInt(td.innerHTML)
		}
	})
});

let blocks = document.querySelectorAll(".block")

let bh1 = document.querySelector("#block1")
let bh2 = document.querySelector("#block2")
let bh3 = document.querySelector("#block3")
let bh4 = document.querySelector("#block4")
let bh5 = document.querySelector("#block5")
let bh6 = document.querySelector("#block6")
let bh7 = document.querySelector("#res-block")

let tableHead = document.querySelector(".res-table-head")

let allBlocks = document.querySelectorAll(".blocks_tbody")
let block1 = document.querySelector(".block1")
let block2 = document.querySelector(".block2")
let block3 = document.querySelector(".block3")
let block4 = document.querySelector(".block4")
let block5 = document.querySelector(".block5")
let block6 = document.querySelector(".block6")
let resBlock = document.querySelector(".res-block")

let saveBtn = document.querySelector(".save-btn")

blocks.forEach(elem => {
	elem.addEventListener("click", event => {
		blocks.forEach(item => item.classList.remove("choosen"))
		switch(elem.id){
			case "block1":{
				bh1.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block1.classList.remove("hide")
				break;
			}
			case "block2":{
				bh2.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block2.classList.remove("hide")
				break;
			}
			case "block3":{
				bh3.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block3.classList.remove("hide")
				break;
			}
			case "block4":{
				bh4.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block4.classList.remove("hide")
				break;
			}
			case "block5":{
				bh5.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block5.classList.remove("hide")
				break;
			}
			case "block6":{
				bh6.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block6.classList.remove("hide")
				break;
			}
			case "res-block":{
				bh7.classList.add("choosen")
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				if(!tableHead.classList.contains("hide")) tableHead.classList.add("hide")
				resBlock.classList.remove("hide")
				break;
			}
		}
	})
})

let inputs = document.querySelectorAll(".input-field__cell")

inputs.forEach(el => {
	el.addEventListener("keyup", event => {
		el.parentNode.nextElementSibling.innerHTML = el.value * el.parentNode.parentNode.childNodes[5].innerHTML
		if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
	})
})
saveBtn.addEventListener("click", event => {
	if(!saveBtn.classList.contains("hide"))saveBtn.classList.add("hide")
	
	const form = document.querySelector("#kek-form")
	const section1Inputs = Array.from(document.querySelectorAll('#section1 input'))
	const section1Objects = section1Inputs.map(input => ({ 
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const section2Inputs = Array.from(document.querySelectorAll('#section2 input'))
	const section2Objects = section2Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const section3Inputs = Array.from(document.querySelectorAll('#section3 input'))
	const section3Objects = section3Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const section4Inputs = Array.from(document.querySelectorAll('#section4 input'))
	const section4Objects = section4Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block1PenPointsInputs = Array.from(document.querySelectorAll('#block1-penalty-points input'))
	const block1PenPointsObjects = block1PenPointsInputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block2Inputs = Array.from(document.querySelectorAll('#block2 input'))
	const block2Objects = block2Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block2PenPoints = Array.from(document.querySelectorAll('#block2-penalty-points input'))
	const block2PenPointsObjects = block2PenPoints.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block3Inputs = Array.from(document.querySelectorAll('#block3 input'))
	const block3Objects = block3Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block3PenPoints = Array.from(document.querySelectorAll('#block3-penalty-points input'))
	const block3PenPointsObjects = block3PenPoints.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block4Inputs = Array.from(document.querySelectorAll('#block4 input'))
	const block4Objects = block4Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block4PenPoints = Array.from(document.querySelectorAll('#block4-penalty-points input'))
	const block4PenPointsObjects = block4PenPoints.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
		
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block5Inputs = Array.from(document.querySelectorAll('#block5 input'))
	const block5Objects = block5Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block5PenPoints = Array.from(document.querySelectorAll('#block5-penalty-points input'))
	const block5PenPointsObjects = block5PenPoints.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block6Inputs = Array.from(document.querySelectorAll('#block6 input'))
	const block6Objects = block6Inputs.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)

	const block6PenPoints = Array.from(document.querySelectorAll('#block6-penalty-points input'))
	const block6PenPointsObjects = block6PenPoints.map(input => ({
			id: input.closest('tr').firstElementChild.textContent,
			name: input.dataset.name,
			value: input.value,
			
			ball: input.parentNode.nextElementSibling.textContent
		})
	)
	
	$(form).request('onEditKek', {
		data: {
			section1: section1Objects,
			section2: section2Objects,
			section3: section3Objects,
			section4: section4Objects,
			block1PenPoints: block1PenPointsObjects,
			block2: block2Objects,
			block2PenPoints: block2PenPointsObjects,
			block3: block3Objects,
			block3PenPoints: block3PenPointsObjects,
			block4: block4Objects,
			block4PenPoints: block4PenPointsObjects,
			block5: block5Objects,
			block5PenPoints: block5PenPointsObjects,
			block6: block6Objects,
			block6PenPoints: block6PenPointsObjects,
		}
		
	})
	
	// $(this).request('onSearch', {     block2-penalty-points
	// 	data: {
	// 		text: input.val(),
	// 		role: select.val()
	// 	},
	// 	// update: {'schedule/schedule-edit': '#schedule'}
	// })
})




// $('document.body').on('click', '#save-btn', function() {
	
// 	// form send
// 	// form.submit(function (e) {
// 	// 	e.preventDefault();
		
// 		const section1Inputs = $('#section1')
// 		cosnole.log(section1Inputs)
// 		const razdel1Objects = razdel1Input.map(input => { name, value })
		
		
// 		// form send
// 		// form.request('onEditKek', {
// 		// 	data: { 
// 		// 		razdel1Objects: razdel1Objects, 
// 		// 		student: student,
// 		// 	},

// 		// })
	
// });