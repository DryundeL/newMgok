let blocks = document.querySelectorAll(".block")

let tableHead = document.querySelector(".res-table-head")

let allBlocks = document.querySelectorAll(".blocks_tbody")
let block1 = document.querySelector(".block1")
let block2 = document.querySelector(".block2")
let block3 = document.querySelector(".block3")
let block4 = document.querySelector(".block4")
let block5 = document.querySelector(".block5")
let block6 = document.querySelector(".block6")
let resBlock = document.querySelector(".res-block")

blocks.forEach(elem => {
	elem.addEventListener("click", event => {
		switch(elem.id){
			case "block1":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block1.classList.remove("hide")
				break;
			}
			case "block2":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block2.classList.remove("hide")
				break;
			}
			case "block3":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block3.classList.remove("hide")
				break;
			}
			case "block4":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block4.classList.remove("hide")
				break;
			}
			case "block5":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block5.classList.remove("hide")
				break;
			}
			case "block6":{
				allBlocks.forEach(el => {
					if(!el.classList.contains("hide")) el.classList.add("hide")
				})
				tableHead.classList.remove("hide")
				block6.classList.remove("hide")
				break;
			}
			case "res-block":{
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
	})
})